<?php

// array_splice — 配列の一部を削除し、他の要素で置換する
$scores_1 = [30, 40, 50, 60, 70, 80];
$scores_2 = [30, 40, 50, 60, 70, 80];
$scores_3 = [30, 40, 50, 60, 70, 80];

array_splice($scores_1, 2, 3);              //=> Array( 30, 40, 80)
array_splice($scores_2, 2, 3, 100);         //=> Array( 30, 40, 100, 80)
array_splice($scores_3, 2, 0, [100, 101]);  //=> Array( 30, 40, 100, 101, 50, 60, 70, 80)

print_r($scores_3);

