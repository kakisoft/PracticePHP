## Laravel 公式
https://laravel.com/docs/8.x/logging


# Monolog
https://readouble.com/laravel/5.5/ja/errors.html  

______________________________________________________________

## 設定変更後は、キャッシュのクリアが必要？
```
php artisan config:cache
```

## ログが出力される場所
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
// 先頭に「\」を入れないで使うには下記の一文を入れる
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
# 色んなログ出力方法

```php
//===========================================================
//                     logger
//===========================================================

// DEGUG 以外はできない？
logger('test', ['foo' => 'bar']);
logger('test', ['file' => __FILE__, 'line' => __LINE__]);
// [2021-07-23 13:34:03] local.DEBUG: test {"foo":"bar"}
// [2021-07-23 13:34:03] local.DEBUG: test {"file":"/var/www/html/my-laravel-app/app/Console/Commands/KakiCommand.php","line":76}


//===========================================================
//                     info
//===========================================================
info('test', ['foo' => 'bar']);
// [2021-07-23 13:37:29] local.INFO: test {"foo":"bar"}


//===========================================================
//                     logs()
//===========================================================
logs()->notice('test', ['foo' => 'bar']);
logs()->warning('test', ['foo' => 'bar']);
logs()->error('test', ['foo' => 'bar']);
logs()->critical('test', ['foo' => 'bar']);
logs()->alert('test', ['foo' => 'bar']);
logs()->emergency('test', ['foo' => 'bar']);
// [2021-07-23 13:37:29] local.NOTICE: test {"foo":"bar"}
// [2021-07-23 13:37:29] local.WARNING: test {"foo":"bar"}
// [2021-07-23 13:37:29] local.ERROR: test {"foo":"bar"}
// [2021-07-23 13:37:29] local.CRITICAL: test {"foo":"bar"}
// [2021-07-23 13:37:29] local.ALERT: test {"foo":"bar"}
// [2021-07-23 13:37:29] local.EMERGENCY: test {"foo":"bar"}


//===========================================================
//                     Log ファサード
//===========================================================
Log::debug('test', ['foo' => 'bar']);
Log::info('test', ['foo' => 'bar']);
Log::notice('test', ['foo' => 'bar']);
Log::warning('test', ['foo' => 'bar']);
Log::error('test', ['foo' => 'bar']);
Log::critical('test', ['foo' => 'bar']);
Log::alert('test', ['foo' => 'bar']);
Log::emergency('test', ['foo' => 'bar']);
// [2021-07-23 13:39:50] local.DEBUG: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.INFO: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.NOTICE: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.WARNING: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.ERROR: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.CRITICAL: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.ALERT: test {"foo":"bar"}
// [2021-07-23 13:39:50] local.EMERGENCY: test {"foo":"bar"}
```

