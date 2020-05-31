## コントローラ作成
```
php artisan make:controller PostsController
php artisan make:controller NewsController --resource

/app/Http/Controllers/PostsControlloer.php
```
--resource オプションを付けると、  
index, create, store, show, edit, update, destroy といったメソッドが作成される。  


## コントローラを Controllers\API の階層に作成
```
php artisan make:controller API/Question01ApiController
```
API のコントローラは「xxxApiController」とした方がいいかもしんない。  
理由は webコントローラ作る時に、名前がバッティングする可能性があるから。  
（上記の例では、「Question01Controller」とバッティングしないようにしている。）  
バッティングしても問題ない規模なら別にいいとは思うけど、規模が大きくなるとカオス化しそうなので、影響が少ないうちから分けるクセを付けておいた方がいいかもしんない。  

________________________________________________________________________
# ルーティング

#### routes\web.php
```php
Route::get('/', 'PostsController@index');
Route::get('/posts/{post}', 'PostsController@show')->where('post', '[0-9]+');
Route::get('/posts/create', 'PostsController@create');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{post}/edit', 'PostsController@edit');
Route::patch('/posts/{post}', 'PostsController@update');
Route::delete('/posts/{post}', 'PostsController@destroy');
Route::post('/posts/{post}/comments', 'CommentsController@store');
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');

// 異なる階層のコントローラを呼ぶ場合（例「Controllers\API\」）
Route::get('/question01', 'API\Question01Controller@index');
```

#### routes\api.php
```php
// 要プリフィックス
Route::get('call/me', 'API\CallMeAPIController@callMeGet');
Route::post('call/me', 'API\CallMeAPIController@callMePost');


// こういう書き方でもOK
Route::group(['namespace' => 'API'], function () {
    Route::get('call/me', 'CallMeAPIController@callMeGet');
    Route::post('call/me', 'CallMeAPIController@callMePost');
});
```

________________________________________________________________________
## パラメータを受け取る
```php
    //--------------------------
    // 基本形
    // Route::get('/posts/{id}', 'PostsController@show');
    //--------------------------
    public function show($id) {
        $post = Post::find($id);
        // $post = Post::findOrFail($id);  // データが見つからなかった場合、例外を返す。
        return view('posts.show')->with('post', $post);
    }

    //--------------------------
    // リクエストパラメータ
    // Route::post('/posts/{post}/comments', 'CommentsController@store');
    //--------------------------
    public function store(Request $request, Post $post) {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $comment = new Comment(['body' => $request->body]);
        $post->comments()->save($comment);
        return redirect()->action('PostsController@show', $post);
    }


    //==================================
    //  Implicit Binding
    //==================================
    // URL から $id を受け取り、 Controller でその $id を元にモデルを引っ張ってくるという流れはよく行うので、
    // 暗黙的にモデルをデータに結びつける事ができる。
    public function preview(Post $post) {
      return view('posts.show')->with('post', $post);
    }
```

__________________________________________________________________________________________________________________
## リクエストパラメータを取得
（リクエストクラスの詳細は <a href="20_Request_class.md">20_Request_class.md</a>を参照。）  

```php
    public function challenge_usersPost(Request $request) {
        $return_contents = [];

        // name blank
        $name = $request->input('name');
        if( is_null($name) ){
            $return_contents['message'] = "Validation Error, [:name, \"can't be blank\"]";
            return $return_contents;
        }

        // name already used


        // emal blank
        $email = $request->input('email');
        if( is_null($email) ){
            $return_contents['message'] = "Validation Error, [:email, \"can't be blank\"]";
            return $return_contents;
        }

        // email
        if( filter_var($email, FILTER_VALIDATE_EMAIL) == false){
            $return_contents['message'] = "Validation Error, [:email, \"is invalid\"]";
            return $return_contents;
        }


        $return_contents['message'] = "OK!";


        return $return_contents;
    }
```

________________________________________________________________________
## Viewを返す。Viewに値を渡す。
```php
// 何も値を返さず、Viewのみを返す。
// 以下の場合、 resources\views\posts\index.blade.php
return view('posts.index');　


//==================================
//            引数の渡し方
//==================================
$posts = Post::latest()->get();

// ＜方法１＞ return view() の第 2 引数に渡す
return view('posts.index', ['posts' => $posts]);　

// ＜方法２＞ with を使う
return view('posts.index')->with('posts', $posts);

// 複数のパラメータを渡す場合
return view('question01.index')->with([
    "number_of_cleared_users" => $number_of_cleared_users,
    "recent_cleared_users"    => $recent_cleared_users,
]);
```

#### View に値を渡す時の注意点
配列化して渡すとエラー。
```php
    public function inputClearedUserInfomation(string $token) {

        //-----< Get RegistrationInformation Record >-----
        $query = Question01RegistrationInformation::query();
        $query->where('for_regist_token', $token);
        $registration_information = $query->get()->toArray();  // この渡し方だとエラー。（htmlspecialchar系）
        $registration_information = $query->get();             // これだとOK.（配列化しない）


        return view('question01.input_cleared_users_infomation')->with('registration_information', $registration_information);
    }
```
__________________________________________________________________________________________________________________
## レスポンス：JSON を返す

#### response()->json()
```php
public function index()
{
    return response()->json(['apple' => 'red', 'peach' => 'pink']);
}
```

#### 配列をreturn
```php
public function index()
{
    return ['apple' => 'red', 'peach' => 'pink'];
}
```


__________________________________________________________________________________________________________________
## レスポンスオブジェクト
https://readouble.com/laravel/5.5/ja/responses.html

#### Eloquentコレクションを返すと、自動的に JSON へ変換される
```php
    public function show($id)
    {
        return response(News::all());
        return response(News::find($id));
    }
```

#### ヘッダ指定
```php
Route::get('home', function () {
    return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');


    return response($sample)
                ->header('Content-Type', $type)
                ->header('X-Header-One', 'Header Value')
                ->header('X-Header-Two', 'Header Value');
});
```

__________________________________________________________________________________________________________________
## リダイレクト
https://storehouse-techhack.com/laravel-response/
```php
Route::get('/', function () {
    // サイト内
    return redirect('home/welcome');

    // 外部
    return redirect()->away('https://storehouse-techhack.com/');
});
```

#### コントローラアクションへのリダイレクト
```php
return redirect()->action('HomeController@index');


return redirect()->action(
    'UserController@profile', ['id' => 1]
);
```

#### 名前付きルートへのリダイレクト
```php
Route::get('/', function () {
    return redirect()->route('sample', ['id' => '1']);
});
```
```php
    return redirect(route('sample', [
        'param1' => $param1,
        'param2' => $param2,
    ]));
```

#### 直前のページ
```php
$previous_url = app('url')->previous();

return app('url')->previous();
```

________________________________________________________________________
# デバッグ

## dd
dump & die。  
結果を出力してその場で処理を終了させてくれる。  
```php
        dd($posts->toArray());
```

________________________________________________________________________
# セキュリティ

## CSRF 対策
```
{{ csrf_field() }}
```
最終的には、
```html
<input type="hidden" name="_token" value="7753xoabfc5SK4hv1mJo3NGwC47DLZ2ZbmGoJihX">
```
といった値が出力される。  
webミドルウェアグループに含まれている、VerifyCsrfToken ミドルウェアが動いている。（らしい）  

________________________________________________________________________
# よく使う Model コマンド

```php
        // $posts = \App\Models\Post::all();
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->get();

        // created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
        // 「Post::latest()->get();」で、上記と同一の意味。
        $posts = Post::latest()->get();
```

________________________________________________________________________



