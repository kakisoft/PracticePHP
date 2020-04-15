# Carbon
https://carbon.nesbot.com/

## インストール
```
composer require nesbot/carbon
```

____________________________________________________________________________________________________
## 使う
```php
require 'vendor/autoload.php';

use Carbon\Carbon;
```


## 基本
```php
$dt_01 = new Carbon();
echo $dt_01 . PHP_EOL;  //=> 2020-04-15 00:22:42
```


## 日付作成
```php
$dt_02 = new Carbon();
$dt_03 = Carbon::now();

$dt_04 = new Carbon('2015-12-20 11:32:32');
$dt_05 = new Carbon('tomorrow');

$dt_06 = Carbon::today();
$dt_07 = Carbon::tomorrow();
$dt_08 = Carbon::yesterday();

$dt_09 = Carbon::parse('2015-12-20 11:32:32');
$dt_10 = Carbon::create(2020, 12, 20, 11, 34, 33);

$dt_11 = Carbon::createFromFormat('Y/m/d H', '2015/12/20 20');
```

## 切り出し
```php
echo $dt_12->year        . PHP_EOL;  //=>2020
echo $dt_12->month       . PHP_EOL;  //=>4
echo $dt_12->day         . PHP_EOL;  //=>15
echo $dt_12->hour        . PHP_EOL;  //=>0
echo $dt_12->minute      . PHP_EOL;  //=>26
echo $dt_12->second      . PHP_EOL;  //=>57
echo $dt_12->dayOfWeek   . PHP_EOL;  //=>3
echo $dt_12->dayOfYear   . PHP_EOL;  //=>106
echo $dt_12->weekOfMonth . PHP_EOL;  //=>3
echo $dt_12->weekOfYear  . PHP_EOL;  //=>16
echo $dt_12->timestamp   . PHP_EOL;  //=>1586910417
echo $dt_12->tzName      . PHP_EOL;  //=>UTC
echo $dt_12->format('Y年m月d日') . PHP_EOL;  //=> 2020年04月15日
```


## _
```php
$dt_13 = Carbon::now();
var_dump($dt_13->isToday())     . PHP_EOL;  //=> true
var_dump($dt_13->isTomorrow())  . PHP_EOL;  //=> false
var_dump($dt_13->isYesterday()) . PHP_EOL;  //=> false
var_dump($dt_13->isFuture())    . PHP_EOL;  //=> false
var_dump($dt_13->isPast())      . PHP_EOL;  //=> true
var_dump($dt_13->isLeapYear())  . PHP_EOL;  //=> true
var_dump($dt_13->isWeekday())   . PHP_EOL;  //=> true
var_dump($dt_13->isWeekend())   . PHP_EOL;  //=> false
var_dump($dt_13->isSameDay(Carbon::now())) . PHP_EOL;  //=> true
```


## 比較
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);

// eq
// gt, gte
// lt, lte

var_dump($dt_01->eq($dt_02)) . PHP_EOL;  //=> false
var_dump($dt_01->gt($dt_02)) . PHP_EOL;  //=> false
var_dump($dt_01->lt($dt_02)) . PHP_EOL;  //=> true

// between

var_dump(Carbon::create(2020, 10, 10)->between($dt_01, $dt_02)) . PHP_EOL;  //=> true
var_dump(Carbon::create(2022, 10, 10)->between($dt_01, $dt_02)) . PHP_EOL;  //=> false

// max, min

echo $dt_01->max($dt_02) . PHP_EOL;  //=> 2020-11-01 00:00:00
echo $dt_01->min($dt_02) . PHP_EOL;  //=> 2020-10-01 00:00:00
```


## _
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);

// max, min

echo $dt_01->max($dt_02) . PHP_EOL;  //=> 2020-11-01 00:00:00
echo $dt_01->min($dt_02) . PHP_EOL;  //=> 2020-10-01 00:00:00
```


## 加算・減算
```php
$dt = Carbon::now();
echo $dt->addYear()   . PHP_EOL;  //=> 2021-04-15 00:43:48
echo $dt->addYears(3) . PHP_EOL;  //=> 2024-04-15 00:43:48
echo $dt->subYear()   . PHP_EOL;  //=> 2023-04-15 00:43:48
echo $dt->subYears(3) . PHP_EOL;  //=> 2020-04-15 00:43:48

// add, sub
// Years(n)
// Year, Month, Day, Hour, Minute, Second
// Weekday

echo $dt->addWeekdays(3) . PHP_EOL;  //=> 2020-04-20 00:43:48
echo $dt->addWeekdays(3)->addHours(3)->addMinutes(20) . PHP_EOL;  //=> 2020-04-23 04:03:48
```


## コピー
```php
$dt = Carbon::now();
echo $dt->addYear()         . PHP_EOL;  //=> 2021-04-15 00:45:10
echo $dt->copy()->addYear() . PHP_EOL;  //=> 2022-04-15 00:45:10
echo $dt                    . PHP_EOL;  //=> 2021-04-15 00:45:10
```



## 特定の日付を取得
```php
$dt_01 = Carbon::now();
echo $dt_01->startOfDay()   . PHP_EOL;  //=> 2020-04-15 00:00:00
echo $dt_01->endOfDay()     . PHP_EOL;  //=> 2020-04-15 23:59:59
echo $dt_01->startOfMonth() . PHP_EOL;  //=> 2020-04-01 00:00:00
echo $dt_01->endOfMonth()   . PHP_EOL;  //=> 2020-04-30 23:59:59
echo $dt_01->startOfWeek()  . PHP_EOL;  //=> 2020-04-27 00:00:00
echo $dt_01->endOfWeek()    . PHP_EOL;  //=> 2020-05-03 23:59:59

echo $dt_01->next(Carbon::MONDAY)     . PHP_EOL;  //=> 2020-05-04 00:00:00
echo $dt_01->previous(Carbon::MONDAY) . PHP_EOL;  //=> 2020-04-27 00:00:00

echo $dt_01->firstOfMonth(Carbon::MONDAY)  . PHP_EOL;  //=> 2020-04-06 00:00:00
echo $dt_01->lastOfMonth(Carbon::MONDAY)   . PHP_EOL;  //=> 2020-04-27 00:00:00
echo $dt_01->nthOfMonth(3, Carbon::MONDAY) . PHP_EOL;  //=> 2020-04-20 00:00:00
```



## _
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);

echo $dt_01->diffInDays($dt_02)    . PHP_EOL;  //=> 31
echo $dt_01->diffInHours($dt_02)   . PHP_EOL;  //=> 744
echo $dt_01->diffInMinutes($dt_02) . PHP_EOL;  //=> 44640

Carbon::setLocale('ja');
echo $dt_01->diffForHumans($dt_02) . PHP_EOL;  //=> 1ヶ月前
```



## __
```php
$birthday = Carbon::create(1990, 10, 1);

Carbon::setTestNow(Carbon::create(2020, 10, 1));
echo Carbon::now() . PHP_EOL;  //=> 2020-10-01 00:00:00
Carbon::setTestNow();
echo Carbon::now() . PHP_EOL;  //=> 2020-04-15 00:50:05

if ($birthday->isBirthday(Carbon::now())) {
  echo ':)' . PHP_EOL;
} else {
  echo ':<' . PHP_EOL;
}
```




