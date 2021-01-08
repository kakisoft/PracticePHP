<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜コマンドライン＞

php empty02.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

if(strlen("") <= 0){
  echo ' "" is true.' . PHP_EOL;  #=>
}else{
  echo ' "" is false.' . PHP_EOL;
}

if(strlen(0) <= 0){
  echo ' 0 is true.' . PHP_EOL;
}else{
  echo ' 0 is false.' . PHP_EOL;  #=>
}

if(strlen(0.0) <= 0){
  echo ' 0.0 is true.' . PHP_EOL;
}else{
  echo ' 0.0 is false.' . PHP_EOL;  #=>
}

if(strlen("0") <= 0){
  echo ' "0" is true.' . PHP_EOL;
}else{
  echo ' "0" is false.' . PHP_EOL;  #=>
}

if(strlen(NULL) <= 0){
  echo ' NULL is true.' . PHP_EOL;  #=>
}else{
  echo ' NULL is false.' . PHP_EOL;;
}

if(strlen(FALSE) <= 0){
  echo ' FALSE is true.' . PHP_EOL;  #=>
}else{
  echo ' FALSE is false.' . PHP_EOL;;
}

////エラー
// if(strlen(array()) <= 0){
//   echo ' array() is true.' . PHP_EOL;
// }else{
//   echo ' array() is false.' . PHP_EOL;;
// }

if(strlen("a") <= 0){
  echo ' "a" is true.' . PHP_EOL;
}else{
  echo ' "a" is false.' . PHP_EOL;  #=>s
}

