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

// redirect関数で取得したリダイレクタインスタンスに外部ドメインを指定する方法
return redirect()->away($path, $status = 302, $headers = []);

// コントローラを使用せずにリダイレクトするルートを定義する方法
Route::redirect($uri, $destination, $status = 301);


```


## app/Http/Controllers/TestController.php
http://tech.innovation.co.jp/2018/06/24/Laravel56-Request.html
#### http
```php
public function test(Request $request)
{
    dd(
        // リクエストURIの取得
        $request->path(),
        // リクエストのURIが指定されたパターンに合致するか確認
        $request->is('*/sumo'),
        // 完全なURLを取得(クエリ文字列なし)
        $request->url(),
        // 完全なURLを取得(クエリ文字列付き)
        $request->fullUrl(),
        // リクエストメソッドの取得
        $request->method(),
        // リクエストメソッドの取得
        $request->isMethod('post')
    );
    return view('test.index');
}
```

#### params

```php
public function testRegist(Request $request)
{
    dd(
        // 名前の取得
        $request->input('name'),
        // リクエストにnameが存在していない場合に、デフォルト値で指定したsumoを返す
        $request->input('name', 'sumo'),
        // リクエストの全入力データを配列で取得
        $request->all(),
        // リクエストからmailの入力データだけ取得
        $request->only('mail'),
        // リクエストからpassword以外の入力データを取得
        $request->except('password'),
        // リクエストにnameが存在するか判定
        $request->has('name'),
        // リクエストにnameが存在しており、かつ空でない事を判定
        $request->filled('name')
    );
    return view('test.index');
}
```


#### 文字列変換
```php
【snake_case関数】
// 文字列をスネークケース（小文字名下線区切り）に変換
snake_case($test);　→（onaka_suita_nanika_tabetai）

【camel_case関数】
// 文字列をキャメルケース（２つ目以降の単語の先頭は大文字）へ変換
camel_case($test);　→（onakaSuitaNanikaTabetai）

【studly_case関数】
// 文字列をアッパーキャメルケース（単語の頭文字を大文字）に変換
studly_case($test);　→（OnakaSuitaNanikaTabetai）

【title_case関数】
// 指定された文字列をタイトルケースへ変換
title_case($test);　→（Onaka Suita Nanika Tabetai）

【kebab_case関数】
// 指定した文字列をケバブケースに変換
kebab_case($test);　→（onaka-suita-nanika-tabetai）
```

____________________________________________________________

https://www.larajapan.com/2018/06/02/%E3%83%AA%E3%82%AF%E3%82%A8%E3%82%B9%E3%83%88%EF%BC%88request%EF%BC%89%E3%81%AE%E3%81%82%E3%82%8C%E3%81%93%E3%82%8C/  

```php
// 'name'の値を取り出す
$name = $request->get('name');
 
// これも、'name'の値を取り出す
$name = $request->input('name');
 
// これも、'name'の値を取り出す
$name = $request->name;
 
// これはヘルパー
$name = request('name');

```

