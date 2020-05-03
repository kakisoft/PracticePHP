# Validate 用のクラスを作成
Request クラスの代わりに使える。

#### コマンド例
```
php artisan make:request PostRequest
```

#### app/Http/Requests/PostRequest.php
```php
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|min:3',
            'body' => 'required'
        ];
    }

    // Validation のエラーメッセージのカスタマイズ
    public function messages() {
      return [
        'title.required' => 'please enter title!!!',
        'body.required'  => 'please enter body!!!'
      ];
    }
```


____________________________________________________________
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


