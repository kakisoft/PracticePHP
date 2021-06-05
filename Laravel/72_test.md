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

## 実行（artisanコマンド）
```
php artisan test
php artisan test tests/ExampleTest.php
```


##　テストコード例： my-laravel-app\tests\ExampleTest.php
``` php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
}
```


## テストコード
```php
$response = $this->get('/api/call/me');
$return_contents = $response->content();
$encoded_return_contents = json_decode($return_contents, true);

$this->assertEquals($encoded_return_contents['message'], My_CLASS_01::MESSAGE___CALL_ME_GET);
```

#### 画面系
```php
public function testBoard()
{
    $this->visit('/boards')//  掲示板のトップページにアクセスしてみる
    ->see('掲示板')//           「掲示板」という文字列が見える
    ->see('新規投稿')//         「新規投稿」という文字列もある
    ->click('新規投稿')//        新規投稿リンクをクリックしてみる
    ->seePageIs('/boards/new')// 新規投稿ページに遷移する
    ->see('新規記事投稿');//     新規投稿ページには「新規記事投稿」という文字列がある
}
```
______________________________________________________________________________________________________
# 参考
https://qiita.com/niisan-tokyo/items/264d4e8584ed58536bf4  

https://public-constructor.com/laravel-test-cheatsheet/  



