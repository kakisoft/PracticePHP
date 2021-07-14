【PHP】Carbon：日付の減算は、subDay($value) ではなく、subDays($value) を使おう！（公式）

__________________________________________________________________________________________

PHP の Dateユーティリティで、デファクトスタンダードの地位を築きつつあるんじゃないかと思われる Carbon。  

Laravel にデフォルトで入ったるし、色々と便利なのでよく使っているのですが、気になった事があったので調べてみた。

## 日付の減算（ subDay と subDays ）
日付の減算をする時、subDays というメソッドがあるんだけど、ネットを徘徊していると、subDay に引数を渡す使い方もよく見かける。  
具体的には以下のような感じ。
```php
$date1 = new Carbon('2021-07-15 11:23:45');
$date2 = new Carbon('2021-07-15 11:23:45');

echo $date1->subDay(1);   //=> 2021-07-14 11:23:45
echo $date2->subDays(1);  //=> 2021-07-14 11:23:45
```
見ての通り、結果は同じ。  

何なんだコレは。どっち使えばいいんだ。  
つーか統一しないとカオス化するじゃねーか。  

## 公式ドキュメントを調べてみよう！
という事で公式ドキュメント。  
https://carbon.nesbot.com/docs/  


#### Carbon::subDay
```
no arguments   

Sub one day to the instance (using date interval).  
```

#### Carbon::subDays
```
Sub days (the $value count passed in) to the instance (using date interval).
```

Carbon::subDays を使う方が良さそう。  
というか、「Carbon::subDay」の実際の挙動が、ドキュメントと違っているのでは？  


## ソースコードを読んでみよう！
という事で、Carbon のソースコードを見てみよう。  
https://github.com/briannesbitt/Carbon  


こんなコードがありました。  
#### tests\Carbon\SubTest.php
https://github.com/briannesbitt/Carbon/blob/master/tests/Carbon/SubTest.php#L261
```php
    public function testSubDayPassingArg()
    {
        // subDay should ideally be used without argument
        /** @var mixed $date */
        $date = Carbon::createFromDate(1975, 5, 10);
        $this->assertSame(8, $date->subDay(2)->day);
    }
```

***subDay should ideally be used without argument***  
***（subDayは理想的には引数なしで使用する必要があります）***  

subDay に引数を渡すと subDays と同様の動きをする事は把握しているけど、それは理想的な使い方ではないみたい。  

あと、メソッドの説明文を読んでも、subDay に引数を渡す内容は無いみたい。  

#### src\Carbon\Carbon.php
```php
 * @method $this subDays(int $value = 1) Sub days (the $value count passed in) to the instance (using date interval).
 * @method $this subDay()                Sub one day to the instance (using date interval).
```


## 結論
値を指定した日付の減算には「subDays」を使おう！



