## str_random
https://oversealife.work/2019/09/11/laravel-6-helper/  


6 からはデフォルト外れてる。
```
composer require laravel/helpers
```


## リダイレクト
```php
// redirect関数にパスを指定する方法
return redirect($to = null, $status = 302, $headers = [], $secure = null);

// redirect関数で取得したリダイレクタインスタンスにパスを指定する方法
return redirect()->to($path, $status = 302, $headers = [], $secure = null);

// redirect関数で取得したリダイレクタインスタンスにルートを指定する方法
return redirect()->route($route, $parameters = [], $status = 302, $headers = []);

// redirect関数で取得したリダイレクタインスタンスにアクションを指定する方法
return redirect()->action($action, $parameters = [], $status = 302, $headers = []);
return redirect()->action('PostsController@show', $post);

// redirect関数で取得したリダイレクタインスタンスに外部ドメインを指定する方法
return redirect()->away($path, $status = 302, $headers = []);

// コントローラを使用せずにリダイレクトするルートを定義する方法
Route::redirect($uri, $destination, $status = 301);


```


## 文字列変換
http://tech.innovation.co.jp/2018/06/24/Laravel56-Request.html
```php
$test = 'onaka suita nanika tabetai';

【 snake_case関数 】
// 文字列をスネークケース（小文字名下線区切り）に変換
snake_case($test);　→（onaka_suita_nanika_tabetai）

【 camel_case関数 】
// 文字列をキャメルケース（２つ目以降の単語の先頭は大文字）へ変換
camel_case($test);　→（onakaSuitaNanikaTabetai）

【 studly_case関数 】
// 文字列をアッパーキャメルケース（単語の頭文字を大文字）に変換
studly_case($test);　→（OnakaSuitaNanikaTabetai）

【 title_case関数 】
// 指定された文字列をタイトルケースへ変換
title_case($test);　→（Onaka Suita Nanika Tabetai）

【 kebab_case関数 】
// 指定した文字列をケバブケースに変換
kebab_case($test);　→（onaka-suita-nanika-tabetai）
```

____________________________________________________________________________________________
## 直前のデータを取得
https://readouble.com/laravel/5.5/ja/requests.html
直前のリクエストのフラッシュデータを取得するには、Requestインスタンスに対しoldメソッドを使用してください。oldメソッドはセッションにフラッシュデータとして保存されている入力を取り出すために役に立ちます。
```php
$username = $request->old('username');
```
php
```php
初期値
<input type="text"  id="remarks" name="remarks" value="{{ old('remarks' , $params['remarks'] ) }}">
```
It's a type of user data that you show once and then destroy. Usually a top alert like "Your action has been successful" or similar.  
By its nature it's dynamic, so it's saved in the user session and displayed in the very first rendered page, then discarded.  

これは、一度表示してから破棄するユーザーデータの一種です。通常、「あなたのアクションは成功しました」などのトップアラートです。  
その性質上、動的であるため、ユーザーセッションに保存され、最初にレンダリングされたページに表示され、その後破棄されます。  


____________________________________________________________________________________________
## セッション
```php
// セッション
$request->session()->all();


// old
$request->session()->flash('_old_input', ['key' => 'value']);
```

____________________________________________________________________________________________
## クッキー
```php
$value = $request->cookie('name');
```

____________________________________________________________________________________________




