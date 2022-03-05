# php-enum ( myclabs/php-enum )
https://github.com/myclabs/php-enum


## installation
```
composer require myclabs/php-enum
```

## Enums/Action.php
```php
<?php
namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * Action enum
 */
final class Action extends Enum
{
    private const VIEW = 'view';
    private const EDIT = 'edit';
    private const SAMPLE01 = 'prueba';
}
```


```php
$enumKeys = Action::keys();
/*
    array (
        0 => 'VIEW',
        1 => 'EDIT',
        2 => 'SAMPLE01',
    )
*/


$enumKeysToArray = Action::toArray();
/*
    array (
        'VIEW' => 'view',
        'EDIT' => 'edit',
        'SAMPLE01' => 'prueba',
    )
*/


$action01 = Action::VIEW();
\Log::info($action01);
/*
    view

    private const VIEW = 'view';
*/


$action03_1 = Action::isValid('prueba');
$action03_2 = Action::isValid('NotExistParam');
\Log::info($action03_1);  // 1
\Log::info($action03_2);  // (出力なし)


$action04_1 = Action::isValidKey('SAMPLE01');
$action04_2 = Action::isValidKey('NotExistKey');
\Log::info($action04_1);  // 1
\Log::info($action04_2);  // (出力なし)

```


