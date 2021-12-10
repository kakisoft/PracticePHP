
https://zudoh.com/mysql/should-use-collation-utf8mb4_bin-as-default




__________________________________________________________________________________________
## database.php
```php
            'collation' => 'utf8mb4_unicode_ci',

                                ↓

            'collation' => 'utf8mb4_bin',
```

____________________________________________________________________
https://bwave.backlog.com/view/BBP-1790



https://readouble.com/laravel/8.x/ja/migrations.html


https://zenn.dev/zoeponta/articles/090c68ba820a24

https://qiita.com/tfunato/items/e48ad0a37b8244a788f6


MySQLの文字コードとCollation





https://www.chatwork.com/#!rid204177818-1513367810527461376

[引用 aid=522423 time=1637288603][To:694576]金菱 稔さん
configの変更でいけるのかも

config/database.php
　mysql
　　'collation' => 'utf8mb4_unicode_ci',

　happylogi_mysql
　　'collation' => 'utf8mb4_unicode_ci',

utf8mb4_binに変更してマイグレーション実行すると、utf8mb4_binでテーブル作られる。
[/引用]


[引用 aid=522423 time=1637288983][To:694576]金菱 稔さん
COLLATE変更SQL
ALTER TABLE テーブル名 COLLATE = utf8mb4_bin
[/引用]



________________________________________________________________________________________________

https://bwave.backlog.com/view/BBP-1790#comment-85242450
これを行います
laravelの方の変更は既に実施してshareまでマージ済みです

各開発者の方はローカル環境で下記実施してください
１．hapilogi、logiecともにデータベースごと「構造とデータ」まるごとダンプします
２．sqlファイルを開いて、「utf8mb4_unicode_ci」の箇所を全て「utf8mb4_bin」に置換します
３．保存したsqlファイルを実行して元のデータベースに戻します

AWS環境の方はこの後devだけ実施して、stg及びprodは誰も使っていない夜遅に実施します



ALTER TABLE `asims`.`items` 
MODIFY COLUMN `barcode3` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '繝舌・繧ｳ繝ｼ繝・' AFTER `barcode2`



