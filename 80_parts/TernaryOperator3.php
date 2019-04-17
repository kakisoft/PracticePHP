<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 三項演算子 】

＜コマンドライン＞

php operator3.php
PHP7～


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

//エルビス演算子
echo $param1 ?: '存在しない';
echo PHP_EOL;

//NULL合体演算子
echo $param1 ?? '存在しない';
echo PHP_EOL;

// param2
$param2 = "yes";
echo $param2 ?: '存在しない';
echo PHP_EOL;
echo $param2 ?? '存在しない';
