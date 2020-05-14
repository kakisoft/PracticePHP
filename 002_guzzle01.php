<?php

require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;


/*

https://challenge-your-limits.herokuapp.com/

*/


$TARGET_URL_01 = "https://challenge-your-limits.herokuapp.com/call/me";
$TARGET_URL_02 = "http://localhost:8000/api/aaa/1";
$TARGET_URL_03 = "http://localhost:8000/aaa/1";


$TARGET_URL_04 = "http://localhost:8000/api/call/me";
$TARGET_URL_05 = "http://localhost:8000/api/challenge_usersGet";


//------------------------------
//
//------------------------------
$TARGET_URL  = $TARGET_URL_04;
$HTTP_METHOD = "GET";



//===============================================
//        オプション・パラメータを設定
//===============================================
$options = [
    'form_params' => [
        'name'  => 'sample01',
        'email' => 'aaab',
    ]
];


//===============================================
//               リクエスト送信
//===============================================
$client = new Client();
$response = $client->request($HTTP_METHOD, $TARGET_URL, $options);



//===============================================
//            レスポンスボディの取得
//===============================================
echo $response->getBody()->getContents();




