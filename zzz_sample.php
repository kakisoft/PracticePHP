<?php


//----------( 書き込み可能かをチェック )----------
if (is_writeable('data/taro.txt') === true) {
    echo 'taro is writable!' . PHP_EOL;
  }
  
  //----------(  )----------
  if (is_readable('data/taro.txt') === true) {
    echo 'taro is readable!' . PHP_EOL;
  }
  