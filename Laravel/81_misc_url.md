## urlヘルパ
https://readouble.com/laravel/5.7/ja/urls.html  
```php
/*

http://localhost:8000/api/call/me?param1=val1

*/


//==========< 直前のリクエストの完全なURL >==========
$url_previous = url()->previous();
//=> http://localhost:8000


//==========< クエリ文字列を除いた現在のURL >==========
$url_current = url()->current();
//=> http://localhost:8000/api/call/me


//==========< クエリ文字列を含んだ現在のURL >==========
$url_full = url()->full();
//=> http://localhost:8000/api/call/me?param1=val1


```


## その他参考
https://blog.capilano-fw.com/?p=2537  

