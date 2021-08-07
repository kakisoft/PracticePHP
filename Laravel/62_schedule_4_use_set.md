```php
    private function scheduleLogMessage(Schedule $schedule)
    {
        try {
            $targetCommandName = ClassUtil::getBaseClassName(Batch01Command::class);

            // if( config('batch.batch_command_01.is_enabled') != 1){
            //     \Log::info('スケジューラから起動するコマンドは、設定により無効となっているため、実行されませんでした。', ['Command' => $targetCommandName]);
            //     return;
            // }

            $schedule->command(Batch01Command::class)
                ->everyMinute()
                ->runInBackground()
                ->withoutOverlapping()
                ->onOneServer()
                ->before(function () use ($targetCommandName){
                    \Log::info('Batch01Command start from Scheduler.', ['Command' => $targetCommandName]);
                })
                ->onSuccess(function () use ($targetCommandName){
                    \Log::info('Batch01Command successful.', ['Command' => $targetCommandName]);
                })
                ->onFailure(function () use ($targetCommandName){
                    \Log::error('Batch01Command failed.', ['Command' => $targetCommandName]);
                })
                ->after(function () use ($targetCommandName){
                    \Log::info('Batch01Command finished.', ['Command' => $targetCommandName]);
                });

        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            \Log::warning(__METHOD__ . ':' . $e->getMessage());
        }


        /*
        //==========( 成功した場合 )==========
        [2021-08-07 06:48:24] local.INFO: Batch01Command start from Scheduler. {"Command":"Batch01Command"}
        [2021-08-07 06:48:41] local.INFO: Batch01Command failed. {"Command":"Batch01Command"}
        [2021-08-07 06:48:41] local.INFO: Batch01Command finished. {"Command":"Batch01Command"}


        //==========( エラーが発生した場合 )==========
        [2021-08-07 06:49:11] local.INFO: Batch01Command start from Scheduler. {"Command":"Batch01Command"}
        [2021-08-07 06:49:24] local.ERROR: Batch01Command failed. {"Command":"Batch01Command"}
        [2021-08-07 06:49:24] local.INFO: Batch01Command finished. {"Command":"Batch01Command"}

        */
    }
```