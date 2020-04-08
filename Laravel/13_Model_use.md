ただし、この created_at で新しい順に取ってくるという処理はよく行うので、 Laravel では実は latest() という書き方も用意されていて、 Post::latest()->get(); というように書くと上と全く同じ意味になるのでそれも覚えておくと良いでしょう。

$posts = Post::orderBy('created_at', 'desc')->get();

// created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
// 「Post::latest()->get();」で、上記と同一の意味。
$posts = Post::latest()->get();


```php
        // $posts = \App\Models\Post::all();
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->get();

        // created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
        // 「Post::latest()->get();」で、上記と同一の意味。
        $posts = Post::latest()->get();
```


