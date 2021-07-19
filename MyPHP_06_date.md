#### タイムゾーン一覧
https://www.php.net/manual/ja/timezones.asia.php  


date()、mktime()、strtotime() はよく使われているが、  
32bit のマシンでは 2038 年以降にうまく動作しないということがわかっている。  
そのため、最近だと DateTime クラスという仕組みのほうを使うのが一般的。  


## 現在の日付を取得
date の第二引数に、UNIX タイムスタンプを指定。  
```php
date_default_timezone_set('Asia/Tokyo');
echo time()                             . PHP_EOL;  //=> 1584078499
echo date('Y/m/d H:i:s', time())        . PHP_EOL;  //=> 2020/03/13 14:48:19
echo date('Y/m/d H:i:s', 1573627087)    . PHP_EOL;  //=> 2019/11/13 15:38:07
echo strtotime( '2012/04/18 15:55:53' ) . PHP_EOL;  //=> 1334732153
// strtotime — 英文形式の日付を Unix タイムスタンプに変換する

$date = new DateTime('2018-01-01 00:00:00');
echo $date->format('U');  //=> 1514764800
```

## 特定年月の最終日を取得
```php
$month = '2014-02'; 
$firstDate = date('Y-m-d', strtotime('first day of ' . $month));
$lastDate = date('Y-m-d', strtotime('last day of ' . $month));
```

## 日付を指定フォーマットに変換（DateTime::format）
```php
//// フォーマット一覧
// https://www.php.net/manual/ja/function.date.php
$date_01 = new DateTime('2018-05-06 21:08:23');
echo $date_01->format('y/n/j h:i:s');  //=> 18/5/6 09:08:23
echo $date_01->format('Y/m/d H:i:s');  //=> 2018/05/06 21:08:23
```

## 日付を指定フォーマットに変換（date_format）
```php
$date_1 = date_format( date_create('20200101'), 'Y/m/d' );
$date_1 = date_format( date_create('2020/01/01'), 'Y/m/d' );
$date_1 = date_format( date_create('2020-01-01'), 'Y/m/d' );
echo $date_1;  //=> 2020/01/01
```

## 日付を指定フォーマットに変換（strtotime）
strtotime — 英文形式の日付を Unix タイムスタンプに変換する  
```php
$a4 =  date('Y/m/d H:i',strtotime('2018-09-18 16:58:33.159892+09'));
echo $a4 . "<br>";   //=>  2018/09/18 16:58
```


## 現在の時間を取得
```php
// 現在の時間を取得（必要に応じて、タイムゾーンをセット）
date_default_timezone_set('Asia/Tokyo');
echo date('h:i:s');  //=> 05:45:01

// デフォルトのタイムゾーンを取得
$default_timezone = date_default_timezone_get();
var_dump( $default_timezone );  //=> string(3) "UTC"
```

## date_parse
date_parse — 指定した日付/時刻の詳細な情報を連想配列で返す
```php
// date_parse(string $datetime): array


$value = "20200715";
print_r( date_parse($value) );
checkdate($date['month'], $date['day'], $date['year']);

// print_r( date_parse("2006-12-12 10:00:00.5") );

/*
Array
(
    [year] => 2020
    [month] => 7
    [day] => 15
    [hour] =>
    [minute] =>
    [second] =>
    [fraction] =>
    [warning_count] => 0
    [warnings] => Array
        (
        )

    [error_count] => 0
    [errors] => Array
        (
        )

    [is_localtime] =>
)

*/
```


## 日付の差分
```php
//----------( 日にちの差分 )----------
$day1 = new DateTime('2018-04-05');
$day2 = new DateTime('2018-04-11');
$diff = $day1->diff($day2);
echo $diff->d;  //=> 6


$day1 = new DateTime('2018-04-05');
$day2 = new DateTime('2018-05-11');
$diff = $day1->diff($day2);
echo $diff->d;     //=> 6 （月が変わったのに！？　日だけで判定している模様。）
echo $diff->days;  //=> 36（このメソッドで。）



//----------( 月・年の差分 )----------
$day1 = new DateTime('2018-04-05');
$day2 = new DateTime('2019-07-11');
$diff = $day1->diff($day2);
echo $diff->m;  //=> 3（年が違うのに・・・　月だけで判定している模様。どうやら、年を考慮して差分を取るメソッドは無いみたい）
echo $diff->y;  //=> 1
// diff の戻り値は、「DateInterval」オブジェクト



//----------( 日付の比較 )----------
$date01 = new DateTimeImmutable('2020-03-15');
$date02 = new DateTimeImmutable('2020-03-20');

var_dump($date01 == $date02);  //=> bool(false)
var_dump($date01 < $date02);   //=> bool(true)
var_dump($date01 > $date02);   //=> bool(false)
```


## 日付の妥当性チェック（ is_date ）※信頼性低
https://www.php.net/manual/ja/function.checkdate.php
```php
$date = "2018/01/32";

//何と、2018/02/01 と判定してしまう。
$d = DateTime::createFromFormat('Y/m/d', $date);
```

## 日付の妥当性チェック（ checkdate ）※恐らく PHPで最も高精度
月・日・年に分けて値を入れないといけないので、使いづらい。
```php
// checkdate(int $month, int $day, int $year): bool
if(checkdate(2, 29, 2016)) {
  echo '受け付けました。';
} else {
  echo '存在しない日付です。';
}


$month = substr($argumentData,  4, 2);
$day   = substr($argumentData,  6, 2);
$year  = substr($argumentData,  0, 4);
```

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
# Unix タイムスタンプ

## 現在の時間を取得（ Unix タイムスタンプ ）
Unixタイムスタンプ - 協定世界時（UTC）での1970年1月1日午前0時0分0秒からの形式的な経過秒数
```php
//----------( mktime )----------
// 日付を Unix のタイムスタンプとして取得する
date_default_timezone_set('Asia/Tokyo');
echo date('"Y/m/d H:i:s', mktime(1, 2, 3, 4, 5, 2006));                 //=> "2006/04/05 01:02:03

// 曜日： l 
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


var_dump( microtime() );      //=> string(21) "0.62425500 1584062705"
var_dump( microtime(true) );  //=> float(1584062705.6248)
// get_as_float を TRUE に設定すると、microtime() は Unixエポック からの経過秒数を マイクロ秒で正確になるように float で表したものを返します
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



## strtotime
英文形式の日付を Unix タイムスタンプに変換する
```php
// strtotime(string $datetime, int|null $baseTimestamp = null): int|false

echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
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


// float(0.0033564814814815)
// float(5.5941358024691E-5)
```

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
# Util
date_create — DateTime::__construct() のエイリアス  
```php
//=============================
//         現在の年齢
//=============================
$time1 = '2001/7/24';
echo date_create($time1)->diff(date_create())->format('%y');  //=> 18
echo date_create($time1)->diff(date_create())->format('%y歳 %mヶ月 %d日 %h時間 %i分 %s秒');  //=> 18歳 7ヶ月 28日 0時間 51分 53秒


$time2 = new DateTime('2001/7/24');
echo $time2->diff(date_create())->format('%y');  //=> 18
echo $time2->diff(date_create())->format('%y歳 %mヶ月 %d日 %h時間 %i分 %s秒');  //=> 18歳 7ヶ月 28日 0時間 51分 53秒
```




