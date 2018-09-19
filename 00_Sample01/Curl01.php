https://qiita.com/tokutoku393/items/3c3ba3ca581bc0381e35
<?php

// $url = 'http://...?name=Tom'; // リクエストするURLとパラメータ
$url = 'http://challenge-your-limits.herokuapp.com/call/me';

// curlの処理を始める合図
$curl = curl_init($url);

// リクエストのオプションをセットしていく
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // メソッド指定
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る

// レスポンスを変数に入れる
$response = curl_exec($curl);

//
echo($response);

// curlの処理を終了
curl_close($curl);

