php artisan inspire

___________________________________________________________
## official
https://laravel.com/docs/8.x/scheduling

___________________________________________________________
# コマンド

## 設定タスクの確認
```
php artisan schedule:list
```

## コマンドラインから起動
```
php artisan schedule:test
```

## すぐに１回だけ起動
```
php artisan schedule:run
```

## サーバで起動（例）
１回しか実行しないのでは・・？
```
php artisan schedule:run --verbose --no-interaction


--verbose          Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
-no-interaction    Do not ask any interactive question
```

## ワーカーを待機
```
php artisan schedule:work
```

___________________________________________________________
## schedule コマンド一覧

php artisan list

```
 schedule
  schedule:list        List the scheduled commands
  schedule:run         Run the scheduled commands
  schedule:test        Run a scheduled command
  schedule:work        Start the schedule worker
```
___________________________________________________________
## Command を実行

#### app\Console\Kernel.php
```php
use App\Console\Commands\HelloCommand;
```
```php
    protected function schedule(Schedule $schedule)
    {
        //---------------------------------------------
        //            クラス名を指定
        //---------------------------------------------
        $schedule->command(HelloCommand::class)
            ->description('Hello command Scheduler')
            ->everyMinute();


        //---------------------------------------------
        //             コマンド名を指定
        //---------------------------------------------
        $schedule->command('hello:class')
            ->description('Hello command Scheduler')
            ->everyMinute();


        //---------------------------------------------
        //                 cron
        //---------------------------------------------
        $event = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron('* * * * *');
        // dump($event->expression);  //=> "* * * * *"
    }

```
#### 引数を設定
```php
$schedule->command('emails:send Taylor --force')->daily();

$schedule->command(SendEmailsCommand::class, ['Taylor', '--force'])->daily();
```

```
[2021-06-29 02:05:10] local.ERROR: Command "AppConsoleHelloCommand" is not defined. {"exception":"[object] (Symfony\\Component\\Console\\Exception\\CommandNotFoundException(code: 0): Command \"AppConsoleHelloCommand\" is not defined. at /var/www/html/my-laravel-app/vendor/symfony/console/Application.php:682)
[stacktrace]
#0 /var/www/html/my-laravel-app/vendor/symfony/console/Application.php(255): Symfony\\Component\\Console\\Application->find('AppConsoleHello...')
#1 /var/www/html/my-laravel-app/vendor/symfony/console/Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#2 /var/www/html/my-laravel-app/vendor/laravel/framework/src/Illuminate/Console/Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#3 /var/www/html/my-laravel-app/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#4 /var/www/html/my-laravel-app/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#5 {main}
"} 
```

## $commands への記述
「 artisan list 」で表示するための設定？ 無くても出てきたぞ。 ⇒ 5.5 以降は不要
```php
    protected $commands = [
        Commands\HelloCommand::class
    ];

```

https://laravel.com/docs/8.x/artisan
```
If necessary, you may manually register commands by adding the command's class name to the $commands property of your App\Console\Kernel class. When Artisan boots, all the commands listed in this property will be resolved by the service container and registered with Artisan:

protected $commands = [
    Commands\SendEmails::class
];
```

https://www.larajapan.com/2019/04/06/%E7%9F%A5%E3%82%89%E3%81%AA%E3%81%8B%E3%81%A3%E3%81%9F%E3%82%B3%E3%83%9E%E3%83%B3%E3%83%89%E3%81%AE%E8%87%AA%E5%8B%95%E7%99%BB%E9%8C%B2/
```
5.5からはもうこの手間はもうなくなりました。 app/Console/Commandsのディレクトリにファイルを作成すれば、Kernel.phpを編集しなくても自動的に登録してくれます。
```
↓が自動で登録してくれている。
#### app\Console\Kernel.php
```php
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
```


___________________________________________________________
## Command クラス以外から実行

### 即時実行

#### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
                \Log::info("abstruct method");
                return 0;
            })
            ->description('Hello command Scheduler')
            ->everyMinute();
    }
```


### コマンドライン（ node.js アプリ等も実行可。）

#### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->exec('php '.base_path().'/artisan hello:class --env=production')->everyMinute();

        $schedule->exec('node /home/forge/script.js')->daily();
    }
```

___________________________________________________________
## 実行メソッド
https://laravel.com/docs/8.x/scheduling


|  Method                           |  Description                                              |
|:----------------------------------|:----------------------------------------------------------|
|  ->cron('* * * * *');             |  Run the task on a custom cron schedule                   |
|  ->everyMinute();                 |  Run the task every minute                                |
|  ->everyTwoMinutes();             |  Run the task every two minutes                           |
|  ->everyThreeMinutes();           |  Run the task every three minutes                         |
|  ->everyFourMinutes();            |  Run the task every four minutes                          |
|  ->everyFiveMinutes();            |  Run the task every five minutes                          |
|  ->everyTenMinutes();             |  Run the task every ten minutes                           |
|  ->everyFifteenMinutes();         |  Run the task every fifteen minutes                       |
|  ->everyThirtyMinutes();          |  Run the task every thirty minutes                        |
|  ->hourly();                      |  Run the task every hour                                  |
|  ->hourlyAt(17);                  |  Run the task every hour at 17 minutes past the hour      |
|  ->everyTwoHours();               |  Run the task every two hours                             |
|  ->everyThreeHours();             |  Run the task every three hours                           |
|  ->everyFourHours();              |  Run the task every four hours                            |
|  ->everySixHours();               |  Run the task every six hours                             |
|  ->daily();                       |  Run the task every day at midnight                       |
|  ->dailyAt('13:00');              |  Run the task every day at 13:00                          |
|  ->twiceDaily(1, 13);             |  Run the task daily at 1:00 & 13:00                       |
|  ->weekly();                      |  Run the task every Sunday at 00:00                       |
|  ->weeklyOn(1, '8:00');           |  Run the task every week on Monday at 8:00                |
|  ->monthly();                     |  Run the task on the first day of every month at 00:00    |
|  ->monthlyOn(4, '15:00');         |  Run the task every month on the 4th at 15:00             |
|  ->twiceMonthly(1, 16, '13:00');  |  Run the task monthly on the 1st and 16th at 13:00        |
|  ->lastDayOfMonth('15:00');       |  Run the task on the last day of the month at 15:00       |
|  ->quarterly();                   |  Run the task on the first day of every quarter at 00:00  |
|  ->yearly();                      |  Run the task on the first day of every year at 00:00     |
|  ->yearlyOn(6, 1, '17:00');       |  Run the task every year on June 1st at 17:00             |
|  ->timezone('America/New_York');  |  Set the timezone for the task                            |


___________________________________________________________
## 多重起動防止
withoutOverlapping
```php
$schedule->command('emails:send')->withoutOverlapping();
```

___________________________________________________________
## スケジューリングの後付け変更

```php
        $event = $schedule->command('inspire')
                        ->hourly();

        dd($event->expression); // "0 * * * *"

        // dd($event->expression); // hourly()      : "0 * * * *"
        // dd($event->expression); // everyMinute() : "* * * * *"
```


