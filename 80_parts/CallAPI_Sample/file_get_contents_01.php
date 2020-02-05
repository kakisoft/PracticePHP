<?php

$target_url = "http://challenge-your-limits.herokuapp.com/call/me";

// curl http://challenge-your-limits.herokuapp.com/call/me


//====================================
//   file_get_contents ( HTTP GET )
//====================================
$res_01 = file_get_contents($target_url);

var_dump($res_01);  //=>  "{"message":"Almost! It's not GET. Keep trying."}"


//====================================
//   file_get_contents ( HTTP POST )
//====================================
$res_02 = connectByPost($target_url, array() );

var_dump($res_02);  //=>  "{"message":"Great! Please register as /challenge_users"}"


function connectByPost($url, $params) {
    //$url = "http://localhost/example.php";
    //$params = array('Apple','Banana','love' => 'Orange');

    // URLエンコードされたクエリ文字列を生成する
    $query_string = http_build_query($params);

    // HTTP設定
    $options = array (
                        'http' => array (
                                            'method' => 'POST',
                                            'header' => 'Content-type: application/x-www-form-urlencoded',
                                            'content' => $query_string,
                                            'ignore_errors' => true,
                                            'protocol_version' => '1.1'
                        ),
                        'ssl' => array (
                                            'verify_peer' => false,
                                            'verify_peer_name' => false
                        )
                    );
    $contents = file_get_contents($url, false, stream_context_create($options));

    // レスポンスステータス
    // $statusCode = http_response_code();

    return $contents;
}


