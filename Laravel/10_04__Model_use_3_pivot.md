Intermediate table

Pivot Table

_______________
https://noumenon-th.net/programming/2020/11/05/many-to-many/

books
tags
book_tag

-----------
https://blog-and-destroy.com/31661

posts
tags
post_tag

------------

https://biz.addisteria.com/laravel_withpivot/

users
clubs
clubs_users


withPivot

------------
https://laraveldaily.com/pivot-tables-and-many-to-many-relationships/

shops
products
product_shop


------------
https://zakkuri.life/%E3%80%90laravel%E3%80%91%E4%B8%AD%E9%96%93%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%A6%E3%81%BF%E3%82%8B-%E5%9F%BA%E6%9C%AC%E7%B7%A8/

items
categories
category_item

------------


Document
Tag


documents
tags


------------

php artisan make:model Document --migration
php artisan make:model Tag --migration

________________________________________

＜Laravel公式＞
users
roles
role_user


________________________________________
【Laravel】中間テーブルをsycnメソッドでお手軽に保存する
https://zenn.dev/naonao70/articles/e297bfa393af6d


________________________________________
________________________________________
________________________________________
________________________________________
________________________________________
「中間テーブル」って英語で何て言うんだろ。

Laravel のドキュメント読んでると、「Intermediate table」と「Pivot Table」の両方あるぞ。

「中間テーブルのカラム取得（Retrieving Intermediate Table Columns）」
「中間テーブルのレコード更新（Updating A Record On A Pivot Table）」

こんな感じで。

該当ページ、ここ。
https://readouble.com/laravel/7.x/ja/eloquent-relationships.html
https://readouble.com/laravel/7.x/en/eloquent-relationships.html


class RoleUser extends Pivot


-----------------------------------------------
中間テーブルって、ググると結構カオスみ深いような...
例えば、「users」と「roles」の中間テーブル名が、

user_role
role_user
roles_users

と、人によって流派があるのだろうか。

Laravel 公式が「role_user」表記なので、そっち使ってるけど。



