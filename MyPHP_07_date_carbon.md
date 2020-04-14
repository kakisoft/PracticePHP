# Carbon
https://carbon.nesbot.com/

## インストール
```
composer require nesbot/carbon
```

____________________________________________________________________________________________________

<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = new Carbon();
echo $dt . PHP_EOL;















<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

// $dt = new Carbon();
// $dt = Carbon::now();

// $dt = new Carbon('2015-12-20 11:32:32');
// $dt = new Carbon('tomorrow');

// $dt = Carbon::today();
// $dt = Carbon::tomorrow();
// $dt = Carbon::yesterday();

// $dt = Carbon::parse('2015-12-20 11:32:32');
// $dt = Carbon::create(2020, 12, 20, 11, 34, 33);

$dt = Carbon::createFromFormat('Y/m/d H', '2015/12/20 20');
echo $dt . PHP_EOL;

















<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::now();
// echo $dt->year . PHP_EOL;
// echo $dt->month . PHP_EOL;
// echo $dt->day . PHP_EOL;
// echo $dt->hour . PHP_EOL;
// echo $dt->minute . PHP_EOL;
// echo $dt->second . PHP_EOL;
// echo $dt->dayOfWeek . PHP_EOL;
// echo $dt->dayOfYear . PHP_EOL;
// echo $dt->weekOfMonth . PHP_EOL;
// echo $dt->weekOfYear . PHP_EOL;
// echo $dt->timestamp . PHP_EOL;
// echo $dt->tzName . PHP_EOL;
echo $dt->format('Y年m月d日') . PHP_EOL;











<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::now();
// var_dump($dt->isToday()) . PHP_EOL;
// var_dump($dt->isTomorrow()) . PHP_EOL;
// var_dump($dt->isYesterday()) . PHP_EOL;
// var_dump($dt->isFuture()) . PHP_EOL;
// var_dump($dt->isPast()) . PHP_EOL;
// var_dump($dt->isLeapYear()) . PHP_EOL;
// var_dump($dt->isWeekday()) . PHP_EOL;
// var_dump($dt->isWeekend()) . PHP_EOL;
var_dump($dt->isSameDay(Carbon::now())) . PHP_EOL;















<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt1 = Carbon::create(2020, 10, 1);
$dt2 = Carbon::create(2020, 11, 1);

// eq
// gt, gte
// lt, lte

// var_dump($dt1->eq($dt2)) . PHP_EOL;
// var_dump($dt1->gt($dt2)) . PHP_EOL;
// var_dump($dt1->lt($dt2)) . PHP_EOL;

// between

// var_dump(Carbon::create(2020, 10, 10)->between($dt1, $dt2)) . PHP_EOL;
// var_dump(Carbon::create(2022, 10, 10)->between($dt1, $dt2)) . PHP_EOL;

// max, min

echo $dt1->max($dt2) . PHP_EOL;
echo $dt1->min($dt2) . PHP_EOL;














<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::now();
// echo $dt->addYear() . PHP_EOL;
// echo $dt->addYears(3) . PHP_EOL;
// echo $dt->subYear() . PHP_EOL;
// echo $dt->subYears(3) . PHP_EOL;

// add, sub
// Years(n)
// Year, Month, Day, Hour, Minute, Second
// Weekday

// echo $dt->addWeekdays(3) . PHP_EOL;
echo $dt->addWeekdays(3)->addHours(3)->addMinutes(20) . PHP_EOL;












<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

// copy

$dt = Carbon::now();
// echo $dt->addYear() . PHP_EOL;
echo $dt->copy()->addYear() . PHP_EOL;
echo $dt . PHP_EOL;














<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::now();
// echo $dt->startOfDay() . PHP_EOL;
// echo $dt->endOfDay() . PHP_EOL;
// echo $dt->startOfMonth() . PHP_EOL;
// echo $dt->endOfMonth() . PHP_EOL;
// echo $dt->startOfWeek() . PHP_EOL;
// echo $dt->endOfWeek() . PHP_EOL;

// echo $dt->next(Carbon::MONDAY) . PHP_EOL;
// echo $dt->previous(Carbon::MONDAY) . PHP_EOL;

echo $dt->firstOfMonth(Carbon::MONDAY) . PHP_EOL;
echo $dt->lastOfMonth(Carbon::MONDAY) . PHP_EOL;
echo $dt->nthOfMonth(3, Carbon::MONDAY) . PHP_EOL;











<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$dt1 = Carbon::create(2020, 10, 1);
$dt2 = Carbon::create(2020, 11, 1);

// echo $dt1->diffInDays($dt2) . PHP_EOL;
// echo $dt1->diffInHours($dt2) . PHP_EOL;
// echo $dt1->diffInMinutes($dt2) . PHP_EOL;

Carbon::setLocale('ja');
echo $dt1->diffForHumans($dt2) . PHP_EOL;









<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

$birthday = Carbon::create(1990, 10, 1);

Carbon::setTestNow(Carbon::create(2020, 10, 1));
echo Carbon::now() . PHP_EOL;
Carbon::setTestNow();
echo Carbon::now() . PHP_EOL;

if ($birthday->isBirthday(Carbon::now())) {
  echo ':)' . PHP_EOL;
} else {
  echo ':<' . PHP_EOL;
}









