<?php

require_once 'kakisoft_utils/MyStaticMiscUtil.php';
use kakisoft_utils_03 as MyUtil;

//------------------------------
//
//------------------------------
$t01 = ' 　全角Trim　 ';
$t02 = MyUtil\MyStaticMiscUtil::mb_trim($t01);

var_dump($t02);


//------------------------------
//
//------------------------------
$s01 = ' 　左右に空白は行ってたり		タブがあったり
改行があったり　 ';
$s02 = MyUtil\MyStaticMiscUtil::sharpen($s01);

var_dump($s02);




