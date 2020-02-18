<?php

require_once 'kakisoft_utils\static_file_get_contents_util.php';
use kakisoft_utils_01 as Lib;


$target_url = "http://qiita.com/api/v2/items?page=1&per_page=2";


//=====================================================
//   file_get_contents ( HTTP POST : パラメータ含む )
//=====================================================
$params = [];
$d = Lib\MyStaticFileGetContentsUtil::requestByPost($target_url);
$e = Lib\MyStaticFileGetContentsUtil::getResponseHttpStatusCode();

print_r(json_decode($d, true));


