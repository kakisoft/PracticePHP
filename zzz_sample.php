<?php


$fp = fopen('names.txt', 'r');
while (($line = fgets($fp)) !== false) {
  echo $line;
}
fclose($fp);