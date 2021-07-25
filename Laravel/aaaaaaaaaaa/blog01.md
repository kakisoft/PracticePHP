
【Laravel】migration にて、カラムの型を enum に change できない。

____________________________________________________________


database\migrations に記述する DB定義の変更にて、型を enum に変えようとしたらエラーが出た。  
具体的には以下のようなコード。
```php
    Schema::table('authors', function (Blueprint $table) {
        $table->enum('gender_type', [1, 2, 3])->nullable()->default(null)->change();
    });
```

出てきたエラーメッセージ、こんな感じ。  


> Unknown column type "enum" requested. Any Doctrine type that you use has to be registered with \Doctrine\DBAL\Types\Type::addType(). 
> You can get a list of all the known types with \Doctrine\DBAL\Types\Type::getTypesMap(). If this error occurs during database 
> introspection then you might have forgotten to register all database types for a Doctrine Type. 
> Use AbstractPlatform#registerDoctrineTypeMapping() or have your custom types implement Type#getMappedDatabaseTypes(). 
> If the type name is empty you might have a problem with the cache or forgot some mapping information.


どういう事じゃい。  
と思って調べたら、こんなの出てきた。  

[How to change enum type column in laravel migration?](https://stackoverflow.com/questions/33496518/how-to-change-enum-type-column-in-laravel-migration)  
[Laravel Migration - Enum型カラムのオプションの変更方法](https://qiita.com/yuuta_s/items/16826968bfdf3a9ba89f)  
[【MySQL×Laravel】 ENUM型カラムを扱うなら、マイグレーションの面倒さを覚悟しようという話](https://tech.gaogao.asia/create-and-update-enum-column/)  

どうやら、change() メソッドでカラムの型を enum に変更する事は出来ないみたい。  

> 理由は、DBAL 2.9.2は列挙型データ型をサポートしていないからだそうです。

とのこと。  


## 解決策１．DB::statement を使い、Alter table を実行する
こんな感じ。
```php
    DB::statement("ALTER TABLE authors MODIFY COLUMN gender_type ENUM('1', '2', '3')");
```
個人的には、なるべくやりたくない。  
理由は、RDB個別の処理になるから。  
RDB が MySQL → Postgres に変わってしまった場合、動かないコードが出来てしまう。  

なので、エラーが発生しないようにするためには、以下のように RDB による制限が必要となってしまう。
```php
    public function up()
    {
        // MySQL 出なかった場合、早期リターンして、Alter table コマンド（RDB固有のコマンド）を実行しない
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE authors MODIFY COLUMN gender_type ENUM('1', '2', '3')");
    }
```
こんな事をしても、この場ではエラーが出なくとも、後続の処理でエラーが発生する事は十分にあるし、そもそもアプリがマトモに動かない可能性もあるので、素直にこの時点でエラー出しておいた方が良さそうな気がする。  


## 解決策２．一時カラムを利用する
こちらで紹介されている内容。  
[【MySQL×Laravel】 ENUM型カラムを扱うなら、マイグレーションの面倒さを覚悟しようという話](https://tech.gaogao.asia/create-and-update-enum-column/)  

> 手はずとしては、以下のようになります。
>
> * 現行カラムと同定義の一時カラムを作成
> * 現行のカラム値で一時カラムを上書き
> * 現行カラムを削除
> * 定義できる文字列が追加された状態で現行と同名の新規カラムを作成
> * 一時カラムの値で新規カラムを上書き
> * 一時カラムを削除

なかなかヘビーな力業だ。  

コード記述量も増えるし、あんまりやらない方がいいんじゃないのか。  


## 解決策３．enum に change できるようになるライブラリを入れる
こちらで紹介されている内容。  
[【MySQL×Laravel】 ENUM型カラムを扱うなら、マイグレーションの面倒さを覚悟しようという話](https://tech.gaogao.asia/create-and-update-enum-column/)  

doctrine/dbal というライブラリを使えば、コマンドを有効化できるらしい。  

（Doctrine DBAL）  
https://github.com/doctrine/dbal


Laravel 公式サイトでも紹介されている。  
https://laravel.com/docs/8.x/migrations#modifying-columns

そういえば見おぼえが・・・と思って調べてみたら、renameColumn でエラー出た時に使ってた。

```php
$table->renameColumn('from', 'to');
```

カラム名を変更する時、renameColumn というメソッドを使うが、実はデフォルトでは動かないので、doctrine/dbal を composer install していた。  

これぐらい、標準サポートしてないのか・・？　と思いつつも、入れないと動かないんだから仕方ない。  

スマートに解決するのが、こっちが一番いい気がする。  



