<?php
/*
【 Guzzle, PHP HTTP client 】

https://github.com/guzzle/guzzle


＜install＞
composer require guzzlehttp/guzzle


＜その他参考資料＞
https://re-engines.com/2019/05/20/laravel%E3%81%A7http%E9%80%9A%E4%BF%A1/    

*/

//--------------------
//
//--------------------
require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;


//===============================================
//               basic style
//===============================================
// インスタンス作成
// $client = new Client();  // 「 use GuzzleHttp\Client; 」を宣言してる場合、こっちでも可。
$client = new \GuzzleHttp\Client();
$response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

echo $response->getStatusCode();                    // 200
echo $response->getHeaderLine('content-type');      // 'application/json; charset=utf8'
$body = $response->getBody();
print_r(json_decode($body, true) );                 // '{"id": 1420053, "name": "guzzle", ...}'

// こんな方法も。
$contents = $response->getBody()->getContents();
print_r(json_decode($contents, true) );             // '{"id": 1420053, "name": "guzzle", ...}'




//===============================================
//         Send an asynchronous request
//===============================================
// $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
// $promise = $client->sendAsync($request)->then(function ($response) {
//     echo 'I completed! ' . $response->getBody();
// });

// $promise->wait();


//===============================================
//                    POST
//===============================================
$client = new Client();

$options = [
    // Basic認証
    'auth' => ['user', 'password'],

    // SSL証明書を検証しない
    'verify' => false,

    // タイムアウト
    'connect_timeout' => 0.5, // コネクション時のタイムアウト
    'timeout' => 3.5,         // リクエストのタイムアウト

    // リクエストヘッダー
    'headers' => [
        // ユーザーエージェント
        'user-agent' => 'technoledge/1.0',
        // リファラー
        'referer' => 'https://www.mfro.net',
    ],

    // POSTデータは"form_params"に記載
    'form_params' => [
        'name'  => 'sample01',
        'email' => 'tak-solder',
        'job'   => 'engineer',
        'language' => [
            'php',
            'javascript'
        ]
    ]
];

// PHP Fatal error:  Uncaught GuzzleHttp\Exception\ClientException:
$response = $client->request('POST', 'http://challenge-your-limits.herokuapp.com/challenge_users', $options);


// レスポンスボディの取得
echo $response->getBody()->getContents();



//===============================================
//
//===============================================
// // リクエスト送信
// $response = $client->request('GET', 'https://yahoo.co.jp');
// // レスポンス本文の取得
// echo $response->getBody()->getContents();


