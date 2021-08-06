<?php

$format = 'Y-m-d H:i:s';
// $format = 'Y-m-d';

// 2021-08-06  05:54:28
$dateTime = "2021-08-06  06:26:55";
// $dateTime = "2021-08-06";


$d = DateTime::createFromFormat($format, $dateTime);

// var_dump($d);

// $d2 = DateTime::createFromFormat('Y-m-d', "2021-08-06");
$d2 = DateTime::createFromFormat('Y-m-d H:i:s', "2021
-08-06  06:26:55");
$d3 = DateTime::createFromFormat('YmdHis', "20210806062655");


// var_dump($d2);
var_dump($d3);


return $d && $d->format($format) == $dateTime;



