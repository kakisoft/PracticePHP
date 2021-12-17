【MySQL・Laravel】検索時、濁点や大文字・小文字が識別されない問題の対応

____________________________________________________________

MySQL を使っていると、以下のような現象に遭遇する事がある。  

### SQL
```sql
select
  id
 ,name
 ,name_kana
from
 customers
where  1=1
  and  name_kana like '%たざき%'
```

### 出力結果

|  id   |  name   |  name_kana  |
|:------|:--------|:------------|
|  1    |  田崎　浩平  |  たざき　こうへい   |
|  2    |  田崎　耕平  |  たさき　こうへい   |


こんな感じで、「たざき」と検索すると、「たさき」も対象となってしまう。  

ちなみに、Laravel ソースと、migration 時に生成される MySQL 定義情報は、こんな感じ。  

### Laravel ソース
```php
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('name_kana', 80);
            $table->timestamps();
            $table->softDeletes();
        });
    }
```

### MySQL 定義
```sql
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_kana` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

## 原因
「collation」という、文字列を比較するためのルール（COLLATE）があり、デフォルトでは「utf8_unicode_ci」が設定されるのが原因らしい。  


|        collation       |    説明    |
|:-----------------------|:--------------------------------------------------------------------------------------------------------------------------|
|  utf8mb4_unicode_ci    |  アルファベットの大文字小文字を区別せず、全角半角も混同する。ひらがな・かたかなの大文字小文字も区別しない。  |
|  utf8mb4_general_ci    |  アルファベットの大文字小文字を区別しなくなる。それ以外は区別される。  |
|  utf8mb4_bin           |  完全に文字の一致を照合する。  |

参考サイト  
[MySQLの文字コード事情](https://www.slideshare.net/tmtm/mysql-62004569)  
[laravel使うならmysqlのcollation指定はutf8mb4_binにしておくべき](https://zudoh.com/mysql/should-use-collation-utf8mb4_bin-as-default)  
[MySQLの文字コードとCollation](https://qiita.com/tfunato/items/e48ad0a37b8244a788f6)  
[MySQL の utf8mb4 の文字照合順序まとめ](https://zenn.dev/zoeponta/articles/090c68ba820a24)  

## 結論
utf8mb4 を使おう


## 対応策１：database.php を修正（要リフレッシュ）
「database.php」の内容を修正。  
その後、リフレッシュ。  
（この設定を変えただけだと、以降に作成されたテーブルのみが設定変更後の対象となる）  
全テーブルを対象にできる。  

```php
  'collation' => 'utf8mb4_unicode_ci',
                      ↓
  'collation' => 'utf8mb4_bin',
```

「php artisan migrate:fresh」等のコマンドが必要になるので、データの退避が必要。 


## 対応策２：MySQL の ALTER TABLE コマンドを使用
ALTER TABLE コマンドを使用する。  
全てを一括で変更する事は出来ないので、テーブル個別に設定。  
```sql
ALTER TABLE customers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
```

## 対応策３：Laravel で個別に設定
テーブルごとに個別に定義する事ができるみたい。  
<https://readouble.com/laravel/8.x/ja/migrations.html>  

とはいえ、そんな場面が必要なのだろうか。  
database.php でまとめてやってしまった方がいい気がする。


## 変更後
最終的に、テーブル定義にて「COLLATE=utf8mb4_bin」となっていることが確認できればOKです。
```sql
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL,
  `name_kana` varchar(80) COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
```


