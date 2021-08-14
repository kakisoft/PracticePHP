【Laravel】コマンドを動的に実行し、非同期・重複実行防止の制御をする。

______________________________________________________________________________

前回の続き。  

Artisan::call で何とかできないかと模索してみたが、無理でした。  
実現できるにしても、裏技チックな操作になりそうなので止めておきました。   

という事で、スケジューラを使う方法を考えてみた。  

以下、書いてみたコード。  

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $targetCommands = [Batch01Command::class, Batch02Command::class, Batch03Command::class];

        foreach ($targetCommands as $targetCommand) {
            $this->executeEachCommand($schedule, $targetCommand);
        }
    }

    private function executeEachCommand(Schedule $schedule, $targetCommand)
    {
        try {
            if (!is_subclass_of($targetCommand, SymfonyCommand::class)) {
                return;
            }

            $targetCommandName = ClassUtil::getBaseClassName($targetCommand);

            $schedule->command($targetCommand)
                ->everyMinute()
                ->runInBackground()
                ->withoutOverlapping()
                ->onOneServer()
                ->before(function () use ($targetCommandName){
                    \Log::info('The command by scheduler has been executed.', ['Command' => $targetCommandName]);
                })
                ->onSuccess(function () use ($targetCommandName){
                    \Log::info('The command by scheduler has been completed successfully.', ['Command' => $targetCommandName]);
                })
                ->onFailure(function () use ($targetCommandName){
                    \Log::error('The command by scheduler has been finished with error(s).', ['Command' => $targetCommandName]);
                });

        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            \Log::warning(__METHOD__ . ':' . $e->getMessage());
        }

    }
```

### Batch01Command, Batch02Command, Batch02Command の handle メソッド
前回と少し変えた。  
全て共通で、30秒おきにログを出力します。  
重複起動されるかをチェックしたいので、処理に 90秒かかるようにしました。（ジョブは 1分おきに起動）
```php
    public function handle()
    {
        $this->info(__METHOD__);
        \Log::info(__METHOD__);

        // 30 秒間遅延させる
        sleep(30);

        $this->info(__METHOD__ . ': after 30 second');
        \Log::info(__METHOD__. ': after 30 second');

        // 30 秒間遅延させる
        sleep(30);

        $this->info(__METHOD__ . ': after 60 second');
        \Log::info(__METHOD__. ': after 60 second');

        // 30 秒間遅延させる
        sleep(30);

        $this->info(__METHOD__ . ': after 90 second');
        \Log::info(__METHOD__. ': after 90 second');
    }
