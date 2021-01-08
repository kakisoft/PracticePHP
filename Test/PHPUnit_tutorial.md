# PHPUnit
https://phpunit.de/  

現在の PHPのバージョンと、PHPUnitが対応している PHPのバージョンを確認しておこう！


```
PHP 7.1.23
```
_________________________________________________________
# Getting Started with PHPUnit 7
https://phpunit.de/getting-started/phpunit-7.html


## Composer
```
composer require --dev phpunit/phpunit ^7

./vendor/bin/phpunit --version


　　 -> PHPUnit 7.5.14 by Sebastian Bergmann and contributors.
```


## composer.json
ローカルにファイルが追加されてるので編集。
```
{
    "autoload": {
        "classmap": [
            "src/"
        ]
    },
    "require-dev": {
        "phpunit/phpunit": "^8"
    }
}
```
「"src/"」といった感じで、テストユニットがテスト対象のクラスを認識できるようにパスを設定。  


## Code
src/Email.php
```php
<?php
declare(strict_types=1);

final class Email
{
    private $email;

    private function __construct(string $email)
    {
        $this->ensureIsValidEmail($email);

        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address',
                    $email
                )
            );
        }
    }
}
```


## Test Code
tests/EmailTest.php
```php
<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
}
```


## Test Execution
Composer
```
（重要）
composer update


./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/EmailTest
```
composer update は、このタイミングが適当っぽい。



________________________________
## 備考
```
--bootstrap
テストの前に実行する PHP ファイル
```

### autoload
PHPでは通常、```require_once "hogehoge.php";``` と使用するファイルを明示する必要があるが、それを自動でやってくれる。
