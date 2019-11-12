<?php
//よくわかんないけど、パラメータを渡すとエラーになった。「"ignore_errors" => true,」で回避（？）できた。

$context = stream_context_create(
    array(
        'http' => array(
            // "ignore_errors" => true,
            'method'=> 'POST',
            'header'=> 'Content-type: application/json; charset=UTF-8',
            'content' => json_encode(
                array(
                    'title' => 'file_get_contents で POST',
                    'raw' => "file_get_contents で POST\nPHP すごい...\n"
                )
            )
        )
    )
);

$content = file_get_contents('http://challenge-your-limits.herokuapp.com/call/me', false, $context);

var_dump($content);
