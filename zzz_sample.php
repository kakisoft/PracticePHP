<?php

$a = [3, 4, 8];
$b = [4, 8, 12];

$merged = array_merge($a, $b);
$merged = [...$a, ...$b];
print_r($merged);

