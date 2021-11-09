【Laravel】response()->json ：日本語の文字化けを解消する

Laravel にて、以下のように記述すると、json 形式でデータを返す事が出来ます。  
```php
    return response()->json(
        [
            'data1' => 'English message',
            'data2' => '日本語のメッセージ'
        ],
    );
```

ところが、日本語を扱う場合、以下のように文字化けが発生する。（日本語が unicode エスケープされているのが原因らしい）
```php
{
  "data1": "English message",
  "data2": "\u65e5\u672c\u8a9e\u306e\u30e1\u30c3\u30bb\u30fc\u30b8"
}
```

対策として、「JSON\_UNESCAPED\_UNICODE」のオプションを追加する。
```php
    return response()->json(
        [
            'data1' => 'English message',
            'data2' => '日本語のメッセージ'
        ],
        200,[],
        JSON_UNESCAPED_UNICODE
    );
```

すると、以下のように日本語が正常に表示されるようになる。
```php
{
  "data1": "English message",
  "data2": "日本語のメッセージ"
}
```

## response()->json の残りの引数は？
第一引数がデータで、第二引数が HTTP ステータス、ってのは推測出来るんだけど、それ以降には何が？  

公式ドキュメントにはロクな情報が無かったので、Laravel のソースを読んでみました。  

どうやら、以下のようになっているらしいです。  

 * 第１引数：データ
 * 第２引数：ステータス
 * 第３引数：ヘッダ
 * 第４引数：オプション

### framework\src\Illuminate\Contracts\Routing\ResponseFactory.php
```php
    /**
     * Create a new JSON response instance.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0);
```

第３引数には HTTP ヘッダを渡す事が可。  

という事で、こんな感じで HTTP ヘッダを好きに編集できます。  
場合によっては、ミドルウェアを入れて制御するよりもお手軽かつ柔軟に対応できそう。  

### ソース例
```php
    return response()->json(
        [
            'data1' => 'English message',
            'data2' => '日本語のメッセージ'
        ],
        Response::HTTP_OK,
        [
            'Cache-Control' => 'no-cache, no-store',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'Content-Type' => 'application/json;charset=UTF-8',
            'Charset' => 'utf-8'
        ],
        JSON_UNESCAPED_UNICODE
    );
```

### レスポンス例
```
HTTP/1.1 200 OK
Server: nginx
Content-Type: application/json;charset=UTF-8
Transfer-Encoding: chunked
Connection: close
X-Powered-By: PHP/7.4.24
Cache-Control: no-cache, no-store, private
Pragma: no-cache
Expires: 0
Charset: utf-8
Date: Mon, 08 Nov 2021 00:28:56 GMT
Content-Encoding: gzip

{
  "data1": "English message",
  "data2": "日本語のメッセージ"
}
```


