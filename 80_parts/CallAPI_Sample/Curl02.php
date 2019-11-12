<?php

// $url = 'http://...?name=Tom'; // リクエストするURLとパラメータ
$url = 'http://challenge-your-limits.herokuapp.com/challenge_users'; 

// 渡したいパラメータ
$params = [
    'name' => 'Tom',
    'email' => 'tomtom3@gmail.com',
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // パラメータをセット
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

//
echo($response);

curl_close($curl);