```

## 実験１：１回だけ実行する
まずは、「php artisan schedule:run」で、１回だけ実行。  

以下、結果です。  

### laravel.log
```log
[2021-08-14 10:32:32] local.INFO: The command by scheduler has been executed. {"Command":"Batch01Command"} 
[2021-08-14 10:32:32] local.INFO: The command by scheduler has been executed. {"Command":"Batch02Command"} 
[2021-08-14 10:32:32] local.INFO: The command by scheduler has been executed. {"Command":"Batch03Command"} 
[2021-08-14 10:32:34] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-08-14 10:32:34] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-08-14 10:32:35] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-08-14 10:33:04] local.INFO: App\Console\Commands\Batch01Command::handle: after 30 second  
[2021-08-14 10:33:04] local.INFO: App\Console\Commands\Batch02Command::handle: after 30 second  
[2021-08-14 10:33:05] local.INFO: App\Console\Commands\Batch03Command::handle: after 30 second  
[2021-08-14 10:33:34] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-08-14 10:33:34] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-08-14 10:33:35] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
[2021-08-14 10:34:04] local.INFO: App\Console\Commands\Batch02Command::handle: after 90 second  
[2021-08-14 10:34:04] local.INFO: App\Console\Commands\Batch01Command::handle: after 90 second  
[2021-08-14 10:34:05] local.INFO: App\Console\Commands\Batch03Command::handle: after 90 second  
[2021-08-14 10:34:06] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch02Command"} 
[2021-08-14 10:34:06] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch01Command"} 
[2021-08-14 10:34:09] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch03Command"} 
```

無事、意図通りに並列で処理してくれました。  


## 実験２：ワーカーを回して何回も実行する
次は「php artisan schedule:work」何回もバッチを回してみる。  


### laravel.log
```log
[2021-08-14 10:35:03] local.INFO: The command by scheduler has been executed. {"Command":"Batch01Command"} 
[2021-08-14 10:35:03] local.INFO: The command by scheduler has been executed. {"Command":"Batch02Command"} 
[2021-08-14 10:35:03] local.INFO: The command by scheduler has been executed. {"Command":"Batch03Command"} 
[2021-08-14 10:35:06] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-08-14 10:35:06] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-08-14 10:35:07] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-08-14 10:35:36] local.INFO: App\Console\Commands\Batch03Command::handle: after 30 second  
[2021-08-14 10:35:36] local.INFO: App\Console\Commands\Batch02Command::handle: after 30 second  
[2021-08-14 10:35:37] local.INFO: App\Console\Commands\Batch01Command::handle: after 30 second  
[2021-08-14 10:36:06] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
[2021-08-14 10:36:06] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-08-14 10:36:07] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-08-14 10:36:36] local.INFO: App\Console\Commands\Batch02Command::handle: after 90 second  
[2021-08-14 10:36:36] local.INFO: App\Console\Commands\Batch03Command::handle: after 90 second  
[2021-08-14 10:36:37] local.INFO: App\Console\Commands\Batch01Command::handle: after 90 second  
[2021-08-14 10:36:39] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch02Command"} 
[2021-08-14 10:36:39] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch03Command"} 
[2021-08-14 10:36:41] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch01Command"} 
[2021-08-14 10:37:04] local.INFO: The command by scheduler has been executed. {"Command":"Batch01Command"} 
[2021-08-14 10:37:04] local.INFO: The command by scheduler has been executed. {"Command":"Batch02Command"} 
[2021-08-14 10:37:04] local.INFO: The command by scheduler has been executed. {"Command":"Batch03Command"} 
[2021-08-14 10:37:08] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-08-14 10:37:08] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-08-14 10:37:10] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-08-14 10:37:38] local.INFO: App\Console\Commands\Batch01Command::handle: after 30 second  
[2021-08-14 10:37:38] local.INFO: App\Console\Commands\Batch02Command::handle: after 30 second  
[2021-08-14 10:37:40] local.INFO: App\Console\Commands\Batch03Command::handle: after 30 second  
[2021-08-14 10:38:08] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-08-14 10:38:08] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-08-14 10:38:10] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
[2021-08-14 10:38:38] local.INFO: App\Console\Commands\Batch01Command::handle: after 90 second  
[2021-08-14 10:38:38] local.INFO: App\Console\Commands\Batch02Command::handle: after 90 second  
[2021-08-14 10:38:40] local.INFO: App\Console\Commands\Batch03Command::handle: after 90 second  
[2021-08-14 10:38:40] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch02Command"} 
[2021-08-14 10:38:40] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch01Command"} 
[2021-08-14 10:38:44] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch03Command"} 
[2021-08-14 10:39:03] local.INFO: The command by scheduler has been executed. {"Command":"Batch01Command"} 
[2021-08-14 10:39:04] local.INFO: The command by scheduler has been executed. {"Command":"Batch02Command"} 
[2021-08-14 10:39:04] local.INFO: The command by scheduler has been executed. {"Command":"Batch03Command"} 
[2021-08-14 10:39:06] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-08-14 10:39:06] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-08-14 10:39:08] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-08-14 10:39:36] local.INFO: App\Console\Commands\Batch02Command::handle: after 30 second  
[2021-08-14 10:39:36] local.INFO: App\Console\Commands\Batch01Command::handle: after 30 second  
[2021-08-14 10:39:38] local.INFO: App\Console\Commands\Batch03Command::handle: after 30 second  
[2021-08-14 10:40:06] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-08-14 10:40:06] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-08-14 10:40:08] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
[2021-08-14 10:40:36] local.INFO: App\Console\Commands\Batch01Command::handle: after 90 second  
[2021-08-14 10:40:36] local.INFO: App\Console\Commands\Batch02Command::handle: after 90 second  
[2021-08-14 10:40:38] local.INFO: App\Console\Commands\Batch03Command::handle: after 90 second  
[2021-08-14 10:40:38] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch01Command"} 
[2021-08-14 10:40:38] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch02Command"} 
[2021-08-14 10:40:42] local.INFO: The command by scheduler has been completed successfully. {"Command":"Batch03Command"} 
```
無事、重複起動なく並列で処理してくれました。  

1分おきに起動し、処理に 90秒かかるので、時間帯によっては既に実行中のジョブがあったりします。  
損な場合は、「No scheduled commands are ready to run.」というメッセージがコンソールに出てくることを確認できました。  



