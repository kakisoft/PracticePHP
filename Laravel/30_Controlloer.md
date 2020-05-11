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
php artisan make:controller API/CallMeAPIController
```

#### api.php
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
## dd
dump & die。  
結果を出力してその場で処理を終了させてくれる。  
```php
        dd($posts->toArray());
```

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


## Viewに値を渡す
```php
use App\Models\Post;

class PostsController extends Controller
{
    //==================================
    // 
    //==================================
    public function index() {
        // $posts = \App\Models\Post::all();
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->get();

        // created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
        // 「Post::latest()->get();」で、上記と同一の意味。
        $posts = Post::latest()->get();

        // $posts = [];


        // dd($posts->toArray());


        //----------------------------------------------
        //   resources/views/posts/index.blade.php 
        //----------------------------------------------

        // return view('posts.index');　

        // 【 引数の渡し方 】
        // ＜方法１＞ return view() の第 2 引数に渡す
        return view('posts.index', ['posts' => $posts]);　

        // ＜方法２＞ with を使う
        return view('posts.index')->with('posts', $posts);
    }


    //==================================
    //  show アクション
    //==================================
    // public function show($id) {
      // $post = Post::find($id);
      $post = Post::findOrFail($id);
      return view('posts.show')->with('post', $post);
    }

    //==================================
    //  Implicit Binding
    //==================================
    // URL から $id を受け取り、 Controller でその $id を元にモデルを引っ張ってくるという流れはよく行うので、
    // 暗黙的にモデルをデータに結びつける事ができる。
    public function preview(Post $post) {
      return view('posts.show')->with('post', $post);
    }

}
```
__________________________________________________________________________________________________________________
## JSON を返す

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
## リクエストパラメータを取得
（リクエストクラスの詳細は <a href="14_Model_Request.md">14_Model_Request.md</a>を参照。）

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

__________________________________________________________________________________________________________________
## リダイレクト
https://storehouse-techhack.com/laravel-response/
```php
Route::get(‘/‘, function () {
    // サイト内
    return redirect('home/welcome’);

    // 外部
    return redirect()->away('https://storehouse-techhack.com/');
});
```

パラメータ付き
```php
Route::get('/', function () {
	return redirect()->route(‘sample’, [’id’ => ’1’]);
});
```


