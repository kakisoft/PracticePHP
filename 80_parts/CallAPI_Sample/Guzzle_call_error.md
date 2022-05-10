## 
```
PHP Fatal error:  Uncaught GuzzleHttp\Exception\RequestException: cURL error 60: SSL certificate problem: unable to get local issuer certificate (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.docurain.jp/api/token/ in C:\kaki\docurain-for-dev\vendor\guzzlehttp\guzzle\src\Handler\CurlFactory.php:211
```

## ‘cURL error 60’エラーが出たときの対処法 ‘cURL error 60: SSL certificate problem: unable to get local issuer certificate’
http://nanoappli.com/blog/archives/7992
このエラーは、SSL暗号化されているhttpsのサイトにアクセスしようとした際にそのサーバが信頼できるか否かの証明書(ca証明書)が取得できなかった時に発生します。


## cURL error 60: SSL certificate (GuzzleHttp v6) | まだどう？
https://madadou.info/2018/05/08/curl-error-60/

Win環境cURLでクライアント証明書が見つけられないために起こる問題のよう

https://curl.haxx.se/ca/cacert.pemから証明書をDLして保存
php.iniに設定して再起動 Finish!
これだけで完了です。


#### php.ini
```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo ="ここに証明書のパスを指定"
```


## クライアント証明書を検証しないで解決
Guzzle側のオプションで「証明書の検証無し」を指定してやることでエラーが出なくなる。  

http://docs.guzzlephp.org/en/stable/request-options.html#verify


```php
$config = ['base_uri' => 'https://hogehoge.com'];
$client = new GuzzleHttp\Client($config);
$res = $client->request('GET', '/', ['verify' => false]);　//ここでオプション指定
return $res->getStatusCode();
```

