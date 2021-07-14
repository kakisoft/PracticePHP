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

// Laravel で使う時も、こんな感じでＯＫ
use Carbon\Carbon;
```


## 基本
```php
$dt_01 = new Carbon();
echo $dt_01 . PHP_EOL;  //=> 2020-04-15 00:22:42（本日の日付）
```


## 日付作成
```php
$dt_02 = new Carbon();
// 現在の日時
$dt_03 = Carbon::now();

// 指定した日付のオブジェクトを作成
$dt_04 = new Carbon('2020-04-20 11:23:45');
$dt_05 = new Carbon('tomorrow');

// 現在の日付
$dt_06 = Carbon::today();

// 明日の日付・昨日の日付
$dt_07 = Carbon::tomorrow();
$dt_08 = Carbon::yesterday();

$dt_09 = Carbon::parse('2020-04-20 11:23:45');
$dt_10 = Carbon::create(2020, 4, 20, 11, 23, 45);

$dt_11 = Carbon::createFromFormat('Y/m/d H', '2015/12/20 20');
```

## 切り出し
```php
$dt = Carbon::parse('2020-04-20 11:23:45');

echo $dt->year        . PHP_EOL;  //=> 2020
echo $dt->month       . PHP_EOL;  //=> 4
echo $dt->day         . PHP_EOL;  //=> 20
echo $dt->hour        . PHP_EOL;  //=> 11
echo $dt->minute      . PHP_EOL;  //=> 23
echo $dt->second      . PHP_EOL;  //=> 45
echo $dt->dayOfWeek   . PHP_EOL;  //=> 1    （週のうちの何日目か？）
echo $dt->dayOfYear   . PHP_EOL;  //=> 111  （年のうちの何日目か？）
echo $dt->weekOfMonth . PHP_EOL;  //=> 3
echo $dt->weekOfYear  . PHP_EOL;  //=> 17
echo $dt->timestamp   . PHP_EOL;  //=> 1587349425
echo $dt->tzName      . PHP_EOL;  //=> Asia/Tokyo
echo $dt->format('Y年m月d日') . PHP_EOL;     //=> 2020年04月20日
echo $dt->format('Y/m/d H:i:s') . PHP_EOL;  //=> 2020/04/20 11:23:45
```

## format の注意点
```php
Carbon::today()->format('Y-m-d  H:i:s');  // today() だと、時間情報が取れない（ 00:00:00 ）
Carbon::now()->format('Y-m-d  H:i:s');    // now() で時間まで取れる。（ 03:22:28 ）

// // https://stackoverflow.com/questions/51882715/convert-am-pm-to-24-hours-clock-in-laravel-input-field
// \Carbon\Carbon::now()->format('H:i:s') //24 hour format
// \Carbon\Carbon::now()->format('g:i a') //12 hour format
```


## 日付の判定
```php
// 実行日： 2020/04/16 04:19:34
$dt = new Carbon('2020-04-16 11:23:45');
var_dump($dt->isToday())     . PHP_EOL;  //=> true
var_dump($dt->isTomorrow())  . PHP_EOL;  //=> false
var_dump($dt->isYesterday()) . PHP_EOL;  //=> false
var_dump($dt->isFuture())    . PHP_EOL;  //=> true
var_dump($dt->isPast())      . PHP_EOL;  //=> false
var_dump($dt->isLeapYear())  . PHP_EOL;  //=> true
var_dump($dt->isWeekday())   . PHP_EOL;  //=> true
var_dump($dt->isWeekend())   . PHP_EOL;  //=> false
var_dump($dt->isSameDay(Carbon::now())) . PHP_EOL;  //=> true
```


## パース（日付型に変換）
パースできない時、CRITICAL critical 9999900001 A system error has occurred  
例外が出てしまうので、この方法で日付キャストできるかどうかのチェックは少し乱暴か。
```php
    $date = Carbon::parse('20210101');      // 2021-01-01 00:00:00
    $date = Carbon::parse('2022-02-02');    // 2022-02-02 00:00:00
    $date = Carbon::parse('2023/03/03');    // 2023-03-03 00:00:00
```


## 加算・減算
元の値が変わります。  
具体的には、「$dt->addYear()」を実行すると、$dt インスタンスの日付は１年後になります。  
```php
$dt = new Carbon('2020-04-16 11:23:45');
echo $dt->addYear()   . PHP_EOL;  //=> 2021-04-16 11:23:45   +1年
echo $dt->addYears(3) . PHP_EOL;  //=> 2024-04-16 11:23:45   +1 +3年
echo $dt->subYear()   . PHP_EOL;  //=> 2023-04-16 11:23:45   +1 +3年 -1年
echo $dt->subYears(3) . PHP_EOL;  //=> 2020-04-16 11:23:45   +1 +3年 -1年 -3年

// add, sub
// Years(n)
// Year, Month, Day, Hour, Minute, Second
// Weekday

echo $dt->addWeekdays(3) . PHP_EOL;  //=> 2020-04-21 11:23:45
echo $dt->addWeekdays(3)->addHours(3)->addMinutes(20) . PHP_EOL;  //=> 2020-04-24 14:43:45
```


## 元の値を変えずに、未来（or過去）の日付を取得
```php
$dt = new Carbon('2020-04-16 11:23:45');
echo $dt->copy()->addYear() . PHP_EOL;  //=> 2021-04-16 11:32:56   // 元の値を変えずに、１年後の日付を取得
echo $dt                    . PHP_EOL;  //=> 2020-04-16 11:32:56
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


// subDays もあるみたい。
echo $dt_01->startOfWeek()->subDays(1)     . PHP_EOL;  //=> 2020-04-12 00:00:00    週の開始日（日曜）
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



