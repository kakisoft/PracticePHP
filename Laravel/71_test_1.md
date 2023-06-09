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

## 設定
phpunit.xml にて設定。  
詳細は[71_test_2_conf.md](./71_test_2_conf.md)。


## 作成
Service
```
php artisan make:test AlbumServiceTest
php artisan make:test AlbumServiceTest --unit
php artisan make:test Services/AlbumServiceTest --unit
// 「 --unit」オプションを付けると、「Unit」階層以下に作成される。


//=> my-laravel-app\tests\Feature\AlbumServiceTest.php
//=> my-laravel-app\tests\Unit\AlbumServiceTest.php
//=> my-laravel-app\tests\Unit\Services\AlbumServiceTest.php
```

WebAPI
```
php artisan make:test Api/PingTest

//=> my-laravel-app\tests\Feature\Api\PingTest.php
```


## 実行（phpunitコマンド） execute
```
./vendor/bin/phpunit
./vendor/bin/phpunit tests/Unit/ExampleTest.php

// テストスイートを指定
./vendor/bin/phpunit --configuration phpunit.xml --testsuite 実行したいテストスイート名
./vendor/bin/phpunit --configuration phpunit.xml --testsuite Feature
```

## 実行（artisanコマンド） execute
```
// フォルダ単位・ファイル単位で実行
php artisan test
php artisan test tests/Unit
php artisan test tests/Feature
php artisan test tests/Api/ExampleTest.php

// メソッド単位で実行（アノテーションを使用）
php artisan test tests/Api/ExampleTest.php --group=testing


// テストスイートを指定
php artisan test --testsuite=Unit
php artisan test --testsuite=Sample01


// レポート付き実行
php artisan test --testsuite=Unit --coverage-html
php artisan test --coverage-html reports
php artisan test --testsuite=Unit --coverage-html reports
```

## メソッド単位で実行する : アノテーションを使用する
```php
    /**
     * @group testing
     */
    public function testApiLoginWrongLoginId()
    {
```

## テスト設定例： phpunit.xml
```xml
        <testsuite name="Sample01">
            <directory suffix="Test.php">./tests/</directory>
        </testsuite>
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

## テストコード例
https://github.com/kakisoft/PracticeLaravel02/blob/master/my-laravel-app/tests/Unit/Question01RegistrationInformationTest.php  



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


______________________________________________________________________________________________________
______________________________________________________________________________________________________
______________________________________________________________________________________________________
## テスト実行例

#### docker-compose
```
docker-compose exec MY_CONTAINER php artisan test
docker-compose exec MY_CONTAINER php artisan test --testsuite=Unit
docker-compose exec MY_CONTAINER php artisan test --testsuite=Sample01
docker-compose exec MY_CONTAINER php artisan test tests/Unit/Example01Test.php
```

#### docker
```
docker exec -it MY_CONTAINER_1 sh -c "php artisan test"
docker exec -it MY_CONTAINER_1 sh -c "php artisan test --testsuite=Unit"
docker exec -it MY_CONTAINER_1 sh -c "php artisan test --testsuite=Sample01"
docker exec -it MY_CONTAINER_1 sh -c "php artisan test tests/Unit/Example01Test.php"
```

#### phpunit （コンテナの中から）
```
./vendor/bin/phpunit
./vendor/bin/phpunit --configuration phpunit.xml --testsuite Unit
./vendor/bin/phpunit --configuration phpunit.xml --testsuite Sample01
./vendor/bin/phpunit tests/Unit/Example01Test.php
```


______________________________________________________________________________________________________
______________________________________________________________________________________________________
______________________________________________________________________________________________________

## Laravel not generating code coverage report
https://stackoverflow.com/questions/66876314/laravel-not-generating-code-coverage-report




