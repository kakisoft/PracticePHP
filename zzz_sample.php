<?php


// // ファイルの内容を配列に取り込みます。
// $file = file(__FILE__);

// // 行単位で出力
// foreach ($file as $lines => $line) {
//     echo "Line #{$line_num} : " . htmlspecialchars($line);
// }

// // ファイルを開く（戻り値は、FilePointer と呼ばれる特殊な変数）
// $handle = fopen(__FILE__, "r");  // readonly

// // ファイル内容を出力
// while ($line = fgets($handle)) {
//   echo $line;
// }
// // ファイルポインタをクローズ
// fclose($handle);


// ファイルをオープンして既存のコンテンツを取得します

$current = file_get_contents(__FILE__);

print_r($current);

