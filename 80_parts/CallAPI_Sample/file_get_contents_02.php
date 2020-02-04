<?php


function connectByPost($url, $argary) {
    //$url = "http://localhost/example.php";
    //$argary = array('Apple','Banana','love' => 'Orange');

    // URLエンコードされたクエリ文字列を生成する
    $query_string = http_build_query($argary);

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
    $contents = @file_get_contents($url, false, stream_context_create($options));

    // レスポンスステータス
    $statusCode = http_response_code();
    if($statusCode === 200) {
       // 200 success
    } elseif(preg_match ("/^4\d\d/", $statusCode)) {
       // 4xx Client Error
       $contents = false;
    } elseif(preg_match ('/^5\d\d/', $statusCode)) {
       // 5xx Server Error
       $contents = false;
    } else {
       $contents = false;
    }

    return $content;
   }