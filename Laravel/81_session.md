# session

## コンフィグ

#### config/session.php
```
    'driver' => env('SESSION_DRIVER', 'file'),
```

* file - sessions are stored in storage/framework/sessions.
* cookie - sessions are stored in secure, encrypted cookies.
* database - sessions are stored in a database used by your application.
* memcached / redis - sessions are stored in one of these fast, cache based stores.
* array - sessions are stored in a simple PHP array and will not be persisted across requests.


## 参考サイト
https://qiita.com/reflet/items/5638ab18fd7cededed17

https://readouble.com/laravel/5.4/ja/session.html  
https://readouble.com/laravel/5.4/ja/helpers.html#method-session  
https://readouble.com/laravel/5.4/ja/facades.html  
https://stackoverflow.com/questions/16812747/how-can-i-get-the-session-id-in-laravel  



## セッションIDを取得
```php
Session::getId() 
```

## HTTPリクエストインスタンスを経由する
```php
    public function index(Request $request)
    {
        // セッションIDの再発行
        $request->session()->regenerate();

        // セッションの値を全て取得
        $data = $request->session()->all();

        // IDを取得
        $id   = $request->session()->get('id');

        // 名前を取得 (クロージャー利用)
        $name = $request->session()->get('username', function () {
            return '名無し';
        });

        // ユーザー情報を取得
        $users = $request->session()->get('users', array());

        // ユーザー情報を保存する
        $request->session()->put('users', null);

        // ユーザー情報の情報が存在する(!= null)かチェック
        $is_users = $request->session()->has('users');

        // ユーザー情報がセット(nullでもOK)されているかチェック
        $exists   = $request->session()->exists('users');

        // 削除 (指定の値を個別に)
        $request->session()->forget('key');

        // 削除 (全データ)
        $request->session()->flush();
    }
```


## グローバルSessionヘルパ関
```php
    public function index()
    {
        // セッションIDの再発行
        session()->regenerate();

        // セッションの値を全て取得
        $data = session()->all();

        // セッションから一つのデータを取得する
        $id = session('id');

        // デフォルト値を指定する場合
        $name = session('username', '名無し');

        // セッションへ一つのデータを保存する
        session(['users' => null]);

        // ユーザー情報の情報が存在する(!= null)かチェック
        $is_users = session()->has('users');

        // ユーザー情報がセット(nullでもOK)されているかチェック
        $exists   = session()->exists('users');

        // 削除 (指定の値を個別に)
        session()->forget('key');

        // セッションをクリア＆セッションIDを再発行(Illuminate\Session\Store::invalidate)
        session()->invalidate();

        // セッションIDを再発行(Illuminate\Session\Store::migrate)
        $this->session->migrate(true);

        // 削除 (全データ)
        session()->flush();
    }
```

## ファサード
```php
    public function index()
    {
        // セッションIDの再発行
        Session::regenerate();

        // セッションの値を全て取得
        $data = Session::all();

        // IDを取得する
        $id = Session::get('id');

        // 名前を取得 (クロージャー利用)
        $name = Session::get('username', function () {
            return '名無し';
        });

        // ユーザー情報を取得
        $users = Session::get('users', array());

        // ユーザー情報を保存する
        Session::put('users', null);

        // ユーザー情報の情報が存在する(!= null)かチェック
        $is_users = Session::has('users');

        // ユーザー情報がセット(nullでもOK)されているかチェック
        $exists   = Session::exists('users');

        // 削除 (指定の値を個別に)
        Session::forget('key');

        // 削除 (全データ)
        Session::flush();
    }
```

