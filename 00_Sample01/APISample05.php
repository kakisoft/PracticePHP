<?php

$url = "http://challenge-your-limits.herokuapp.com/challenge_users";

//$posted ：渡すパラメータ（Array）
$posted = ["name" => "Tom"];

        $post = http_build_query($posted, "", "&");

        $header = array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Content-Length: ' . strlen($post)
                );
 
        $context = array(
                    'http' => array(
                            'method' => 'POST',
                            'header' => implode("\r\n", $header),
                            'content' => $post
                        ),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                );
 

        $data = file_get_contents($url, false, stream_context_create($context));


//$http_response_header

//file_get_contents を実行すると、HTTPヘッダ情報が色々詰め込まれる。
var_dump($http_response_header);

var_dump(json_decode($data));


