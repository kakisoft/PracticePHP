# Monolog
https://readouble.com/laravel/5.5/ja/errors.html  


## 設定変更後は、キャッシュのクリアが必要？
```
php artisan config:cache
```

## 場所
デフォルト
```
storage\logs\
```

## 使い方
ver 5.5  
```php
\Log::info("ログ出力 : local.INFO");
\Log::debug("ログ出力 : local.DEBUG");


\Log::emergency($message);
\Log::alert($message);
\Log::critical($message);
\Log::error($message);
\Log::warning($message);
\Log::notice($message);
\Log::info($message);
\Log::debug($message);
```

```php
// 「\」を入れないで使うには下記の一文を入れる
use Illuminate\Support\Facades\Log;
```


## 設定

#### config/app.php
```php
    'debug' => env('APP_DEBUG', false),

//                                ↓

    'debug' => env('APP_DEBUG', true),
```


## ログストレージ
Laravelはデフォルトで、以下のログモードへのログ情報書き込みをサポートしています。

 * 単一ファイル(single)
 * 日別ファイル(daily)
 * システムログ(syslog)
 * エラーログ(errorlog)


#### config/app.php
```php
    'log' => env('APP_LOG', 'single'),
```

日別ログファイルは、デフォルトで最大５日。保持日数を変更可。
```php
    'log_max_files' => 30
```


## ログレベル

#### config/app.php
```php
        'log_level' => env('APP_LOG_LEVEL', 'debug'),
```

 * debug
 * info
 * notice
 * warning
 * error
 * critical
 * alert
 * emergency



## 指定チャンネルへの記述
```php
Log::channel('slack')->info('Something happened!');
```


_______________________________________________________________

