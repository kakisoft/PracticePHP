<?php


//==================================
//          関数(可変長引数)
//==================================
// https://www.php.net/manual/ja/migration56.new-features.php
function sum(...$numbers)
{
  $total = 0;
  foreach ($numbers as $number) {
    $total += $number;
  }
  return $total;
}

echo sum(1, 3, 5)    . PHP_EOL;  //=> 9
echo sum(4, 2, 5, 1) . PHP_EOL;  //=> 12





