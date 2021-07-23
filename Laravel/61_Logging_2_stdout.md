## Laravelでログを標準出力（stdout）させる方法
https://www.engilaboo.com/laravel-log-stdout/

____________________________________________________________________
# 修正内容

## config\logging.php
ストリームとは、PHPで入出力を扱う機能のことで、このストリームにstdoutを指定することで、ログを標準出力させることができます。
```php
    'default' => env('LOG_CHANNEL', 'stack'),
```
```php
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        // 標準出力用のチャンネルの追加
        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
        ],
```

## .env
```
LOG_CHANNEL=stack
　　↓
LOG_CHANNEL=stdout
```

## app\Console\Commands\KakiCommand.php （サンプルコード）
```php
    private function pruebaProcess02()
    {
        Log::info("ログが標準出力されましたよ!");
    }
```

## 出力結果（コマンド実行）
``
root@a7fe12e850d0:/var/www/html/my-laravel-app# php artisan k
[2021-07-23 13:59:54] local.INFO: ログが標準出力されましたよ!  
```

