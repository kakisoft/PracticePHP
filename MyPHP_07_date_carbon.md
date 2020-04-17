# Carbon
Carbon クラスは、PHP 標準の DateTime クラスを継承している  

## 公式サイト
https://carbon.nesbot.com/

## インストール
```
composer require nesbot/carbon
```

____________________________________________________________________________________________________
## タイムゾーン設定
https://www.php.net/manual/ja/timezones.asia.php  

```php
date_default_timezone_set('Asia/Tokyo');
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
echo $dt_12->dayOfWeek   . PHP_EOL;  //=>3    （週のうちの何日目か？）
echo $dt_12->dayOfYear   . PHP_EOL;  //=>106  （年のうちの何日目か？）
echo $dt_12->weekOfMonth . PHP_EOL;  //=>3
echo $dt_12->weekOfYear  . PHP_EOL;  //=>16
echo $dt_12->timestamp   . PHP_EOL;  //=>1586910417
echo $dt_12->tzName      . PHP_EOL;  //=>UTC
echo $dt_12->format('Y年m月d日') . PHP_EOL;    //=> 2020年04月15日
echo $dt_12->format('Y/m/d H:i:s') . PHP_EOL;  //=> 2020/04/15 04:19:34
```


## 日付の判定
```php
// 実行日： 2020/04/16 04:19:34
$dt_13 = new Carbon('2020-04-16 11:32:32');
var_dump($dt_13->isToday())     . PHP_EOL;  //=> true
var_dump($dt_13->isTomorrow())  . PHP_EOL;  //=> false
var_dump($dt_13->isYesterday()) . PHP_EOL;  //=> false
var_dump($dt_13->isFuture())    . PHP_EOL;  //=> true
var_dump($dt_13->isPast())      . PHP_EOL;  //=> false
var_dump($dt_13->isLeapYear())  . PHP_EOL;  //=> true
var_dump($dt_13->isWeekday())   . PHP_EOL;  //=> true
var_dump($dt_13->isWeekend())   . PHP_EOL;  //=> false
var_dump($dt_13->isSameDay(Carbon::now())) . PHP_EOL;  //=> true
```


## 加算・減算
```php
$dt = new Carbon('2020-04-16 11:32:32');
echo $dt->addYear()   . PHP_EOL;  //=> 2021-04-16 11:32:32
echo $dt->addYears(3) . PHP_EOL;  //=> 2024-04-16 11:32:32
echo $dt->subYear()   . PHP_EOL;  //=> 2023-04-16 11:32:32
echo $dt->subYears(3) . PHP_EOL;  //=> 2020-04-16 11:32:32

// add, sub
// Years(n)
// Year, Month, Day, Hour, Minute, Second
// Weekday

echo $dt->addWeekdays(3) . PHP_EOL;  //=> 2020-04-21 11:32:32
echo $dt->addWeekdays(3)->addHours(3)->addMinutes(20) . PHP_EOL;  //=> 2020-04-24 14:52:32
```


## 元の値を変えずに、未来（or過去）の日付を取得
```php
$dt = new Carbon('2020-04-16 11:32:56');
echo $dt->addYear()         . PHP_EOL;  //=> 2021-04-16 11:32:56
echo $dt->copy()->addYear() . PHP_EOL;  //=> 2022-04-16 11:32:56   // 元の値を変えずに、１年後の日付を取得
echo $dt                    . PHP_EOL;  //=> 2021-04-16 11:32:56
```


