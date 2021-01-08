## リダイレクトされて、トレースが難しい場合
```php
exit；
にて、処理を終了させる。
```

## ブラウザ側にトレース
```php
echo "<pre>";
var_dump($array);  // 型まで分かる

print_r($array);   // 見やすい

var_export($array);
echo "</pre>";
```

## エラー内容をブラウザ上に表示
```php
/etc/php.ini　（環境によってパスが違うかも）
display_errors = Off　⇒  display_errors = On


/* または、php のコードにて以下を指定 */

// display_errorsをOFFに設定
ini_set('display_errors', 0);

// display_errorsをONに設定
ini_set('display_errors', 1);
```

## ログに吐いて確認
**＜ サーバ側 ＞**  
```
sudo mkdir /test01
sudo touch testlog01

sudo chown apache:apache /test01
sudo chown apache:apache /test01/testlog01
```

**＜ PHP ＞**  
```
error_log($errmessage,"3","/test01/testlog01");
```


______________________________________________________

# ログ出力設定


## 表示するエラーのレベルを設定

### 【 php.iniから設定する方法 】
```
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
```

|  エラーレベル定数 |  機能                                        |
|:---------------|:---------------------------------------------|
|  E_ALL         |  サポートされている全てのエラーと警告              |
|  E_ERROR       |  重大な実行時エラー                             |
|  E_WARNING     |  実行時の警告（致命的ではない）                   |
|  E_PARSE       |  コンパイル時のパースエラー                      |
|  E_NOTICE      |  実行時の警告（エラーが起こりうる状況時）          |
|  E_DEPRECATED  |  将来のバージョンでは動作しないコードについての警告  |
|  E_STRICT      |  実行時の注意                                  |


定数名の前の「~」は否定を意味し、「E_ALL & ~E_DEPRECATED & ~E_STRICT」はE_DEPRECATEDとE_STRICT以外のすべてのエラーを出力することを意味します。  

php.iniを設定したあとは、Webサーバーを再起動することで設定が有効になります。  

### server
```php
var_dump($_SERVER['SERVER_NAME']);
```


### 【 error_reporting関数から設定する方法 】
Webサーバの再起動不要。
```php
/* php のコード */

int error_reporting ([ int $レベル ] )


// エラーや警告を表示
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// 全てのエラーを表示
error_reporting(E_ALL);
```


## debug_backtrace（ファイルパス）
```php
$traceArr = version_compare(phpversion(), '5.4.0') >=0 ? debug_backtrace(false, 1) : debug_backtrace();
$path = $traceArr[0]['file'];

echo "<pre>";
print_r($traceArr);
print_r($path);
echo "</pre>";


//debug_backtrace(false, 1)    //第一引数： trueだとObject、falseだとArray。多分。
                               //第二引数： 0 だと情報がいっぱい出てくる。
```

______________________________________________________

# その他参考

PHPでのログ出力　まとめ  
<https://qiita.com/iwason/items/8dc9f62b4118186cf2df>  
　  
【PHP入門】エラー表示の設定とエラーログの出力方法  
<https://www.sejuku.net/blog/24522>  

