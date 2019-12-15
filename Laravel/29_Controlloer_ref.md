## リダイレクト
```php
// redirect関数にパスを指定する方法
return redirect($to = null, $status = 302, $headers = [], $secure = null);

// redirect関数で取得したリダイレクタインスタンスにパスを指定する方法
return redirect()->to($path, $status = 302, $headers = [], $secure = null);

// redirect関数で取得したリダイレクタインスタンスにルートを指定する方法
return redirect()->route($route, $parameters = [], $status = 302, $headers = []);

// redirect関数で取得したリダイレクタインスタンスにアクションを指定する方法
return redirect()->action($action, $parameters = [], $status = 302, $headers = []);

// redirect関数で取得したリダイレクタインスタンスに外部ドメインを指定する方法
return redirect()->away($path, $status = 302, $headers = []);

// コントローラを使用せずにリダイレクトするルートを定義する方法
Route::redirect($uri, $destination, $status = 301);


```


