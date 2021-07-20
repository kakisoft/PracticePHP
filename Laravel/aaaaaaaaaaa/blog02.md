【Laravel】$schedule->command にて、crom メソッドの引数が不正だった場合、全てのコマンドが実行されない。

________________________________________________________________________________________________
Laravel の $schedule->command にて、バッチが起動する間隔を「->everyFiveMinutes()」「->dailyAt('13:00')」といったメソッドではなく、  
「->cron('* 0 * * *')」と、cron で設定する事が出来ます。  

「cronメソッドの引数に渡す値が不正だった場合、どんな挙動になるの？」（起動スケジュールをコンフィグで自由に設定できるようにしたかったので、設定が不正だった時の挙動を把握しておきたかった）  
というのが気になったので、実験。  


以下のようなコードを書いてみました。  
# 実験１

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleExecuteBatches($schedule);
    }

    private function scheduleExecuteBatches(Schedule $schedule)
    {
        $this->scheduleExecuteCommand01($schedule);
        $this->scheduleExecuteCommand02($schedule);
        $this->scheduleExecuteCommand03($schedule);
    }

    private function scheduleExecuteCommand01(Schedule $schedule)
    {
        try {
            $schedule->command(Batch01Command::class)
                ->everyMinute()
                ->runInBackground();

        } catch (\Exception $e) {
            $this->warn(__METHOD__ . ':' . $e->getMessage());
            \Log::warning(__METHOD__ . ':' . $e->getMessage());
        }
    }

    private function scheduleExecuteCommand02(Schedule $schedule)
    {
        try {
            $schedule->command(Batch02Command::class)
                ->cron('* * * * *aaa')
                ->runInBackground();

        } catch (\Exception $e) {
            $this->warn(__METHOD__ . ':' . $e->getMessage());
            \Log::warning(__METHOD__ . ':' . $e->getMessage());
        }
    }

    private function scheduleExecuteCommand03(Schedule $schedule)
    {
        try {
            $schedule->command(Batch03Command::class)
                ->cron('* * * * *')
                ->runInBackground();

        } catch (\Exception $e) {
            $this->warn(__METHOD__ . ':' . $e->getMessage());
            \Log::warning(__METHOD__ . ':' . $e->getMessage());
        }
    }
```

## 実験の趣旨

 * cron メソッドへの引数が不正だった時、その次に実行予定のバッチは実行されるの？
 * 設定が不正だった時、Try-catch で捕捉できる？ その時のエラーメッセージは？

一番最初の Batch01Command は実行されるだろうけど、その後の処理はどうなるの？ という意図。  


## 実験結果
コマンド
```
php artisan schedule:run
```

ログの内容
```log
[2021-07-20 07:00:38] local.ERROR: Invalid CRON field value *aaa at position 4 {"exception":"[object] (InvalidArgumentException(code: 0): Invalid CRON field value *aaa at position 4 at /var/www/html/my-laravel-app/vendor/dragonmantank/cron-expression/src/Cron/CronExpression.php:158)
[stacktrace]
#0 /var/www/html/my-laravel-app/vendor/dragonmantank/cron-expression/src/Cron/CronExpression.php(139): Cron\\CronExpression->setPart(4, '*aaa')
#1 /var/www/html/my-laravel-app/vendor/dragonmantank/cron-expression/src/Cron/CronExpression.php(114): Cron\\CronExpression->setExpression('* * * * *aaa')

（以下略）
```

後続の処理どころか、正しい設定をされているはずの Batch01Command すらも実行されなかった。  

という事で、結論。

***Schedule の cron メソッドの引数が不正だった時、全てのコマンドが実行されない。***  

