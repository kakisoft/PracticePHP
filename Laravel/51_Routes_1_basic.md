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


//-----( コントローラのメソッドを定義　→　ルーティングルールを設定、といった順番で書くこともできる )-----
Route::get('/posts/{post}/edit', 'PostsController@edit');
Route::get('/posts/{post}/editaaaa/bbb/ccc', 'PostsController@edit');

```


#### 注意点
```php
Route::get('/posts/{post}', 'PostsController@show');     // 「/posts/create」は、こちらの設定が有効となる。
Route::get('/posts/create', 'PostsController@create');   // こっちの設定は有効とならない。（1.こっちを先に書く、2.正規表現などで回避する等の方法がある）
```


#### web.php にリダイレクトを書ける
```php
Route::get('/question01/challenge_users/save/', function () {
    return redirect('/question01/winners');
});
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
https://laravel.com/docs/8.x/controllers  

|  動詞       |  URI                   |  アクション |  ルート名         |
|:------------|:-----------------------|:-----------|:-----------------|
|  GET        |  /photos               |  index     |  photos.index    |
|  GET        |  /photos/create        |  create    |  photos.create   |
|  POST       |  /photos               |  store     |  photos.store    |
|  GET        |  /photos/{photo}       |  show      |  photos.show     |
|  GET        |  /photos/{photo}/edit  |  edit      |  photos.edit     |
|  PUT/PATCH  |  /photos/{photo}       |  update    |  photos.update   |
|  DELETE     |  /photos/{photo}       |  destroy   |  photos.destroy  |



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
Route::get('/question01',  'Question01Controller@index')->name('question01.index');
Route::get('user/profile', 'UserProfileController@show')->name('profile');
```

名前付きルートへのURLを生成
```php
// URLの生成
$url = route('profile');

// リダイレクトの生成
return redirect()->route('profile');
return redirect()->route('question01.index', ['special_message'=>'spm']);
```

##### 名前付きルートの利点
https://qiita.com/kazuhei/items/935257b0d72fa314d461  

________________________________________________________________________
## リダイレクト
GET扱いになる？  
パラメータが丸見えやぞ・・・  
```php
// 元の画面に戻る
return redirect()->back();


// 名前付きルートを指定してリダイレクト
return redirect()->route('profile');
return redirect()->route('question01.index', ['special_message'=>'spm']);
```

https://www.larashout.com/deep-dive-into-laravel-redirect-method
```php
// web.php
Route::get('post/{id}', 'PostController@edit')-name('post.edit');

// Controller
return redirect()->route('post.edit', ['id' => $post->id]);

return redirect()->route('post.edit', $post->id);

return redirect()->back()->with('success', 'Post saved successfully.');

return redirect()->back()
                    ->with('success', 'Post saved successfully.')
                    ->with('post_id', $post->id);


$response = [
    'success' => 'Post saved successfully.',
    'post_id' => $post->id,
];
return redirect()->back()->with($response);

return redirect()->action('PostController@edit');

return response()->action('PostController@edit', ['id' => $post->id]);
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

________________________________________________________________________
________________________________________________________________________
________________________________________________________________________
## prefix を付ける
コントローラの下に「API」階層を作った場合、↓みたいな感じになる。
```php
// prefix
Route::group(['prefix' => 'group01'], function () {
    Route::get('call/me', 'API\Question01ApiController@callMeGet');
    Route::post('call/me', 'API\Question01ApiController@callMePost');
    Route::get('challenge_users', 'API\Question01ApiController@challenge_usersGet');
    Route::post('challenge_users', 'API\Question01ApiController@challenge_usersPost');
});
```

