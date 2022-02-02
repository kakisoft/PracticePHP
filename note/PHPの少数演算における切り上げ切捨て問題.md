## PHPの少数演算における切り上げ切捨て問題
https://www.psi-net.co.jp/blog/?p=277

```php
<?php
$num = (0.1 + 0.7) * 10;
echo floor($num); // 小数点以下切捨て処理

// => 7
```



```php
<?php
var_dump( sprintf('%.20f', (0.1 + 0.7) * 10) );
// string(22) "7.99999999999999911182"
```


### BC Math 関数を利用する
```php
<?php
$num = bcmul(bcadd(0.1, 0.7, 3), 10, 3); // 精度は小数点以下3桁で
var_dump($num, ceil($num));
// string(5) "8.000"
// float(8)
```



### stringキャスト
```php
<?php
$num = (string)((0.1 + 0.7) * 10);
var_dump($num, ceil($num));
// string(1) "8"
// float(8)
```



### sprintfでもいいのかな
```php
<?php
$num = sprintf('%.3f', (0.1 + 0.7) * 10);
var_dump($num, ceil($num));
// string(5) "8.000"
// float(8)
```