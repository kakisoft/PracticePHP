<?php

require_once(__DIR__ . '/config.php');

// package
// - Composer

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(
  API_KEY,
  API_SECRET_KEY,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET);

//==========< ユーザ情報を出力 >==========
$content = $connection->get("account/verify_credentials");
var_dump($content);


//==========< ツイート情報を取得 >==========
$content = $connection->get("statuses/home_timeline", ['count'=>3]);
var_dump($content);


//==========< ツイート >==========
$res = $connection->post("statuses/update", [
  'status' => 'botからのツイート。 https://kakistamp.hatenadiary.jp/  #dotinstall'
]);

if ($connection->getLastHttpCode() === 200) {
  echo 'Success!' . PHP_EOL;
} else {
  echo 'Error!' . $res->errors[0]->message . PHP_EOL;
}


//==========< 画像付きでツイート >==========
$media = $connection->upload("media/upload", [
  'media' => __DIR__ . '/asset/kakisoft01.png'
]);

$res = $connection->post("statuses/update", [
  'status' => date('m月d日') . '　GitPitchの使い方　～応用編～ https://kakistamp.hatenadiary.jp/entry/2018/09/13/003657',
  'media_ids' => $media->media_id
]);


//==========< ツイート >==========
$res = $connection->post("statuses/update", [
  'status' => 'cron をトリガーに投稿4。'
]);

