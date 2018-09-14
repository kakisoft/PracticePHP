<?php

require_once(__DIR__ . '/config.php');

// package
// - Composer

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(
  CONSUMER_KEY,
  CONSUMER_SECRET,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET);
$content = $connection->get("account/verify_credentials");

var_dump($content);