## Validate
https://readouble.com/laravel/5.8/ja/validation.html  
```php
    public function store(Request $request) {
      $this->validate($request, [
        'title' => 'required|min:3',
        'body' => 'required'
      ]);
      $post = new Post();
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }
```



