https://readouble.com/laravel/5.3/ja/artisan.html  

## コマンド一覧
```
php artisan list
```

## ヘルプ（例：migrate）
```
php artisan help migrate
```

## 状態確認
```
php artisan migrate:status
```

## ルーティング情報を表示
```
php artisan route:list
php artisan route:list --path=posts
```

## キャッシュをクリア
```
# 設定ファイルのキャッシュをクリア
php artisan cache:clear

# アプリケーションのキャッシュをクリア
php artisan config:clear

# ルートのキャッシュをクリア
php artisan route:clear

# ビューのキャッシュをクリア
php artisan view:clear
```

もう少し
```
composer dump-autoload

# コンパイルされたクラスをクリア
php artisan clear-compiled

# 最適化されたクラスローダを生成
php artisan optimize

# 設定をキャッシュしておかないと、アクセスするたびに毎回全ファイルを読み込む。
php artisan config:cache
```


#### php artisan clear-compiled
以下を削除する  

 - bootstrap/compiled.php
 - app/storage/meta/services.json




## 設定されたキーを確認
```
php artisan key:generate --show
```



## リフレッシュ
migrate:refreshコマンドは全部のデータベースマイグレーションを最初にロールバックし、それからmigrateコマンドを実行します。  
このコマンドはデータベース全体を作り直すために便利です。  
https://readouble.com/laravel/5.5/ja/migrations.html  

※要は全部ロールバックしてからマイグレーションし直す
```
php artisan migrate:refresh

// データベースをリフレッシュし、全データベースシードを実行
php artisan migrate:refresh --seed
```


## 最初からやりなおす
一旦全てのテーブルを削除してマイグレーションし直す
```
php artisan migrate:fresh
```



## マイクレーションテーブルを作成
Create the migration repository
```
php artisan migrate:install
```



## _
```
php artisan migrate:install


php artisan migrate:reset
```


