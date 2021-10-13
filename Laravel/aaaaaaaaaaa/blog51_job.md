【Laravel】ジョブが失敗した時、自動で特定の処理を実行する。（failed メソッド）

_____________________________________________________________________


## ジョブが失敗した時、何かしらの処理を実行する
ジョブが失敗した時に自動で実行するメソッドが用意されていて、そこに失敗した時の処理を記述する事ができる。  

「ジョブ失敗時に、何かしらの値を更新したい」「ジョブ失敗時に、失敗した内容をどこかに保持したい」といった場面にて有効利用できる。  

**＜Laravel 公式＞**  
https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs  


具体的には、「failed」というメソッドを追加しておけば、Laravel が自動的にコールしてくれる。  

試しに、以下のようなコードで実験してみました。  
エラーとしては、ゼロ割を発生させるというシンプルな内容。  

### app\Jobs\MyJob11.php
```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class MyJob11 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info(__METHOD__);

        $a = 0;

        $b = 4 / $a;
    }

    /**
     * ジョブの失敗を処理
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
}
```

ジョブは、コマンドから適当に dispatch しています。  

キューワーカーを動かすコマンドは、こんな感じ。  
```
php artisan queue:listen
```

出力されたログは、こんな感じでした。

### storage\logs\laravel.log
```log
[2021-10-13 12:52:14] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 12:52:14] local.INFO: Send user notification of failure, etc...  
[2021-10-13 12:52:14] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:38)
[stacktrace]
```

無事、failed にて記述した内容が実行されています。  


## リトライ回数を指定した時の挙動
続いて、キューを以下のようにリトライ回数を指定して実行してみます。  

```
php artisan queue:listen --tries=3
```

実行結果は以下のようになりました。  

### storage\logs\laravel.log
```log
[2021-10-13 12:58:54] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 12:58:55] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:38)

（中略）

[2021-10-13 12:59:01] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 12:59:02] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:38)

（中略）

[2021-10-13 12:59:08] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 12:59:08] local.INFO: Send user notification of failure, etc...  
[2021-10-13 12:59:08] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:38)
```

リトライ回数を「3」にしているので、3回目の実行時に failed を実行しています。  

--tries を省略した場合、「--tries=1」となります。  
以下、参考の Laravel ソース。  


### framework\src\Illuminate\Queue\Console\ListenCommand.php
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


## リトライ回数を固定化する
リトライ回数を、ソースコードに記述する事もできる。  

具体的には、「public $tries」という変数を定義する。  
変数名は、Laravel における決まり事だと思ってください。  

```php
class MyJob11 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
```

この値は、artisan コマンドで指定した値よりも優先される。  

例えば、以下のようにリトライ回数を 3 に設定しても、5回まで実行される。  
```
php artisan queue:listen --tries=3
```

### storage\logs\laravel.log
```log
[2021-10-13 13:05:49] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 13:05:49] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:45)

（中略）

[2021-10-13 13:05:55] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 13:05:56] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:45)

（中略）

[2021-10-13 13:06:02] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 13:06:03] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:45)

（中略）

[2021-10-13 13:06:09] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 13:06:09] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:45)

（中略）

[2021-10-13 13:06:15] local.INFO: App\Jobs\MyJob11::handle  
[2021-10-13 13:06:15] local.INFO: Send user notification of failure, etc...  
[2021-10-13 13:06:15] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Jobs/MyJob11.php:45)
```

以上のように、5回実行され、5回目の失敗時に failed メソッドの内容を実行しています。  


