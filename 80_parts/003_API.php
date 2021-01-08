<?php

require_once 'kakisoft_utils/file_get_contents_util.php';
use kakisoft_utils_02 as Lib;


$target_url = 'http://challenge-your-limits.herokuapp.com/call/me';

//=====================================================
//                 file_get_contents
//=====================================================
$client  = new Lib\MyFileGetContentsUtil();

// GET
$response_01 = $client->request('GET', $target_url);
print_r($response_01);
var_dump($client->getStatusCode());

// POST
$response_02 = $client->request('POST', $target_url);
print_r( json_decode($response_02, true) );
var_dump($client->getStatusCode());

// POST (+ param)
$target_url2 = 'http://challenge-your-limits.herokuapp.com/challenge_users';
$params = [];
$params['name']  = 'sample01';
$params['email'] = 'sample01@gmail.com';
$response_03 = $client->request('POST', $target_url2, $params);
print_r( json_decode($response_03, true) );
var_dump($client->getStatusCode());



