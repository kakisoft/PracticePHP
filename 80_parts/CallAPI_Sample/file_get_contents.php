<?php

$target_url = "http://challenge-your-limits.herokuapp.com/call/me";

// curl http://challenge-your-limits.herokuapp.com/call/me


//=====================================================
//   file_get_contents ( HTTP GET )
//=====================================================
$res_01 = file_get_contents($target_url);

var_dump($res_01);  //=>  "{"message":"Almost! It's not GET. Keep trying."}"


//=====================================================
//   file_get_contents ( HTTP POST )
//=====================================================
$res_02 = requestByPost($target_url, array() );
print_r( json_decode($res_02, true) );  //=>  "{"message":"Great! Please register as /challenge_users"}"

$response_status_code = getResponseHttpStatusCode($http_response_header);
print_r($response_status_code);   //=>  200


//=====================================================
//   file_get_contents ( HTTP POST : パラメータ含む )
//=====================================================
$target_url = "http://challenge-your-limits.herokuapp.com/challenge_users";
$params = [];
$params['name'] = 'unknown';
// $params['email'] = 'unknow@gmail.com';
$res_03 = requestByPost($target_url, $params);
print_r( json_decode($res_03, true) );


//--------------------------------------------------------------
//
//--------------------------------------------------------------
function requestByPost($target_url, $params) {
    // URLエンコードされたクエリ文字列を生成する
    $query_string = http_build_query($params);

    // HTTP設定
    $options = array (
                        'http' => array (
                                            'method' => 'POST',
                                            'timeout' => 3, // タイムアウト時間
                                            'header' => 'Content-type: application/x-www-form-urlencoded',
                                            'content' => $query_string,
                                            'ignore_errors' => true,    // false にすると、400/500 が返ってくるとエラーが発生する
                                            'protocol_version' => '1.1'
                                        ),
                        'ssl' => array (
                                        'verify_peer' => false,
                                        'verify_peer_name' => false
                                        )
                    );
    $getted_contents = file_get_contents($target_url, false, stream_context_create($options));


    return $getted_contents;
}


//--------------------------------------------------------------
//
//--------------------------------------------------------------
// Array( [0]=> HTTP/1.1 200 OK ) ・・・という感じのイケてない HTTPレスポンスステータスから、数値部分のみを抽出
function getResponseHttpStatusCode($http_response_header){
    // $http_response_header は、ローカルスコープで作成されるみたい。（そのため、引数として受け取っている）
    $response_status_status = $http_response_header[0];
    $separated_params = explode(' ', $response_status_status);
    $response_status_code = $separated_params[1];

    return $response_status_code;
}


//==========================================================================================

// // APIなどにfile_get_contents()を使うのはオススメしない理由と代替案
// https://qiita.com/shinkuFencer/items/d7546c8cbf3bbe86dab8


