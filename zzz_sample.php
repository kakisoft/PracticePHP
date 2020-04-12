<?php




// usort — ユーザー定義の比較関数を使用して、配列を値でソートする
$data = [
  ['name' => 'taguchi', 'score' => 80],
  ['name' => 'kikuchi', 'score' => 60],
  ['name' => 'hayashi', 'score' => 70],
  ['name' => 'tamachi', 'score' => 60],
];

usort(
  $data,
  function ($a, $b) {
    if ($a['score'] === $b['score']) {
      return 0;
    }
    return $a['score'] > $b['score'] ? 1 : -1;  // $a['score'] が $b['score'] より大きいという並び替えをしたかったら 1 、そうで無い場合 -1 を返す。
  }
);

print_r($data);
// Array
// (
//     [0] => ([name] => kikuchi , [score] => 60)
//     [0] => ([name] => tamachi , [score] => 60)
//     [0] => ([name] => hayashi , [score] => 70)
//     [0] => ([name] => taguchi , [score] => 80)
// )


