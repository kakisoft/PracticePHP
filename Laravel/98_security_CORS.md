# CORS

## config\cors.php
```php
    'paths' => ['api/*'],                                  // デフォルト
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login'],  // 変更後

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,  // デフォルト
    'supports_credentials' => true,   // 変更後

```

## paths

### sanctum/csrf-cookie
Laravel CSRFトークン
それを、SPA側に取得するために、

'sanctum/csrf-cookie'
が必要。

これが無いと、トークンの受け渡しが出来ない。


### ログインページ用
ログインページでは認証をしない。
```
http://localhost:3000/login
```

### supports_credentials
SPAを使用する場合、true にする。

https://readouble.com/laravel/8.x/ja/sanctum.html



