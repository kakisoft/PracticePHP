【Laravel】Schedule の appendOutputTo で、ログファイルに出力する

______________________________________________________


## appendOutputTo メソッド
Schedule にてコマンドを実行する時、appendOutputTo メソッドを使うと、出力先のログファイルを指定する事が出来ます。  

具体的には、こんな感じ。

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->appendOutputTo('/var/log/schedule.log')
            ->everyMinute()
            ->before(function () {
                \Log::info('Batch01Command start from Scheduler.');
            })
            ->onSuccess(function () {
                \Log::info('Batch01Command successful.');
            })
            ->onFailure(function () {
                \Log::error('Batch01Command failed.');
            })
            ->after(function () {
                \Log::info('Batch01Command finished.');
            });
    }
```

コマンドクラスはこんな感じ。  

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        // 標準出力
        $this->info('Standard Output:'. __METHOD__);

        // ログファイルに出力
        \Log::info('Out to Logfile:' . __METHOD__);

        return 0;
    }
```

「php artisan schedule:run」で実行。  

appendOutputTo で指定したログに、「標準出力」にて指定した内容が記録されます。  

### /var/log/schedule.log
```
Standard Output:App\Console\Commands\Batch01Command::handle
```


## 標準出力を使ってみる
Laravel のログ出力を、標準出力に切り替える事が出来ます。  

詳細はこちらを。  
[Laravelでログを標準出力（stdout）させる方法](https://www.engilaboo.com/laravel-log-stdout/)  

### logging.php
```php
'stdout' => [
    'driver' => 'monolog',
    'handler' => StreamHandler::class,
    'with' => [
        'stream' => 'php://stdout',
    ],
],
```

### .env
```
LOG_CHANNEL=stdout
```

設定後、コンフィグキャッシュをクリア。  

こうすると、ログファイルに出力する内容が、標準出力に切り替わります。  

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        // 標準出力
        $this->info('Standard Output:'. __METHOD__);

        // ログファイルに出力
        \Log::info('Out to Logfile:' . __METHOD__);

        return 0;
    }
```

コマンドを単体で動かした場合、以下のようになります。  

### コンソール（コマンドを実行）
```
root@e95f0802ab0c:/var/www/html/my-laravel-app# php artisan command:batch01
Standard Output:App\Console\Commands\Batch01Command::handle
[2021-08-19 17:44:02] local.INFO: Out to Logfile:App\Console\Commands\Batch01Command::handle  
```

このように、「標準出力」の内容と「ログファイルに出力」の内容が、コンソールに表示されます。  

上記の内容を、「artisan schedule:run」からコマンドを実行すると、こうなります。  

Console\Kernel.php は、こんな感じ。  

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->appendOutputTo('/var/log/schedule.log')
            ->everyMinute()
            ->before(function () {
                \Log::info('Batch01Command start from Scheduler.');
            })
            ->onSuccess(function () {
                \Log::info('Batch01Command successful.');
            })
            ->onFailure(function () {
                \Log::error('Batch01Command failed.');
            })
            ->after(function () {
                \Log::info('Batch01Command finished.');
            });
    }
```

### コンソール（スケジューラからコマンドを実行）
```
[2021-08-19T17:45:23+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/schedule.log' 2>&1
[2021-08-19 17:45:24] local.INFO: Batch01Command start from Scheduler.  
[2021-08-19 17:45:30] local.INFO: Batch01Command successful.  
[2021-08-19 17:45:30] local.INFO: Batch01Command finished.
```

### /var/log/schedule.log
```
Standard Output:App\Console\Commands\Batch01Command::handle
[2021-08-19 17:47:36] local.INFO: Out to Logfile:App\Console\Commands\Batch01Command::handle
```

laravel.log には、何も出力されません。  


## コマンドに出力されている内容を標準出力するには？
かなり試行錯誤を繰り返す事になったので、次回。  

