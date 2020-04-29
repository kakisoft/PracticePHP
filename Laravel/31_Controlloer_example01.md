## app/Http/Controllers/PostsControlloer.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function index() {
        // return "hello";

        // フォルダの区切りは「.」となっている。
        return view('posts.index');
    }


    public function show($id) {
        // $post = Post::find($id);

        // $id でデータが見つからなかった場合に、例外を返す。
        $post = Post::findOrFail($id);


        return view('posts.show')->with('post', $post);
    }


    public function preview(Post $post) {
        return view('posts.preview')->with('post', $post);
    }

}
```




