## Blade
Laravel のテンプレートエンジン


______________________________________
# View

## /myblog/resources/views/posts/index.blade.php
/public/css/styles.css
```php
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Blog Posts</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Blog Posts</h1>
    <ul>
      {{--
      @foreach ($posts as $post)
      <li><a href="">{{ $post->title }}</a></li>
      @endforeach
      --}}
      @forelse ($posts as $post)
      <li><a href="">{{ $post->title }}</a></li>
      @empty
      <li>No posts yet</li>
      @endforelse
    </ul>
  </div>
</body>
</html>
```

## URL を生成する命令
 * url
 * action
など複数あるが、挙動に差異は無い。
```php
      @forelse ($posts as $post)
      <!-- <li><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></li> -->
      <!-- <li><a href="{{ url('/posts', $post->id) }}">{{ $post->title }}</a></li> -->
      <!-- <li><a href="{{ action('PostsController@show', $post->id) }}">{{ $post->title }}</a></li> -->
      <li><a href="{{ action('PostsController@show', $post) }}">{{ $post->title }}</a></li>
      @empty
```

* url() を使う場合
URL がどうなっているかを知っている必要がある  
ルーティングで割り当てられているコントローラーのアクション名は知らなくてもいい  

* action() を使う場合
URL がどうなっているかは知らなくてもいい  
ルーティングで割り当てられているコントローラーのアクション名を知っている必要がある  


という前提の違いがある。

