```php
    private function scheduleLogMessage(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->everyMinute()
            ->onOneServer()
            ->runInBackground()
            ->withoutOverlapping()
            ->before(function () {
                \Log::info('Batch01Command start from Scheduler.');
            })
            ->onSuccess(function () {
                \Log::info('Batch01Command successful.');
            })
            ->onFailure(function () {
                \Log::info('Batch01Command failed.');
            })
            ->after(function () {
                \Log::info('Batch01Command finished.');
            });
    }
```