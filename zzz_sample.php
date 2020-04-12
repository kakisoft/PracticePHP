<?php

//----------------------------------------------
//  DBから取得した値の形式をソート（複数条件でソート）
//----------------------------------------------
// array_multisort — 複数または多次元の配列をソートする

$data = [
    ['name' => 'taguchi', 'score' => 80],
    ['name' => 'kikuchi', 'score' => 60],
    ['name' => 'hayashi', 'score' => 70],
    ['name' => 'tamachi', 'score' => 60],
  ];

$scores = array_column($data, 'score');
$names = array_column($data, 'name');

// array_multisort(
//   $scores,
//   $names,
//   $data
// );

array_multisort(
    $scores, SORT_DESC, SORT_NUMERIC,
    $names, SORT_DESC, SORT_STRING,
    $data
);

print_r($data);
// Array
// (
//     [0] => ([name] => taguchi , [score] => 80)
//     [0] => ([name] => hayashi , [score] => 70)
//     [0] => ([name] => tamachi , [score] => 60)
//     [0] => ([name] => kikuchi , [score] => 60)
// )


