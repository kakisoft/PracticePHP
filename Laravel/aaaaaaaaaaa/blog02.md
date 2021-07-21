
withoutOverlapping()
【Laravel】Schedule にて実行するコマンドは、withoutOverlapping() を付けないと、同じジョブが重複して実行される可能性がある

____________________________________________________________________________________
## withoutOverlapping()
Laravel の Schedule には、withoutOverlapping() というメソッドがあり、これを使わない限り、タスクが重複して実行される事があるみたい。  


【 公式サイト 】  
<https://laravel.com/docs/8.x/scheduling#preventing-task-overlaps>

> By default, scheduled tasks will be run even if the previous instance of the task is still running.
> To prevent this, you may use the withoutOverlapping method:

つまり、「1分に1回実行するバッチ」があり、そのバッチの実行完了に 100秒かかるとすると、バッチの終了を待たずに次々と実行される、という挙動だろうか。  

というわけで、実験してみる。  

_________________________________________________________________________
# 実験１：withoutOverlapping() を付けずに実行
1分に1回実行する、Batch01Command, Batch02Command, Batch03Command を設定。  

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
        $schedule->command(Batch01Command::class)
            ->everyMinute()
            ->runInBackground();
    }

    private function scheduleExecuteCommand02(Schedule $schedule)
    {
        $schedule->command(Batch02Command::class)
            ->everyMinute()
            ->runInBackground();
    }

    private function scheduleExecuteCommand03(Schedule $schedule)
    {
        $schedule->command(Batch03Command::class)
            ->everyMinute()
            ->runInBackground();
    }
```


### app\Console\Commands\Batch01Command.php
開始・終了にログを吐く。  
100秒のウェイトをかけて、処理に 1分以上かかるようにする。  
```php
    public function handle()
    {
        $this->info(__METHOD__ . ':start');
        \Log::info(__METHOD__. ':start');

        // 100 秒間ウェイト
        sleep(100);

        $this->info(__METHOD__ . ':end');
        \Log::info(__METHOD__. ':end');
    }

    // Batch02Command, Batch03Command も、全く同じ処理
```


そして、以下のコマンドで待ち受けを起動。  
```
php artisan schedule:work
```

以下、ログに出力された内容です。  

### storage\logs\laravel.log
```log
[2021-07-21 12:51:07] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 12:51:07] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 12:51:09] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 12:52:05] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 12:52:05] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 12:52:05] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 12:52:47] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 12:52:47] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 12:52:49] local.INFO: App\Console\Commands\Batch03Command::handle:end  
[2021-07-21 12:53:07] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 12:53:07] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 12:53:09] local.INFO: App\Console\Commands\Batch03Command::handle:start  

（中略）

[2021-07-21 12:55:45] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 12:55:45] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 12:55:45] local.INFO: App\Console\Commands\Batch03Command::handle:end  
[2021-07-21 12:56:05] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 12:56:05] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 12:56:06] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 12:56:48] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 12:56:48] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 12:56:48] local.INFO: App\Console\Commands\Batch03Command::handle:end  
[2021-07-21 12:56:56] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 12:56:56] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 12:56:56] local.INFO: App\Console\Commands\Batch03Command::handle:end  
```

Batch01Command, Batch02Command, Batch03Command は、それぞれのジョブの終了を待たず、同じジョブが同時に走っている。  

業種や処理内容によっては、調査が非常に難しい障害が発生しそうなので、この挙動は抑えておいたほうがよさそう。  

_________________________________________________________________________
# 実験２：withoutOverlapping() を付けて事項
各バッチを「withoutOverlapping()」を付けて実行。  
それ以外は「実験１」と全く同じ。  

### app\Console\Kernel.php
```php
    private function scheduleExecuteCommand01(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping();
    }

    private function scheduleExecuteCommand02(Schedule $schedule)
    {
        $schedule->command(Batch02Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping();
    }

    private function scheduleExecuteCommand03(Schedule $schedule)
    {
        $schedule->command(Batch03Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping();
    }
```

以下、ログに出力された内容です。  

### storage\logs\laravel.log
```log
[2021-07-21 13:09:07] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 13:09:07] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 13:09:09] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 13:10:47] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 13:10:47] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 13:10:49] local.INFO: App\Console\Commands\Batch03Command::handle:end  
[2021-07-21 13:11:08] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 13:11:08] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 13:11:10] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 13:12:48] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 13:12:48] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 13:12:50] local.INFO: App\Console\Commands\Batch03Command::handle:end  
[2021-07-21 13:13:08] local.INFO: App\Console\Commands\Batch01Command::handle:start  
[2021-07-21 13:13:08] local.INFO: App\Console\Commands\Batch02Command::handle:start  
[2021-07-21 13:13:09] local.INFO: App\Console\Commands\Batch03Command::handle:start  
[2021-07-21 13:14:48] local.INFO: App\Console\Commands\Batch02Command::handle:end  
[2021-07-21 13:14:48] local.INFO: App\Console\Commands\Batch01Command::handle:end  
[2021-07-21 13:14:49] local.INFO: App\Console\Commands\Batch03Command::handle:end  
```

さっきとは違い、重複して同じバッチが実行されないようになっている。  

業務アプリなら、もう無条件で付けといてよいのではないだろうか。  
余計な事故に発展しそうだし。  

１分に１回動くスケジューラが動いているのですが、前回起動のジョブが完了しておらず、実行できるジョブが無かった場合、コンソールからはこんなメッセージが表示されました。  
```
No scheduled commands are ready to run.
```


## 結論
Schedule にてジョブを起動している場合、重複して実行させたくない場合、「->withoutOverlapping()」を付けよう！  


