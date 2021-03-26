## CSRF
https://laravel.com/docs/8.x/csrf  

```php
    // CSRFトークンを格納する
    if (!in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
        $request->merge(['_token' => csrf_token()]);
    }
```


