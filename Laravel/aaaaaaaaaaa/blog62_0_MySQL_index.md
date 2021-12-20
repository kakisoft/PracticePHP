【MySQL・Laravel】意図されないインデックスが使用され、update時にロックがかかってしまった時の対応

____________________________________________________________

高速化のために複数のインデックスを作成するも、それが意図通りに動作しないケースがあるどころか、思わぬ弊害を招いてしまう事があります。  

以下、実験した内容。  
（実プロダクトのコードではなく、ブログを書くために用意したサンプルですが）  

### Laravel ソース
```php
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->default(0);
            $table->string('code', 80);
            $table->string('name', 100);
            $table->string('sub_name', 50)->nullable();
            $table->integer('price')->default(0);
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('tax_rate_type')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("CREATE INDEX items_index_1 on items (owner_id, deleted_at)");
        DB::statement("CREATE INDEX items_index_2 on items (owner_id, category_id, deleted_at)");
        DB::statement("CREATE INDEX items_index_3 on items (owner_id, category_id, tax_rate_type, deleted_at)");
    }
```

### DB 定義
```sql
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) NOT NULL DEFAULT '0',
  `code` varchar(80) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `sub_name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned DEFAULT NULL,
  `tax_rate_type` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `existence` tinyint(1) GENERATED ALWAYS AS ((case when isnull(`deleted_at`) then 1 else NULL end)) STORED,
  PRIMARY KEY (`id`),
  KEY `items_index_1` (`owner_id`,`deleted_at`),
  KEY `items_index_2` (`owner_id`,`category_id`,`deleted_at`),
  KEY `items_index_3` (`owner_id`,`category_id`,`tax_rate_type`,`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
```

インデックス１：owner_id, deleted_at  
インデックス２：owner_id, category_id, deleted_at  
インデックス３：owner_id, category_id, tax_rate_type, deleted_at  

### レコード
※検証に無関係な部分はカットしています  

|  id   |  owner_id  |  category_id  |  tax_rate_type  |
|:------|:-----------|:--------------|:----------------|
|  1    |  1         |  1            |  0              |
|  2    |  1         |  1            |  0              |
|  3    |  1         |  1            |  0              |
|  4    |  1         |  1            |  0              |
|  5    |  1         |  1            |  0              |
|  6    |  1         |  1            |  0              |
|  7    |  1         |  2            |  0              |
|  8    |  1         |  3            |  0              |
|  9    |  1         |  4            |  0              |
|  10   |  2         |  1            |  0              |
|  11   |  2         |  1            |  0              |
|  12   |  2         |  1            |  0              |
|  13   |  3         |  1            |  1              |
|  14   |  3         |  1            |  1              |
|  15   |  3         |  1            |  1              |


#### インデックス確認：１
```sql
explain
select
 *
from
 items
where  1=1
  and  deleted_at is null
  and  owner_id = 1
```

※検証に無関係な部分はカットしています  

|  id   |  select_type  |  possible_keys                              |  key            |
|:------|:--------------|:--------------------------------------------|:----------------|
|  1    |  SIMPLE       |  items_index_1,items_index_2,items_index_3  |  items_index_1  |


#### インデックス確認：２
```sql
explain
select
 *
from
 items
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
```

|  id   |  select_type  |  possible_keys                              |  key            |
|:------|:--------------|:--------------------------------------------|:----------------|
|  1    |  SIMPLE       |  items_index_1,items_index_2,items_index_3  |  items_index_1  |


#### インデックス確認：３
```sql
explain
select
 *
from
 items
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
  and  tax_rate_type = 0
```

|  id   |  select_type  |  possible_keys                              |  key            |
|:------|:--------------|:--------------------------------------------|:----------------|
|  1    |  SIMPLE       |  items_index_1,items_index_2,items_index_3  |  items_index_1  |


## 結果について考察
「インデックス確認：１」の場合は、「items_index_1（インデックス１）」が効き、  
「インデックス確認：２」の場合は、「items_index_2（インデックス２）」が効き、  
「インデックス確認：３」の場合は、「items_index_3（インデックス３）」が効く、  
と動いてほしかったが、実際は全てのパターンにて「items_index_1（インデックス１）」が効いている。  

検索対象のカラムを絞れば、最適なインデックスを適用してくれるのかと思いきや、どうやらオプティマイザが自動で選択しているようで、設計者の意図とは異なった挙動となる。  
（恐らく、データの過多が関係していると思われます。）  

「オプティマイザが最速と判断したパターンが選択されているので、特に問題ないのでは？」と思いきや、意外な所で弊害が出る事がある。  

## update 文でも使用されるインデックス
MySQL において、インデックスは select 文の時のみ使用されるかと思いきや、update 文を発行する時にも使用される。  

例えば、こんな感じ。  

```sql
explain
update  items
   set  price = 100
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
  and  tax_rate_type = 0
```

|  id   |  select_type  |  possible_keys                              |  key            |
|:------|:--------------|:--------------------------------------------|:----------------|
|  1    |  SIMPLE       |  items_index_1,items_index_2,items_index_3  |  items_index_1  |


かなりデータの絞り込みが出来ているにもかかわらず、範囲の広い「items_index_1（owner_id, deleted_at）」のインデックスが適用されている。  

update 文を発行する時、その範囲がロックされ、場合によっては簡単にデッドロックが引き起こされてしまう。  


## update 時のロックの挙動
MySQL では、特定レコード（範囲）にて、複数の更新命令が走った場合、２つ目までは排他制御が働くものの、３つ目以降はデッドロック扱いにしてエラーとなる、らしい。  
具体的には、こういった挙動をする。  


（特定レコードへの処理）  
update文 A  
update文 B  
update文 C  
update文 D  

　　↓  

update文 A：処理中  
update文 B：待機  
update文 C：待機  
update文 D：待機  

　　↓  

update文 A：完了  
update文 B：処理中  
update文 C：エラー（デッドロックエラー）  
update文 D：エラー（デッドロックエラー）  


こんな感じで、ウェイトが２つ以上ある場合、２つ目以降は全てエラーとして扱われる。  
「デッドロック」と銘打っているものの、実際は単にエラーとして排除しているみたい。  

ちなみに、エラーメッセージはこんな感じになります。
```
Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction (SQL:  update items ...
```

**参考**  
<https://yoku0825.blogspot.com/2012/07/deadlock-found-when-trying-to-get-lock.html>  
<https://bugs.mysql.com/bug.php?id=69835>  
<https://bugs.mysql.com/bug.php?id=43210>  
<https://bugs.mysql.com/bug.php?id=43591>  


以上のように、条件が揃うと簡単にエラーが引き起こされるので、インデックスによる範囲の絞り込みは、必要最小限に留める必要がある。（update 文の場合は特に）  

例えば、以下のSQL。  
```sql
update  items
   set  price = 100
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
  and  tax_rate_type = 0
```
where 条件の通りにデータを絞り込むと 1レコードのみだが、ロックする範囲は「インデックスが示す範囲」となるため、必要以上にロックする範囲が拡大される。  

上記の例では、1レコードしか更新しないにもかかわらず、以下の SQL の範囲がロック対象となる。（items_index_1 の範囲）  
```sql
where  1=1
  and  deleted_at is null
  and  owner_id = 1
```

こうやって無駄に範囲の広いインデックスが適用される事で、デッドロックを非常に誘発しやすい状況が生まれてしまう。  

## 対策１：トランザクション分離レベルを設定する
参考サイト  
<https://qiita.com/song_ss/items/38e514b05e9dabae3bdb>    

多くの場合、トランザクションの独立性と処理速度はトレードオフになり、バランスをどう取るかはプロジェクト次第。  

ただ、オプティマイザに任せてしまうと、結局は上記のような不確実性に悩まされるので、開発者側がきっちり指定したい場合は、別の方法を取る事になる。  


## 対策２：使用するインデックスを明示する
ヒント句を使う事で、インデックスを明示する事ができる。

MySQL公式サイトによる説明は以下。  
<https://dev.mysql.com/doc/refman/5.6/ja/index-hints.html>  

```sql
tbl_name [[AS] alias] [index_hint_list]

index_hint_list:
    index_hint [, index_hint] ...

index_hint:
    USE {INDEX|KEY}
      [FOR {JOIN|ORDER BY|GROUP BY}] ([index_list])
  | IGNORE {INDEX|KEY}
      [FOR {JOIN|ORDER BY|GROUP BY}] (index_list)
  | FORCE {INDEX|KEY}
      [FOR {JOIN|ORDER BY|GROUP BY}] (index_list)

index_list:
    index_name [, index_name] .
```

具体的には、こんな感じ。
```sql
update  items force INDEX (items_index_1)
   set  price = 100
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
  and  tax_rate_type = 0
```

こうする事で、「items_index_1」を強制的に適用する事ができる。  

「force」ではなく「use」でもよいのでは？　と思いきや、use を使うと、場合によってはオプティマイザが最適と判断したインデックスが採用されるようで、必ずしも指定したインデックスが適用されるわけではないみたい。  

なので、「何が何でもこのインデックスを使ってほしい」という場面においては、force オプションを使ってインデックスを指定します。  

update 文の場合も、先頭に「explain」を付ければ、どのインデックスが使われているか調べる事が可能です。  
```sql
explain
update  items use INDEX (items_index_1)
   set  price = 100
where  1=1
  and  deleted_at is null
  and  owner_id      = 1
  and  category_id   = 2
  and  tax_rate_type = 0
```

## その他の対策方法
上記のエラーは、「一定時間を経過すると、デッドロックエラーを発生させる」という処理になっており、「何秒経過後にデッドロックと判定するか」という値を設定する事が出来ます。  

具体的には、以下のコマンドで確認する事ができます。  

```sql
SHOW VARIABLES LIKE 'innodb_lock_wait_timeout'
```

|  Variable_name             |  Value  |
|:---------------------------|:--------|
|  innodb_lock_wait_timeout  |  50     |


デフォルトは 50（秒）です。  

以下のコマンドで一時的に設定を変える事が出来ます。
```sql
SET innodb_lock_wait_timeout=300
```

永続的に変える場合は my.cnf を編集します。  

RDS を使用している場合、パラメータグループに「innodb_lock_wait_timeout」という項目があるので、その値を設定します。  


## その他考察
Laravel にて RDB からデータを取得する時、Eloquent Model を使う方が良いとされていますが、データ量が膨大で厳しいパフォーマンスが求められる場合、なるべく生SQLを使う方がベターなのではないかと思います。  

今回のようにインデックスを指定したい場合、Eloquent Model では対応できないため、以下のように生SQLを書く事になります。  

```php
$sql = <<<SQL
             update  items use INDEX (items_index_1)
                set  price = 100
              where  1=1
                and  deleted_at is null
                and  owner_id      = :owner_id
                and  category_id   = :category_id
                and  tax_rate_type = :tax_rate_type
SQL;

$params['owner_id']      = 1;
$params['category_id']   = 2;
$params['tax_rate_type'] = 0;

$result = DB::select($sql, $params);
```

そもそも、厳しいパフォーマンスチューニングが必要な場合、フレームワークの機能ではどうにもならず、RDB固有の機能を使わないとどうにもならないケースが多いです。  

そんな時、RDBの本来の機能が制限されるフレームワークの枠組みを使うよりも、なるべく生SQLに近い形でコーディングしていた方が、後々の修正時に余計な苦労を抱えずに済む気がします。  

「いやいや。フレームワーク使う以上、ちゃんと用意している枠組みを使っとけよ。」という意見ももっともだが、RDB 固有の機能に一切頼らないプロダクトは極めて少ないと思うし（業務アプリだと特に）、RDBを変えるというのはかなり大きな変更なので、そうそう簡単に対応できるものではない。  

仮に対応するにしても、工数の算出がかなり難しくなる対応となるし、万全の状態でリリースする事も相当難しくなる。  
そんな状況に前もって対応しておく事を想定せず、「RDB は MySQLを使う」と最初から決めておく方が、来るかどうかも分からない変更に備えるよりもダメージが少ない気がしている。  

詳しくは以下にも書きました。  

[物流エンジニアが本気出して考えた Laravel のアーキテクチャ：リポジトリパターン - 1](https://kaki-note-02.netlify.app/2020/11/22/)  


