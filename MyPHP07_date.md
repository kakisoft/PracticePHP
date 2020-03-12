#### タイムゾーン一覧
https://www.php.net/manual/ja/timezones.asia.php  


## 現在の時間を取得
```php
// 現在の時間を取得（必要に応じて、タイムゾーンをセット）
date_default_timezone_set('Asia/Tokyo');
echo date('h:i:s');  //=> 05:45:01

// デフォルトのタイムゾーンを取得
$default_timezone = date_default_timezone_get();
var_dump( $default_timezone );  //=> string(3) "UTC"
```


## 現在の時間を取得（ Unix タイムスタンプ ）
Unixタイムスタンプ - 協定世界時（UTC）での1970年1月1日午前0時0分0秒からの形式的な経過秒数
```php
//----------( mktime )----------
// 日付を Unix のタイムスタンプとして取得する
date_default_timezone_set('Asia/Tokyo');
echo date('"Y/m/d H:i:s', mktime(1, 2, 3, 4, 5, 2006));                 //=> "2006/04/05 01:02:03

echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000));  //=> July 1, 2000 is on a Saturday
echo date('c', mktime(1, 2, 3, 4, 5, 2006));                            //=> 2006-04-05T01:02:03+09:00


echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997));  //=> "Jan-01-1998"
echo date("M-d-Y", mktime(0, 0, 0, 13, 1, 1997));   //=> "Jan-01-1998"
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 1998));    //=> "Jan-01-1998"
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 98));      //=> "Jan-01-1998"


//----------( 現在の Unix タイムスタンプ(time) )----------
var_dump( time() );  //=> int(1584001820)

$nextWeek = time() + (7 * 24 * 60 * 60);
                   // 7 日 * 24 時間 * 60 分 * 60 秒
var_dump($nextWeek);


//----------( マイクロ秒まで )----------
var_dump( microtime() );  //=> string(21) "0.89002100 1584002005"

$time_start = microtime(true);

// しばらくスリープ
usleep(100);

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Did nothing in $time seconds\n";
```


## 時間の差分
```php
$a = '2018/08/31 10:20:00';
$b = '2018/08/31 10:15:10';

diff($a, $b);

function diff($a, $b) {
    $diff_a = strtotime($a);
    $diff_b = strtotime($b);
    $secdiff = abs($diff_b - $diff_a);

    $dif_days = $secdiff/(60*60*24);        // 日付の差分
    $dif_minutes = $secdiff/(60*60*24*60);  // 分の差分
    var_dump($dif_days); echo "<br>";
    var_dump($dif_minutes);
}
```

```php
float(0.0033564814814815)
float(5.5941358024691E-5)
```

_____________________________________________________________________________________
## 日付
```
strtotime
(PHP 4, PHP 5, PHP 7)

strtotime — 英文形式の日付を Unix タイムスタンプに変換する
```

## 日付を指定フォーマットに変換
```php
$a4 =  date('Y/m/d H:i',strtotime('2018-09-18 16:58:33.159892+09'));
echo $a4 . "<br>";   //=>  2018/09/18 16:58
```


## 現在の日付を取得
```php
echo date("Y-m-d");        // 2019-09-13
echo PHP_EOL;
echo date("Y/m/d H:i:s");  // 2019/09/13 11:30:14
```


## 日付の比較
unix_time
```php
$timestamp1 = time();
$timestamp2 = strtotime($recordInstance[0]['exec_date']);  //postgers:TIMESTAMP
$secdiff = abs($timestamp1 - $timestamp2);
$mindiff = $secdiff/(60);			
$dif_days = $secdiff/(60*60*24);
```


## 日付取得
```php
$date = '2015-12-31';
date('Y年m月d日',  strtotime($date));  // 2015年12月31日

$today = date('Y-m-d');              //2018-10-16
$lastDayOfThisMonth = date('Y-m-t'); //2018-10-31

$thisYear = date('Y');
$lastYear = $thisYear -1;

//特定年月の最終日を取得
$month = '2014-02'; 
$firstDate = date('Y-m-d', strtotime('first day of ' . $month));
$lastDate = date('Y-m-d', strtotime('last day of ' . $month));
```


## 日付の妥当性チェック
```php
$date = "2018/01/32";

//何と、2018/02/01 と判定してしまう。
$d = DateTime::createFromFormat('Y/m/d', $date);



if(checkdate(2, 29, 2016)) {
  echo '受け付けました。';
} else {
  echo '存在しない日付です。';
}
```
