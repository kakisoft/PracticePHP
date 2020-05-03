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

## /myblog/resources/views/posts/show.blade.php
```php
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>{{ $post->title }}</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
  <div class="container">
    <h1>{{ $post->title }}</h1>
    <!-- 中身をエスケープしないで値を出力 -->
    <p>{!! nl2br(e($post->body)) !!}</p><!-- 改行を br タグに変換 -->
  </div>
</body>
</html>
```

## resources\views\posts\preview.blade.php
```
（省略）
```

