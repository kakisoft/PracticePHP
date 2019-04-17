<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜コマンドライン＞

php empty01.php

【 PHPマニュアル 】
https://www.php.net/manual/ja/function.empty.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

if(empty("")){
  echo ' "" is true.' . PHP_EOL;  #=>
}else{
  echo ' "" is false.' . PHP_EOL;
}

if(empty(0)){
  echo ' 0 is true.' . PHP_EOL;  #=>
}else{
  echo ' 0 is false.' . PHP_EOL;
}

if(empty(0.0)){
  echo ' 0.0 is true.' . PHP_EOL;  #=>
}else{
  echo ' 0.0 is false.' . PHP_EOL;
}

if(empty("0")){
  echo ' "0" is true.' . PHP_EOL;  #=>
}else{
  echo ' "0" is false.' . PHP_EOL;
}

if(empty(NULL)){
  echo ' NULL is true.' . PHP_EOL;  #=>
}else{
  echo ' NULL is false.' . PHP_EOL;
}

if(empty(FALSE)){
  echo ' FALSE is true.' . PHP_EOL;  #=>
}else{
  echo ' FALSE is false.' . PHP_EOL;
}

if(empty(array())){
  echo ' array() is true.' . PHP_EOL;  #=>
}else{
  echo ' array() is false.' . PHP_EOL;
}

if(empty("a")){
  echo ' "a" is true.' . PHP_EOL;
}else{
  echo ' "a" is false.' . PHP_EOL;  #=>
}

