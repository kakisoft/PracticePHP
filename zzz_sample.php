<?php



declare(strict_types=1);

// 引数、戻り値に null を許容する
function getAward(?int $score): ?string
{
  return $score >= 100 ? 'Gold Medal' : null;
}

echo getAward(150) . PHP_EOL;
echo getAward(40) . PHP_EOL;


