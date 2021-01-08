## resources/views/layouts/default.blade.php
```php
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
```

## resources/views/posts/index.blade.php
```php
{{-- layouts フォルダの中の default を使う --}}
@extends('layouts.default')

{{--
@section('title')
Blog Posts
@endsection
--}}


{{-- 「@yield('title')」に値を出力。（１行で済むなら、この書き方でも可。） --}}
@section('title', 'Blog Posts')

{{-- 「@yield('content')」に値を出力。 --}}
@section('content')
<h1>Blog Posts</h1>
<ul>
  @forelse ($posts as $post)
  <li><a href="{{ action('PostsController@show', $post) }}">{{ $post->title }}</a></li>
  @empty
  <li>No posts yet</li>
  @endforelse
</ul>
@endsection
```

