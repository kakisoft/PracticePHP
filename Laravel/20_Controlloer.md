## routs/web.php
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

```


## コントローラ作成
```
php artisan make:controller PostsController


/app/Http/Controllers/PostsControlloer.php
```


## dd
dump & die。  
結果を出力してその場で処理を終了させてくれる。  
```php
        dd($posts->toArray());
```


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

    // 【 Implicit Binding 】
    // URL から $id を受け取り、 Controller でその $id を元にモデルを引っ張ってくるという流れはよく行うので、
    // 暗黙的にモデルをデータに結びつける事ができる。
    public function preview(Post $post) {
      return view('posts.show')->with('post', $post);
    }

}
```


