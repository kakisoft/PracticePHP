【Laravel】ジョブのタイムアウトを設定する変数「$timeout」は、コメントアウト時でも有効？

________________________________________________________________
【 環境 】
Laravel のバージョン： 8.16.1
PHP のバージョン： 7.4.7


```log

出力内容 :critical 9999900001 A system error has occurred. :
[trace]PDOException: SQLSTATE[HY000]: General error: 1390 Prepared statement contains too many placeholders in /application/vendor/laravel/framework/src/Illuminate/Database/Connection.php:458
Stack trace:
#0 /application/vendor/laravel/framework/src/Illuminate/Database/Connection.php(458): PDO-&gt;prepare(&#039;insert into `tm...&#039;)



Next Illuminate\Database\QueryException: SQLSTATE[HY000]: General error: 1390 Prepared statement contains too many placeholders (SQL: insert into `tmp_advanced_shipping_notice_details` (`advanced_shipping_notice_detail_status`, `child_shipper_job_sequence_no`, `csv_row_number`, `error_message`, `estimated_inbound_date`, `estimated_inbound_quantity`, `is_enabled_importing`, `item_code`, `item_id`, `note`, `parent_shipper_job_id`, `row_no`, `supplier_code`, `supplier_name`, 
```

## プレースホルダ
```php
$sql = "SELECT * FROM user WHERE name=:name";

bindValue(':name', $name, PDO::PARAM_STR);
```


PDO::ATTR_EMULATE_PREPARES => false,


## MySQLでプレースホルダ使いすぎて怒られるのを動的プレースホルダを使って回避する
https://blog.pinkumohikan.com/entry/workaround-for-mysql-too-many-placeholders-error

> MySQLでプリペアドステートメントを使う場合、65536個以上のプレースホルダを含めることができない
> 先の制約はシステム変数で緩和できない (変更できない)
> ハックとして、プリペアドステートメントを使わない "動的プレースホルダ" を使うことで先の制約を回避することができる

 * 正攻法はクエリ分割
 * それでも俺は1クエリで取りたい

例えばPHPでPDOを使う場合、オプションで ATTR_EMULATE_PREPARES = true とすれば動的プレースホルダを使うようになる。



## 動的プレースホルダ


## 静的プレースホルダ


＜Google 検索ワード＞
static placeholder dynamic placeholder



https://www.ipa.go.jp/files/000017321.pdf




## Insert処理一括ドーン！をするときに気をつけたいこと
https://qiita.com/Shun_Nagahara/items/93641263578782f885bf

> こんな感じでコレクション化して1000個ずつ分割したらいけた。

## StackOverFlow : Import of 50K+ Records in MySQL Gives General error: 1390 Prepared statement contains too many placeholders
https://stackoverflow.com/questions/18100782/import-of-50k-records-in-mysql-gives-general-error-1390-prepared-statement-con
```php
foreach (array_chunk($data,1000) as $t)  
{
     DB::table('table_name')->insert($t); 
}
```

## [MySQL] too many placeholders の解消
https://qiita.com/idek/items/80ffb8e4ffe99e28caed

ちょっと複雑

## MySQL: プリペアドステートメントのプレースホルダーの数は65535まで。
https://cufl.hateblo.jp/entry/2021/08/25/215402

> そうすると、下記の定義が見つかった。

_______________________________________________________________________________________



## LaravelでDB::statementを実行するとエラーが出る
https://qiita.com/hondy12345/items/4ebf7130bef833d0a3ea

```php
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options' => [
                PDO::ATTR_EMULATE_PREPARES => true
            ],
        ],
```

## 【Laravel】クエリ実行前にMySQLのDBコネクションのPDOにsetAttributeする。
https://qiita.com/msht0511/items/82cd3103aaa191342ba5

> laravelではPDO::ATTR_EMULATE_PREPARESはデフォルトFalseですが、
> LOAD DATA LOCAL INFILEステートメントを実行するときにエラーになってしまうため、PDO::ATTR_EMULATE_PREPARESをTrueにしてやる必要があります。



## Alter base PDO configuration in Laravel
https://stackoverflow.com/questions/37652921/alter-base-pdo-configuration-in-laravel/37655799
```php
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => null,
        // Additional options here
        'options'   => [PDO::ATTR_EMULATE_PREPARES => true, PDO::MYSQL_ATTR_COMPRESS => true,]
    ],
```



## Laravelにおける複文のSQLインジェクション対策
> LaravelはデフォルトでPDO::ATTR_EMULATE_PREPARESをfalseにしているため。
> これがfalseだとMySQLで複文(;区切りで複数のクエリを発行すること)を許可しない。



