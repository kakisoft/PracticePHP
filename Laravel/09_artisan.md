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
php artisan cache:clear         # 設定ファイルのキャッシュをクリア
php artisan config:clear        # アプリケーションのキャッシュをクリア
php artisan route:clear         # ルートのキャッシュをクリア
php artisan view:clear          # ビューのキャッシュをクリア
```
もう少し
```
composer dump-autoload
php artisan clear-compiled
php artisan optimize           # 最適化されたクラスローダを生成
php artisan config:cache       # 設定をキャッシュしておかないと、アクセスするたびに毎回全ファイルを読み込む。
```


## 設定されたキーを確認
```
php artisan key:generate --show
```


## _
```
php artisan migrate:install


php artisan migrate:reset


composer dump-autoload
```


