<?php

require_once(__DIR__ . '/config.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(
  API_KEY,
  API_SECRET_KEY,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET);

//==========< ユーザ情報を出力 >==========
// $content = $connection->get("account/verify_credentials");
// var_dump($content);


$statuses = $connection->get("lists/list");

var_dump($statuses);



