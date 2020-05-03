## artisan コマンドでルーティング情報を表示
php artisan route:list  
php artisan route:list -c  
php artisan route:list --path=news  
php artisan route:list --method=patch  

```
--path[=PATH]        Filter the routes by path
-c, --compact            Only show method, URI and action columns
```

________________________________________________________________________
# routs/web.php
Web アプリ。  
#### （エンドポイント例）
```
posts
posts/create
posts/{post}
```

# routes\api.php
API。  
エンドポイントは、「 api/ 」となる。
#### （エンドポイント例）
```
api/news
api/news/create
```

________________________________________________________________________
## 基本
```php
// ↓ 「resources\views\welcome.blade.php」を返す
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PostsController@index');

// コントローラに渡す値を設定。（ $id ）        show アクション
Route::get('/posts/{id}', 'PostsController@show');

// Implicit Binding
Route::get('/posts/preview/{post}', 'PostsController@preview');

// 正規表現で値のルールを指定
Route::get('/books/{book}', 'BooksController@show')->where('book', '[0-9]+');

// 複数パラメータ
Route::get('/sample/{a}/{b}', 'SampleController@test');

// 複数パラメータ＋正規表現による制約
Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```


## 使用例
```php
Route::post('/posts', 'PostsController@store');
Route::patch('/posts/{post}', 'PostsController@update');
Route::delete('/posts/{post}', 'PostsController@destroy');

Route::post('/posts/{post}/edit', 'PostsController@edit');
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');
```


#### 注意点
```php
Route::get('/posts/{post}', 'PostsController@show');     // 「/posts/create」は、こちらの設定が有効となる。
Route::get('/posts/create', 'PostsController@create');   // こっちの設定は有効とならない。（1.こっちを先に書く、2.正規表現などで回避する等の方法がある）
```

________________________________________________________________________
## Route::resource
CRUDルーティングを一度に行うことができる。  
（ GET, POST, PUT, PATCH, DELETE が設定される）
```php
Route::resource('news', 'NewsController');
```

#### フィルタリング
アクション名を指定する？
```php
// onlyを使う（ホワイトリスト方式）　
Route::resource('hoge', 'NewsController', ['only' => ['create', 'edit']]);

// exceptを使う（ブラックリスト方式）
Route::resource('hoge', 'NewsController', ['except' => ['destroy', 'store']]);
```

https://readouble.com/laravel/5.7/ja/controllers.html  

|  動詞       |  URI                   |  アクション |  ルート名         |
|:------------|:-----------------------|:----------|:-----------------|
|  GET        |  /photos               |  index    |  photos.index    |
|  GET        |  /photos/create        |  create   |  photos.create   |
|  POST       |  /photos               |  store    |  photos.store    |
|  GET        |  /photos/{photo}       |  show     |  photos.show     |
|  GET        |  /photos/{photo}/edit  |  edit     |  photos.edit     |
|  PUT/PATCH  |  /photos/{photo}       |  update   |  photos.update   |
|  DELETE     |  /photos/{photo}       |  destroy  |  photos.destroy  |


________________________________________________________________________
## Route::group （ルートグループ）
一括して定義
```php
Route::group(['namespace' => 'API'], function () {

    //   以下、
    // App\Http\Controllers\API\AuthController
    //   のコントローラを参照する

    Route::post('me', 'AuthController@login')->name('auth.login');
    Route::delete('me', 'AuthController@logout');
});
```

________________________________________________________________________
## ->name （名前付きルート）
https://readouble.com/laravel/5.7/ja/routing.html  
名前付きルートは特定のルートへのURLを生成したり、リダイレクトしたりする場合に便利です。  
ルート定義にnameメソッドをチェーンすることで、そのルートに名前がつけられます。  
```php
Route::get('user/profile', 'UserProfileController@show')->name('profile');
```

名前付きルートへのURLを生成
```php
// URLの生成
$url = route('profile');

// リダイレクトの生成
return redirect()->route('profile');
```

________________________________________________________________________
## middleware （ミドルウェア）
グループ中の全ルートにミドルウェアを指定するには、そのグループを定義する前にmiddlewareメソッドを使用します。
```php
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        // firstとsecondミドルウェアを使用
    });

    Route::get('user/profile', function () {
        // firstとsecondミドルウェアを使用
    });
});
```

________________________________________________________________________
## ルーティングの「api」を消す

#### app\Providers\RouteServiceProvider.php
prefix を 'api' → null に変更
```php
    protected function mapApiRoutes()
    {
        Route::prefix(null)
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
```


