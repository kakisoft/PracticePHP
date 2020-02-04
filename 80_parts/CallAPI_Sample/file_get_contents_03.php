<?php

// $base_url = 'https://qiita.com';

// $tag = 'PHP';
// $query = ['page'=>'1','per_page'=>'5'];

// $response = file_get_contents(
//                   $base_url.'/api/v2/tags/'.$tag.'/items?' .
//                   http_build_query($query)
//             );
// // https://qiita.com/api/v2/tags/PHP/items?page=1&per_page=5

// // 結果はjson形式で返されるので
// $result = json_decode($response,true);

//=================================================================

$base_url = 'http://challenge-your-limits.herokuapp.com/challenge_users'; 

$tag = 'PHP';
$query = ['page'=>'1','per_page'=>'5'];

$response = file_get_contents(
                  $base_url
            );

// 結果はjson形式で返されるので
$result = json_decode($response,true);

var_dump($result);
