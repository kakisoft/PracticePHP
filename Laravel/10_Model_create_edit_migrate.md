## モデル
Eloquent モデル（エルクェントモデル？）と呼ばれていて SQL を意識しなくても直感的にデータが操作できるようになっている。

## テーブル
「 migrations 」というテーブルが作成される。  
テーブルの変更履歴なども記録される。  

＜解説＞  
https://www.hypertextcandy.com/how-laravel-migration-works  

_________________________________________________________
## 準備
 * 「.env」の設定（DBの接続情報とか）  
 * 「database/migrations/」内のファイル削除（削除不要と判断したなら別にいいけど）  
 * 「database/database.sqlite」仮作成（SQLiteの場合）  

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
モデル名は頭大文字、単数形、キャメルケース。  
Models の後ろの区切り文字は「 / 」（スラッシュ）  
```
php artisan make:model Models/Project -m             # app/Models  に、ファイルが生成される。
# database\migrations\ に作成されたファイルを編集する
php artisan migrate                                  # DBにその内容が反映される。
```

## 作成例
<a href="11_Model_create_example01.md">11_Model_create_example01.md</a>


## Model名について
大文字のみの単語がある場合、変な名称のスキーマが出来てしまう。 
また、末尾を数字にすると違和感バリバリなので、よく考えよう。  
```
php artisan make:model Models/CallMeAPI01 -m

  →  Schema::create('call_me_a_p_i01s', function (Blueprint $table) {
```
省略すると、変な複数形になる事が。
```
php artisan make:model Models/RegistInfo -m

　　→ regist_infos
```



## スキーマを更新する場合
```
# 既存のテーブルに変更を加える場合には、--create オプションではなく、--table オプションを使って、テーブル名を指定する。
# （別に指定しなくても出来るけど、最初に定義が出てくるんで便利。）
php artisan make:migration add_user_id_to_posts_table --table=posts
```

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


## アプリケーション全部のマイグレーションをロールバック
```
php artisan migrate:reset
```

## 最初にロールバックし、それから migration を実行
```
php artisan migrate:refresh


// データベースをリフレッシュし、全データベースシードを実行
php artisan migrate:refresh --seed
```

_________________________________________________________
## リセット（手動）
 * Modelを削除（app/Post.php 等）
 * migrationsファイルを削除（database\migrations/2019_11_20_101202_create_posts_table.php 等）
 * DBを削除（database/database.sqlite 等）



## スキーマ定義を変更した時のエラー
https://readouble.com/laravel/5.5/ja/migrations.html

#### エラーメッセージ
```
Changing columns for table "users" requires Doctrine DBAL; install "doctrine/dbal".
```

#### コマンド
```
composer require doctrine/dbal
```


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

_________________________________________________________
## 最初から

### refresh
すべてのマイグレーションをロールバックしてから再びマイグレーション
```
php artisan migrate:refresh
```

### fresh
すべてのテーブルをドロップ（削除）してから再びマイグレーション
```
php artisan migrate:fresh
```
