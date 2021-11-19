https://bwave.backlog.com/view/BBP-1790



https://readouble.com/laravel/8.x/ja/migrations.html


https://zenn.dev/zoeponta/articles/090c68ba820a24

https://qiita.com/tfunato/items/e48ad0a37b8244a788f6


MySQLの文字コードとCollation




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


