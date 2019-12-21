## Requestクラス
ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクト。  

```php
class UserController extends Controller
{
    /**
    * 新しいユーザーを保存
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $name = $request->input('name');

        //
    }
}
```

_________________________________________________________________
## Request クラス作成
```
php artisan make:request PostRequest

app/Http/Requests/PostRequest.php
```

_________________________________________________________________
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

        //// すべてのクエリストリングを取得
        $query = $request->query();
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

____________________________________________________________







