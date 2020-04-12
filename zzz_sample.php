<?php


$prices = [100, 200, 300];

$newPrices = array_map(
  // function ($n) { return $n * 1.1; },
  fn($n) => $n * 1.1,
  $prices
);

print_r($newPrices);



