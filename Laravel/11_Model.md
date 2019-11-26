## モデル
Eloquent モデル（エルクェントモデル？）と呼ばれていて SQL を意識しなくても直感的にデータが操作できるようになっている。

_________________________________________________________
## 準備
「.env」の設定  
「database/migrations/」内のファイル削除  
「database/database.sqlite」仮作成  
等  


_________________________________________________________
## マイグレーションの設定
```
＜ プロジェクトのルート階層にて実行 ＞

（ Model作成。以下は「Post」という名称 ）
// バージョン管理するためのマイグレーションファイルも作る場合、  --migration オプションを付与。
php artisan make:model Post --migration

　↓

ファイルが作成される。
「database\migrations\2019_11_19_101723_create_posts_table.php」
など

　↓

作成された migrations ファイルを編集

　↓

php artisan migrate

------------------


## Models 階層に作成
php artisan make:model Models/Post                   # app/Models  に、ファイルが生成される。
php artisan make:migration create_posts_table        # database/migrations/yyyy_mm_dd_hhmmss_create_posts_table.php に、ファイルが生成される。
php artisan migrate                                  # DBにその内容が反映される。


------------------------------------------
（作成したテーブルを確認）
sqlite3 database/database.sqlite
.schema posts

.quit
```

_________________________________________________________
## --migration オプション
// --migration または -m オプション  
// モデル作成時にデータベースマイグレーションも生成  
https://readouble.com/laravel/5.4/ja/eloquent.html  

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





