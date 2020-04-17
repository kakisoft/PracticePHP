## ルーティング情報を表示
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
```


## 使用例
```php
Route::post('/posts', 'PostsController@store');
Route::patch('/posts/{post}', 'PostsController@update');
Route::delete('/posts/{post}', 'PostsController@destroy');

Route::post('/posts/{post}/edit', 'PostsController@edit');
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');
```

________________________________________________________________________
## resource
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

|  動詞       |  URI                   |  アクション |  ルート名            |
|:------------|:-----------------------|:----------|:-----------------|
|  GET        |  /photos               |  index    |  photos.index    |
|  GET        |  /photos/create        |  create   |  photos.create   |
|  POST       |  /photos               |  store    |  photos.store    |
|  GET        |  /photos/{photo}       |  show     |  photos.show     |
|  GET        |  /photos/{photo}/edit  |  edit     |  photos.edit     |
|  PUT/PATCH  |  /photos/{photo}       |  update   |  photos.update   |
|  DELETE     |  /photos/{photo}       |  destroy  |  photos.destroy  |


________________________________________________________________________
#### 注意点
```php
Route::get('/posts/{post}', 'PostsController@show');     // 「/posts/create」は、こちらの設定が有効となる。
Route::get('/posts/create', 'PostsController@create');   // こっちの設定は有効とならない。（1.こっちを先に書く、2.正規表現などで回避する等の方法がある）
```







