## ライブラリ
https://github.com/ytake/Laravel-FluentLogger


## config\logging.php
なぜ「fluentd」ではなく「fluent」なのかは謎。
```php
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single', 'errors'],
            'ignore_exceptions' => false,
        ],

        'fluent' => [
            'driver' => 'fluent',
            'tap' => [CustomizeFormatApply::class],  // カスタマイズする場合
            'level' => env('LOG_LEVEL', 'debug'),
        ],
```

