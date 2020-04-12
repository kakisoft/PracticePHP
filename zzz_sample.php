<?php

srand((float) microtime() * 10000000);
$input = array("ネオ", "モーフィアス", "トリニティ", "サイファー", "タンク");
$rand_keys = array_rand($input, 2);
echo $input[$rand_keys[0]] . "\n";
echo $input[$rand_keys[1]] . "\n";

