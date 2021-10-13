# failed

## ジョブが死んだ時に実行されるメソッド
https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs


```php
use Throwable;

class MyJob11 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // ユーザーへ失敗を通知するなど…
        echo "Send user notification of failure, etc...";
        \Log::info("Send user notification of failure, etc...");
    }
```

## Commands\SampleCommand.php
```php
    private function pruebaProcess10()
    {
        \App\Jobs\MyJob11::dispatch();
    }
```

## 実行コマンド
```
php artisan queue:listen

php artisan queue:listen --tries=3 --timeout=60
```

______________________________________________________________________________
# Laravel

## framework\src\Illuminate\Queue\Console\ListenCommand.php
```php
class ListenCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'queue:listen
                            {connection? : The name of connection}
                            {--name=default : The name of the worker}
                            {--delay=0 : The number of seconds to delay failed jobs (Deprecated)}
                            {--backoff=0 : The number of seconds to wait before retrying a job that encountered an uncaught exception}
                            {--force : Force the worker to run even in maintenance mode}
                            {--memory=128 : The memory limit in megabytes}
                            {--queue= : The queue to listen on}
                            {--sleep=3 : Number of seconds to sleep when no job is available}
                            {--timeout=60 : The number of seconds a child process can run}
                            {--tries=1 : Number of times to attempt a job before logging it failed}';
```

