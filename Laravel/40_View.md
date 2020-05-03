## Blade
Laravel のテンプレートエンジン


______________________________________
## エスケープしつつ、改行を br に変換
```php
<p>{!! nl2br(e($post->body)) !!}</p>
```


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


## Implicit Binding
```php
                                          <!--  ↓Implicit Binding （） -->
                                          <!--  Route::get('/posts/{id}'　　→　　Route::get('/posts/{post}'　に変更。 -->
                                          <!--  引数を　show($id)　→　show(Post $post) 　に変更。 -->
                                          <!-- こうすると、$post->id としなくても、明示しなくても、id を渡す事ができる。 -->
    <a href="{{ action('PostsController@show', $post) }}">{{ $post->title }}</a>
```


## CSRF 対策
悪意のある不正な投稿を防ぐためにデフォルトで CSRF 対策が施されていて、フォームにはそのためのトークンを仕込む必要がある。  
以下のようにしけおけば、あとは Laravel が勝手にやってくれる。  
```php
<form method="post" action="{{ url('/posts') }}">
  {{ csrf_field() }}
```


## Validate
```php
    <input type="text" name="title" placeholder="enter title" value="{{ old('title') }}">
    @if ($errors->has('title'))
        <span class="error">{{ $errors->first('title') }}</span>
    @endif

    <textarea name="body" placeholder="enter body">{{ old('body') }}</textarea>
    @if ($errors->has('body'))
        <span class="error">{{ $errors->first('body') }}</span>
    @endif
```