```
+----------+-----------------------------------+----------------------------------------------------------------------+
| Method   | URI                               | Action                                                               |
+----------+-----------------------------------+----------------------------------------------------------------------+
| GET|HEAD | api/group01/call/me               | App\Http\Controllers\API\Question01ApiController@callMeGet           |
| POST     | api/group01/call/me               | App\Http\Controllers\API\Question01ApiController@callMePost          |
| GET|HEAD | api/group01/challenge_users       | App\Http\Controllers\API\Question01ApiController@challenge_usersGet  |
| POST     | api/group01/challenge_users       | App\Http\Controllers\API\Question01ApiController@challenge_usersPost |
+----------+-----------------------------------+----------------------------------------------------------------------+
```

________________________________________________________________________
## Route::prefix('api')->group(
コントローラの下に「API」階層を作った場合、↓みたいな感じになる。
```php
Route::prefix('group01')->group(function () {
    Route::get('call/me', 'API\Question01ApiController@callMeGet');
    Route::post('call/me', 'API\Question01ApiController@callMePost');
    Route::get('challenge_users', 'API\Question01ApiController@challenge_usersGet');
    Route::post('challenge_users', 'API\Question01ApiController@challenge_usersPost');
});
```

```
+----------+-----------------------------------+----------------------------------------------------------------------+
| Method   | URI                               | Action                                                               |
+----------+-----------------------------------+----------------------------------------------------------------------+
| GET|HEAD | api/group01/call/me               | App\Http\Controllers\API\Question01ApiController@callMeGet           |
| POST     | api/group01/call/me               | App\Http\Controllers\API\Question01ApiController@callMePost          |
| GET|HEAD | api/group01/challenge_users       | App\Http\Controllers\API\Question01ApiController@challenge_usersGet  |
| POST     | api/group01/challenge_users       | App\Http\Controllers\API\Question01ApiController@challenge_usersPost |
+----------+-----------------------------------+----------------------------------------------------------------------+
```

________________________________________________________________________
## namespace 単位に prefix まとめ

```php
// 先頭「api」をまとめて書き、先頭にプレフィックスを付ける場合、こんな感じ。
Route::group(['namespace' => 'API'], function () {
    //--------------------------------
    //         Question 01
    //--------------------------------
    Route::prefix('q01')->group(function () {
        Route::get('call/me', 'Question01ApiController@callMeGet');
        Route::post('call/me', 'Question01ApiController@callMePost');
        Route::get('challenge_users', 'Question01ApiController@challenge_usersGet');
        Route::post('challenge_users', 'Question01ApiController@challenge_usersPost');
    });

    //--------------------------------
    //         Question 02
    //--------------------------------
    Route::prefix('q02')->group(function () {
        Route::get('call/me', 'Question02ApiController@callMeGet');
        Route::post('call/me', 'Question02ApiController@callMePost');
        Route::get('challenge_users', 'Question02ApiController@challenge_usersGet');
        Route::post('challenge_users', 'Question02ApiController@challenge_usersPost');
    });

});
```

________________________________________________________________________
https://laravel.com/docs/7.x/routing

```php
Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);
```

 - HEAD
 - CONNECT
 - TRACE

 は無いみたい。
________________________________________________________________________
## apiResource
１つの命令で、まとめて定義
```php
Route::apiResource('user', UserController::class);
```

```
$ php artisan route:list
+--------+-----------+-----------------+--------------+-------------------------------------------------+------------+
| Domain | Method    | URI             | Name         | Action                                          | Middleware |
+--------+-----------+-----------------+--------------+-------------------------------------------------+------------+
|        | GET|HEAD  | api/user        | user.index   | App\Http\Controllers\Api\UserController@index   | api        |
|        | POST      | api/user        | user.store   | App\Http\Controllers\Api\UserController@store   | api        |
|        | GET|HEAD  | api/user/{user} | user.show    | App\Http\Controllers\Api\UserController@show    | api        |
|        | PUT|PATCH | api/user/{user} | user.update  | App\Http\Controllers\Api\UserController@update  | api        |
|        | DELETE    | api/user/{user} | user.destroy | App\Http\Controllers\Api\UserController@destroy | api        |
+--------+-----------+-----------------+--------------+-------------------------------------------------+------------+
```
