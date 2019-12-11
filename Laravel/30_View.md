## Blade
Laravel のテンプレートエンジン


______________________________________
## e()
https://laravel.com/docs/master/helpers#method-e    
The e function runs PHP's htmlspecialchars function with the double_encode option set to true by default:  
```php
echo e('<html>foo</html>');

// &lt;html&gt;foo&lt;/html&gt;
```


## URL を生成する命令
 * url
 * action
など複数あるが、挙動に差異は無い。
```php
    @forelse ($posts as $post)
        <li><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></li>

        <li><a href="{{ url('/posts', $post->id) }}">{{ $post->title }}</a></li>

        <li><a href="{{ action('PostsController@show', $post->id) }}">{{ $post->title }}</a></li>

                                                          // Implicit Binding
        <li><a href="{{ action('PostsController@preview', $post) }}">{{ $post->title }}</a></li>
    @empty
```

* url() を使う場合
URL がどうなっているかを知っている必要がある  
ルーティングで割り当てられているコントローラーのアクション名は知らなくてもいい  

* action() を使う場合
URL がどうなっているかは知らなくてもいい  
ルーティングで割り当てられているコントローラーのアクション名を知っている必要がある  


という前提の違いがある。

