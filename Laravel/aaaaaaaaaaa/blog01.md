【Laravel】schedule からコールされる command は、１つのコマンドが終了するまで待機して順番に実行される。


________________________________________________________________________________________________
Laravel のスケジューラ（ schedule:run コマンド）を使用した時、定義された command は非同期で実行されるの？  

気になったんで実験。  
結論は既にタイトルに出てます。  

以下のコードで実験しました。
# 実験１

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleExecuteBatches($schedule);
    }

    private function scheduleExecuteBatches(Schedule $schedule)
    {
        $this->scheduleExecuteCommand01($schedule);  // ログを吐く処理がある（「処理１」とする）
        $this->scheduleExecuteCommand02($schedule);  // ログを吐く処理がある（「処理２」とする）
        $this->scheduleExecuteCommand03($schedule);  // ログを吐く処理がある（「処理３」とする）

        \Log::info("AAAAA");  // ログを吐く処理。「処理：A」とする
    }

    private function scheduleExecuteCommand01(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->everyMinute();
    }
    // Command02 以降は省略
```
### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        $this->info(__METHOD__);
        \Log::info(__METHOD__);
    }
```
Command02 以降は省略。全て同じコード。  

以下、php artisan schedule:run で動かしてみた時のログの内容。  

### storage\logs\laravel.log
```log
[2021-07-20 04:54:09] local.INFO: AAAAA  
[2021-07-20 04:54:13] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-07-20 04:54:16] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-07-20 04:54:19] local.INFO: App\Console\Commands\Batch03Command::handle  
```

### ログが出力された順番

「処理：A」  
　　↓  
「処理１」  
　　↓  
「処理２」  
　　↓  
「処理３」  

各コマンドでどれだけ処理がかかるかによって、結果が変わってくるかもしれない。  

___________________________________________________________________________
# 実験２
上記コードの command を以下のように修正して実験。  

Batch02Command, Batch03Command, も、全て同じコードです。  

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        $this->info(__METHOD__);
        \Log::info(__METHOD__);

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 20 second');
        \Log::info(__METHOD__. ': after 20 second');

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 40 second');
        \Log::info(__METHOD__. ': after 40 second');

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 60 second');
        \Log::info(__METHOD__. ': after 60 second');

        return 0;
    }
```


ログは以下のようになりました。  

### storage\logs\laravel.log
```log
[2021-07-20 04:55:59] local.INFO: AAAAA  
[2021-07-20 04:56:03] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-07-20 04:56:13] local.INFO: App\Console\Commands\Batch01Command::handle: after 20 second  
[2021-07-20 04:56:23] local.INFO: App\Console\Commands\Batch01Command::handle: after 40 second  
[2021-07-20 04:56:33] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-07-20 04:56:36] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-07-20 04:56:46] local.INFO: App\Console\Commands\Batch02Command::handle: after 20 second  
[2021-07-20 04:56:56] local.INFO: App\Console\Commands\Batch02Command::handle: after 40 second  
[2021-07-20 04:57:06] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-07-20 04:57:09] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-07-20 04:57:19] local.INFO: App\Console\Commands\Batch03Command::handle: after 20 second  
[2021-07-20 04:57:29] local.INFO: App\Console\Commands\Batch03Command::handle: after 40 second  
[2021-07-20 04:57:39] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
```
Batch02Command は、Batch01Command の終了を確認した後に実行しているものと思われます。  

という事で、schedule で command を順番に呼び出している時、非同期で実行するのではなく、１つ１つ完了した後で実行している事が分かりました。  


