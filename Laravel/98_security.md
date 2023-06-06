## CSRF
https://laravel.com/docs/8.x/csrf  

```php
    // CSRFトークンを格納する
    if (!in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
        $request->merge(['_token' => csrf_token()]);
    }
```

## _
laravelのヤバい脆弱性をついたkinsing(kdevtmpfsi)というマルウェアに感染した話 CVE-2021-3129  
https://qiita.com/reopa_sharkun/items/f3819b2e8727728da82a  

* Ignition <= 2.5.1
* Laravel <= 8.4.2
* DEBUG_MODE = ON

