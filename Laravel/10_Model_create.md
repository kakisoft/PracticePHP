## モデル
Eloquent モデル（エルクェントモデル？）と呼ばれていて SQL を意識しなくても直感的にデータが操作できるようになっている。

_________________________________________________________
## 準備
「.env」の設定  
「database/migrations/」内のファイル削除  
「database/database.sqlite」仮作成（SQLiteの場合）  
等  


_________________________________________________________
## マイグレーション（app の階層に作成 ）
＜ プロジェクトのルート階層にて実行 ＞  
```
（ Model作成。以下は「Post」という名称 ）
// バージョン管理するためのマイグレーションファイルも作る場合、  --migration オプションを付与。（-m でも可）
// -m オプションを指定しない場合、database\migrations\ フォルダに、ファイルが作成されない。
php artisan make:model Post --migration

　↓

ファイルが作成される。
「database\migrations\2019_11_19_101723_create_posts_table.php」
など

　↓

作成された migrations ファイルを編集

　↓

php artisan migrate
```
-m を忘れた場合、  
```
php artisan make:migration create_posts_table        # database/migrations/yyyy_mm_dd_hhmmss_create_posts_table.php に、ファイルが生成される。
※ create_テーブル名の複数形_table
```


## マイグレーション（Models の階層に作成）
モデル名は頭大文字、単数形、キャメルケース  
```
php artisan make:model Models/Project -m             # app/Models  に、ファイルが生成される。
# database\migrations\ に作成されたファイルを編集する
php artisan migrate                                  # DBにその内容が反映される。
```


## スキーマを更新する場合
```
# 既存のテーブルに変更を加える場合には、--create オプションではなく、--table オプションを使って、テーブル名を指定する。
# （別に指定しなくても出来るけど、最初に定義が出てくるんで便利。）
php artisan make:migration add_user_id_to_posts_table --table=posts
```


## 作成例
.11_Model_create_example01.md  
<a href=".11_Model_create_example01.md">aaa</a>

_________________________________________________________
## --migration オプション
// --migration または -m オプション  
// モデル作成時にデータベースマイグレーションも生成  
https://readouble.com/laravel/5.4/ja/eloquent.html  


_________________________________________________________
## 現在適用されているステータスを確認
```
php artisan migrate:status
```

_________________________________________________________
## 巻き戻し
```
php artisan migrate:rollback


php artisan migrate:rollback --step=1
```

_________________________________________________________
## リセット（手動）
 * Modelを削除（app/Post.php 等）
 * migrationsファイルを削除（database\migrations/2019_11_20_101202_create_posts_table.php 等）
 * DBを削除（database/database.sqlite 等）

_________________________________________________________
## 12_Model_example01
https://github.com/kakisoft/PracticePHP/blob/master/Laravel/12_Model_example01.md


## 13_Model_operate_tinker
https://github.com/kakisoft/PracticePHP/blob/master/Laravel/13_Model_operate_tinker.md


_________________________________________________________
## SQLiteで確認
```
（データ参照）
sqlite3 database/database.sqlite
select * from posts;
.quit




（作成したテーブルを確認）
sqlite3 database/database.sqlite
.schema posts

.quit
```





