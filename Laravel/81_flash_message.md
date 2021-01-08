# フラッシュメッセージ

## 送信側 ： コントローラ
```php
    // flashメソッドを使うパターン
    session()->flash('flash_message', 'flash_message_01');
    return redirect()->action('Question01Controller@index');


    // Sessionクラスのflashメソッド（静的メソッド）を使うパターン
    \Session::flash('flash_message', 'flash_message_02');
    return redirect()->action('Question01Controller@index');


    // with メソッドを使うパターン
    // （通常のパラメータと混同しないのか・・・？）
    return redirect()->action('Question01Controller@index')->with('flash_message', 'flash_message_03');


    // NGパターン（実現できないわけではないが、格好悪い）
    //     URL にパラメータが出てくる。超イケてない。Withと挙動が同じというわけではないのか。。
    return redirect()->action(
        'Question01Controller@index', ['flash_message' => 'flash_message_04']
    );
```

Request に含めるパターンもあるの？
```php
    $request->session()->flash('message', '登録した');
    return redirect('index');
```

## 受信側 ： コントローラ
```php
//==========< Requestから取得するパターン >==========
$all_request_data = $request->session()->all();

$flash_message = $request->session()->get('flash_message');


//==========< session（Staticメソッド？）から取得するパターン >==========
$all_request_data = session()->all();

$flash_message = session()->get('flash_message');

```


## 受信側 ： View
```php
{{ session('special_message') }}
```






