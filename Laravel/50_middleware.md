# ミドルウェア
リクエストの前後に入ってデータ加工したり。  
あとは、トークンが不正だったら abort したりとか。  

 * Beforeミドルウェア
 * Afterミドルウェア


## ミドルウェアクラスの生成
```
php artisan make:middleware HtmlMinify
```


## カーネルに登録
laravel/app/Http/Kernel.php
```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'html.minify' => \App\Http\Middleware\HtmlMinify::class, // ← 追加
];
```


## ミドルウェアのアサイン
```php
// 単体で設定する場合
Route::get('sample', 'SampleController@index')->middleware('html.minify');

// まとめて設定する場合
Route::group(['middleware' => 'html.minify', 'prefix' => ''], function() {
  Route::get('sample', 'SampleController@index');
  Route::get('sample/aaa', 'SampleController@aaa');
  Route::get('sample/bbb', 'SampleController@bbb');
});


// 引数
Route::group(['middleware' => 'html.minify02:warehouse'],
```


## 引数
```php
    public function handle(Request $request, Closure $next)

    public function handle(Request $request, Closure $next, $company_type)

    public function handle(Request $request, Closure $next, ...$allowedMethods)
```

