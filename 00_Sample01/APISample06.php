<?php

$url = "http://challenge-your-limits.herokuapp.com/challenge_users";


$postdata = http_build_query(
    array(
        'var1' => 'value 1',
        'var2' => 'value 2'
    )
);
 
$opts = array('http' =>
    array(
        'protocol_version' => '1.1',        
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata,
        'ignore_errors' => true
    )
);
 
$context  = stream_context_create($opts);
 
$result = file_get_contents($url, false, $context);


var_dump($result);
