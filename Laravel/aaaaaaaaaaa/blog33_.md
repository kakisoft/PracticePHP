【Laravel】Schedule から command を実行する時、標準出力の内容を出力させる

______________________________________________________

## スケジューラからコマンドを実行する時のメッセージ出力先
appendOutputTo を使用すると、ログファイルに出力できます。  

以下、サンプルコード。  
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

でも、出力先を標準出力に変更する事は出来ないみたい。  

ですが、シンボリックリンクを張って標準出力のプロセスにリダイレクトする、という方法で実現できました。  
ちなみに、シンボリックリンクは Dockerfile にて記述しています。  

以下、参考サイト。  

[Laravelでschedule:runしたときのoutputがdockerで標準出力されない問題を解消](https://qiita.com/imunew/items/6b210ea05b70885ce990)  
[Echoing to /dev/stdout does not appear in 'docker logs' ](https://github.com/moby/moby/issues/19616)  

Dockefile の書き方が、サイトによってまちまち。  

ログを標準出力に出力する設定にしているので、コンソールにそれらの内容が出力されています。  

## １．シンボリックリンク：/proc/1/fd/1
「Laravelでschedule:runしたときのoutputがdockerで標準出力されない問題を解消」のサイトでは、こんな感じ。  
```
RUN ln -sf /proc/1/fd/1 /var/log/laravel-scheduler.log
```

appendOutputTo の出力先を、 /var/log/laravel-scheduler.log に変えて実験。  

以下、出力結果。  

### 実験結果１．コンソール
```
root@c06e55bffea0:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T18:05:56+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/laravel-scheduler.log' 2>&1
[2021-08-19 18:05:57] local.INFO: Batch01Command start from Scheduler.  
[2021-08-19 18:05:57] local.ERROR: Batch01Command failed.  
[2021-08-19 18:05:57] local.INFO: Batch01Command finished.
```

コマンドの内容は出力されませんでした。  

あと、何故か onFailure に分岐してる。  


## ２．シンボリックリンク：/proc/1/fd/1
「Echoing to /dev/stdout does not appear in 'docker logs'」のサイトでは、こんな感じ。  
```
ln -sf /proc/$$/fd/1 /var/log/test.log
```

> What you want is to redirect output to STDOUT of PID 1. PID 1 is the process launched by docker, and its STDOUT will be what docker picks up.  
> （必要なのは、出力をPID 1のSTDOUTにリダイレクトすることです。  
> 　PID1は、dockerによって起動されるプロセスであり、そのSTDOUTがdockerが取得するプロセスになります。）  

.

> Note however this will only work if you don't launch your container with --pid=host.  
> If you do, you'll need to set up the symlink in your daemon.sh script with something such as  
> （ただし、これは--pid = hostを使用してコンテナを起動しない場合にのみ機能することに注意してください。  
> 　その場合は、daemon.shスクリプトで次のようなものを使用してシンボリックリンクを設定する必要があります。）  

という事らしい。  

ちなみに、「$$」は、現在のプロセスの事のようです。  

appendOutputTo の出力先を /var/log/test.log に変更して、再実験。  

以下、出力結果。

### 実験結果２．コンソール
```
root@c06e55bffea0:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T18:18:04+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/test.log' 2>&1
[2021-08-19 18:18:04] local.INFO: Batch01Command start from Scheduler.  
[2021-08-19 18:18:05] local.ERROR: Batch01Command failed.  
[2021-08-19 18:18:05] local.INFO: Batch01Command finished.
```

結果、変わらず。


## ３．シンボリックリンク：/proc/1/fd/1
https://github.com/moby/moby/issues/19616#issuecomment-174492543  

> /dev/stdout is a symlink to /proc/self/fd/1, not /proc/1/fd/1. Subtle, but very significant difference.  
> （/dev/stdoutは、/proc/1/fd/1ではなく、/proc/self/fd/1 へのシンボリックリンクです。微妙ですが、非常に重要な違いです）  

シェルスクリプトに「self」なんてあったっけ？  

と思いきや、Docker 公式サイトに、こんなのがあった。  

### Docker 公式サイト
https://docs.docker.jp/config/container/logging/index.html  

> 公式 httpd イメージは、 httpd アプリケーションの設定を変更し、通常の出力を /proc/self/fd/1 （つまり STDOUT） にします。
> また、エラーは /proc/self/fd/2 （つまり STDERR ）にします。詳細は Dockerfile をご覧ください。

どうやら、Docker コンテナ上では、「/proc/self/fd/1」が標準出力を指しているらしい。  

という事で、以下のように修正して再々実験。
```
RUN ln -sf /proc/self/fd/1 /var/log/test.log
```

### 実験結果３．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T18:23:08+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/test.log' 2>&1
[2021-08-19 18:23:08] local.INFO: Batch01Command start from Scheduler.  
[2021-08-19 18:23:14] local.INFO: Batch01Command successful.  
[2021-08-19 18:23:14] local.INFO: Batch01Command finished.
```
**onSuccess に分岐してくれました！**  
一歩前進。  
しかし、コマンドクラスにて設定した標準出力は見えず。  


## ４．シンボリックリンク：/proc/\*/fd/\*
試しに書いてみた。
```
RUN ln -sf /proc/*/fd/*: /var/log/test.log
```

結果、変わらず。  


## ５．コマンドを編集してみる
output->writeLn で試してみる。  

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        // 標準出力
        $this->info('Standard Output:'. __METHOD__);

        // ログファイルに出力
        \Log::info('Out to Logfile:' . __METHOD__);

        // 標準出力２
        $this->output->writeLn("output->writeLn:" . __METHOD__);

        return 0;
    }
```

### 実験結果５．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T19:18:12+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/test.log' 2>&1
[2021-08-19 19:18:13] local.INFO: Batch01Command start from Scheduler.  
[2021-08-19 19:18:18] local.INFO: Batch01Command successful.  
[2021-08-19 19:18:18] local.INFO: Batch01Command finished.
```
結果、変わらず。  

コマンドから実行した場合はちゃんと出力されているので、処理そのものに問題があるわけではないみたい。  

### 実験結果５．extra ：コマンドから実行
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan command:batch01
Standard Output:App\Console\Commands\Batch01Command::handle
[2021-08-19 19:20:11] local.INFO: Out to Logfile:App\Console\Commands\Batch01Command::handle  
output->writeLn:App\Console\Commands\Batch01Command::handle
```


## ６．ログを通常の出力に変えてみる
ログを標準出力に出力する設定との相性が悪いのか？  

という事で、LOG_CHANNEL を修正。
```
LOG_CHANNEL=stack
```

### 実験結果６．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T19:23:21+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/test.log' 2>&1
root@eec3c702faff:/var/www/html/my-laravel-app# 
```
何も出力されなくなりました。  


## ７．チャンネルを指定してみる
「Log::channel('stdout')」と、ログのチャンネルを明示してみた。  

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        \Log::channel('stdout')->info('Scheduler:Specify the channel');

        $schedule->command(Batch01Command::class)
            ->appendOutputTo('/var/log/schedule.log')
            ->everyMinute()
```

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        // 標準出力
        $this->info('Standard Output:'. __METHOD__);

        // ログファイルに出力
        \Log::info('Out to Logfile:' . __METHOD__);

        // チャンネルを指定して出力
        \Log::channel('stdout')->info('Command:Specify the channel');

        return 0;
    }
```

### 実験結果７．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19 19:37:23] local.INFO: Scheduler:Specify the channel  
[2021-08-19T19:37:24+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 > '/dev/null' 2>&1
```
スケジューラからの起動は問題ないのですが、コマンドからの出力がありませんでした。  

この指定方法なら、appendOutputTo でログファイルを指定する必要は無いのでは？　と思ったが、結果、変わらず。  

ちなみにコマンドを実行すると、普通にコンソールに出てくれます。


## 現時点での結論
未解決の闇深案件となりました。  

解決次第、追って報告します。  

この検証する時、いちいち docker コンテナをリビルドしないといけなかいのが、超面倒。  



_______________

## ８．ログファイルを指定してみる
ログ出力内容をカスタマイズしてみる

### config\logging.php
```php
    'custom' => [
        'driver' => 'single',
        'path' => storage_path('/var/log/test.log'),
        'level' => 'info',
        'permission' => 0666,
    ],
```

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        \Log::channel('stdout')->info('Scheduler:Specify the channel');
```

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        // 標準出力
        $this->info('Standard Output:'. __METHOD__);

        // ログファイルに出力
        \Log::info('Out to Logfile:' . __METHOD__);

        // チャンネルを指定して出力
        \Log::channel('stdout')->info('Command:Specify the channel');

        // チャンネルを指定して出力
        \Log::channel('stdout')->info('Command:Specify the channel');

        // カスタムチャンネルを指定して出力
        \Log::channel('custom')->info('Scheduler:Specify the channel');
        return 0;
    }
```

### 実験結果８．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19T19:59:54+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> '/var/log/test.log' 2>&1
```

結果、変わらず。  


## ９．カスタムで普通のログファイルを指定してみる
こんな感じで、リダイレクトが入っていないログに出力してみる。

### config\logging.php
```php
    'custom' => [
        'driver' => 'single',
        'path' => storage_path('/var/log/non-redirect.log'),
        'level' => 'info',
        'permission' => 0666,
    ],
```

結果、ログに出力されず。  
（スケジューラ・コマンド共に）   

という事は、この階層へのアクセスがそもそも出来ないという事？  


## １０．カスタムで普通のログファイルを指定してみる２
通常の Laravel プロジェクト配下を指定してみる。  

### config\logging.php
```php
    'custom' => [
        'driver' => 'single',
        'path' => storage_path('logs/custom.log'),
        'level' => 'info',
        'permission' => 0666,
    ],
```

スケジューラ・コマンド共に、こんな感じで出力されました。  

### storage\logs\custom.log
```
[2021-08-19 20:09:59] local.INFO: Scheduler:Specify the channel  
[2021-08-19 20:10:05] local.INFO: Command:Specify the channel  
```

という事は、docker プロジェクト配下のパスにシンボリックリンクを作成しておけば行けるのか？  


## １１．Laravel プロジェクト配下に、シンボリックリンクを作成
Docker リビルドが面倒になってきたので、普通にシンボリックリンクを作成。  

「test.log」としました。  
```
ln -sf /proc/self/fd/1 /var/www/html/my-laravel-app/storage/logs/test.log
```

コンフィグを修正。
### config\logging.php
```php
    'custom' => [
        'driver' => 'single',
        'path' => storage_path('logs/test.log'),
        'level' => 'info',
        'permission' => 0666,
    ],
```

### 実験結果１１．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19 20:20:52] local.INFO: Scheduler:Specify the channel  
[2021-08-19T20:20:52+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 > '/dev/null' 2>&1
```

スケジューラからは上手くいっているみたい。  
しかし、コマンドからの内容は相変わらず。  

が、この方法でもリダイレクトが効くという事が判明。  

それなら、appendOutputTo で、リダイレクトが有効だったパスを指定し見るとよいのでは？  
### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        \Log::channel('stdout')->info('Scheduler:Specify the channel');

        $schedule->command(Batch01Command::class)
            ->appendOutputTo('logs/test.log')
            ->everyMinute()
```

### 実験結果１１―２．コンソール
```
root@eec3c702faff:/var/www/html/my-laravel-app# php artisan config:clear | php artisan cache:clear | php artisan schedule:run
[2021-08-19 20:24:21] local.INFO: Scheduler:Specify the channel  
[2021-08-19T20:24:22+00:00] Running scheduled command: '/usr/local/bin/php' 'artisan' command:batch01 >> 'logs/test.log' 2>&1
```
結果、変わらず。  
コマンドの内容は、相変わらず出てきませんでした。  




