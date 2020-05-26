## 階層
```
tests\ExampleTest.php
```

## composer.json  （環境確認）
```php
    "require-dev": {
        "barryvdh/laravel-debugbar": "^3.3",
        "filp/whoops": "~2.0",
        "fzaninotto/faker": "~1.4",
        "mockery/mockery": "0.9.*",
        "phpunit/phpunit": "~6.0"
    },
```

## 実行
```
./vendor/bin/phpunit
./vendor/bin/phpunit tests/
./vendor/bin/phpunit tests/Unit/ExampleTest.php
```


