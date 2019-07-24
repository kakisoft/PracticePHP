<?php
//=============================
//        日付の差分
//=============================
$time = '2001/7/24';

echo date_create($time)->diff(date_create())->format('%y');
echo date_create($time)->diff(date_create())->format('%y歳 %mヶ月 %d日 %h時間 %i分 %s秒');