## 特定の日付に変更
```php
// ※破壊的なメソッド。実行すると、元の値が変わる。
echo $dt_01->startOfDay()                  . PHP_EOL;  //=> 2020-04-16 00:00:00    今日の始まりの日時
echo $dt_01->endOfDay()                    . PHP_EOL;  //=> 2020-04-16 23:59:59    今日の終わりの始まりの日時
echo $dt_01->startOfMonth()                . PHP_EOL;  //=> 2020-04-01 00:00:00    月初日
echo $dt_01->endOfMonth()                  . PHP_EOL;  //=> 2020-04-30 23:59:59    月末日
echo $dt_01->startOfWeek()                 . PHP_EOL;  //=> 2020-04-13 00:00:00    週の開始日（月曜）
echo $dt_01->startOfWeek()->subDay(1)      . PHP_EOL;  //=> 2020-04-12 00:00:00    週の開始日（日曜）
echo $dt_01->endOfWeek()                   . PHP_EOL;  //=> 2020-04-19 23:59:59    週の終了日（日曜）
echo $dt_01->endOfWeek()->subDay(1)        . PHP_EOL;  //=> 2020-04-12 00:00:00    週の終了日（土曜）
echo $dt_01->next(Carbon::MONDAY)          . PHP_EOL;  //=> 2020-04-20 00:00:00    次の月曜日
echo $dt_01->previous(Carbon::MONDAY)      . PHP_EOL;  //=> 2020-04-27 00:00:00    前の月曜日
echo $dt_01->firstOfMonth(Carbon::MONDAY)  . PHP_EOL;  //=> 2020-04-06 00:00:00    月の最初の月曜日
echo $dt_01->lastOfMonth(Carbon::MONDAY)   . PHP_EOL;  //=> 2020-04-27 00:00:00    月の最後の月曜日
echo $dt_01->nthOfMonth(3, Carbon::MONDAY) . PHP_EOL;  //=> 2020-04-20 00:00:00    第３月曜日
```


## 比較
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);


//----------( 等しいかどうかを判定 )----------
// eq() - equal
var_dump($dt_01->eq($dt_02)) . PHP_EOL;  //=> false


//----------( 対象より大きいかを判定 )----------
// gt() - greater than / greater than or equal
var_dump($dt_01->gt($dt_02)) . PHP_EOL;  //=> false


//----------( 対象より小さいかを判定 )----------
// lt() - less than / less than or equal
var_dump($dt_01->lt($dt_02)) . PHP_EOL;  //=> true


//----------( 範囲内かを判定 )----------
// between
var_dump(Carbon::create(2020, 10, 10)->between($dt_01, $dt_02)) . PHP_EOL;  //=> true
var_dump(Carbon::create(2022, 10, 10)->between($dt_01, $dt_02)) . PHP_EOL;  //=> false
```



## 比較の結果の値を返す
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);

//----------( 値が大きい方を返す )----------
// max
echo $dt_01->max($dt_02) . PHP_EOL;  //=> 2020-11-01 00:00:00


//----------( 値が小さい方を返す )----------
// min
echo $dt_01->min($dt_02) . PHP_EOL;  //=> 2020-10-01 00:00:00
```



## 差分を計算
```php
$dt_01 = Carbon::create(2020, 10, 1);
$dt_02 = Carbon::create(2020, 11, 1);

echo $dt_01->diffInDays($dt_02)    . PHP_EOL;  //=> 31
echo $dt_01->diffInHours($dt_02)   . PHP_EOL;  //=> 744
echo $dt_01->diffInMinutes($dt_02) . PHP_EOL;  //=> 44640

Carbon::setLocale('ja');
echo $dt_01->diffForHumans($dt_02) . PHP_EOL;  //=> 1ヶ月前　（読みやすいように整形されている）
```



## 日付計算をテスト  setTestNow
```php
$birthday = Carbon::create(1990, 10, 1);

Carbon::setTestNow(Carbon::create(2020, 10, 1));  // A
echo Carbon::now() . PHP_EOL;  //=> 2020-10-01 00:00:00
Carbon::setTestNow();  // B
echo Carbon::now() . PHP_EOL;  //=> 2020-04-15 00:50:05

if ($birthday->isBirthday(Carbon::now())) {
  echo ':)' . PHP_EOL;   // A
} else {
  echo ':<' . PHP_EOL;   // B
}
```



