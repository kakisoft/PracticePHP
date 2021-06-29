spliceIntoPosition

______________________________________________________________________
$this->spliceIntoPosition(

______________________________________________________________________
# 結論
内部的に cron の置換をしているだけなので、使用する意味はあまり無い。

______________________________________________________________________
## [cloudpack開発ブログ]Laravelのスケジューラの小ネタ
https://cloudpack.media/28450  

内部的にはexpressionプロパティーとして、cron形式の日時時間が保持されています。（時間部分５つ＋何に使用しているか不明１つ、たぶん実行ユーザーを指定するためのもの）cron指定の5つのフィールドをそれぞれ設定できる spliceIntoPositionメソッドが用意されていますが、ほとんどのメソッドで活用されていません。そのため、以下のようなことが起きます。



## Tips for Using Laravel’s Scheduler
https://laravel-news.com/tips-for-using-laravels-scheduler

```php
public function days($days)
{
    $days = is_array($days) ? $days : func_get_args();

    return $this->spliceIntoPosition(5, implode(',', $days));
}
```

どこのメソッド？  

調査結果は以下。  

______________________________________________________________________
______________________________________________________________________
______________________________________________________________________
# 参照方法

#### app\Console\Kernel.php
use
```php
use Illuminate\Console\Scheduling\ManagesFrequencies;
```
トレイト使用宣言
```php
class Kernel extends ConsoleKernel
{
    use ManagesFrequencies;
```
spliceIntoPosition が参照できるようになる
```php
    public function everyFourMinutes()
    {
        return $this->spliceIntoPosition(1, '*/4');
    }

    public function weekly()
    {
        return $this->spliceIntoPosition(1, 0)
                    ->spliceIntoPosition(2, 0)
                    ->spliceIntoPosition(5, 0);
    }
```

そして、spliceIntoPosition が定義されている 「trait ManagesFrequencies（ManagesFrequencies.php）」は、  
everyMinute()　や hourly() といった、Laravel にて使用するメソッドが定義されている。  
そして、spliceIntoPosition は、これらのメソッドから、cron の置換のために参照されている。  

______________________________________________________________________
______________________________________________________________________
______________________________________________________________________
# 参照方法を調べてみた
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Console/Scheduling/ManagesFrequencies.php


```php
    /**
     * Schedule the event to run every minute.
     *
     * @return $this
     */
    public function everyMinute()
    {
        return $this->spliceIntoPosition(1, '*');
    }
```

```
Defined on line 519
protected function spliceIntoPosition($position, $value)
```

```php
    /**
     * Splice the given value into the given position of the expression.
     *
     * @param  int  $position
     * @param  string  $value
     * @return $this
     */
    protected function spliceIntoPosition($position, $value)
    {
        $segments = explode(' ', $this->expression);

        $segments[$position - 1] = $value;

        return $this->cron(implode(' ', $segments));
    }
```

#### framework/src/Illuminate/Console/Scheduling/ManagesFrequencies.php
```php
<?php

namespace Illuminate\Console\Scheduling;

use Illuminate\Support\Carbon;

trait ManagesFrequencies
```


