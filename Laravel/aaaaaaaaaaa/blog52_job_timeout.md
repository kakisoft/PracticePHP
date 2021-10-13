【Laravel】ジョブがタイムアウトした場合、エラー扱いにして特定の処理を実行する事はできない？

_____________________________________________________________________


## ジョブが失敗した時、何かしらの処理を実行する
ジョブが失敗した時に自動で実行するメソッド（ failed メソッド）が用意されていて、そこに失敗した時の処理を記述する事ができる。  

**＜Laravel 公式＞**  
https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs  


## タイムアウトをエラーとして検出できる？
以下のように、「処理に 70秒かかる処理」にて「タイムアウトを 60秒」として実行してみました。  

公式では、以下のように説明されています。

> タイムアウトによるジョブの失敗をマークしたい場合は、ジョブクラスに$failOnTimeoutプロパティを定義します。

試しにその通りに書いてみたのですが、failed は実行されませんでした。  

原因がよく分からなかったので調べてみたところ、どうやら failed メソッドを実行するという意味ではなく、failed-table に格納される、という意味のようです。  
（書き方が紛らわしいですが）  

キューの登録を RDB にしている場合、「failed_jobs」テーブルにて内容を確認可能です。  

試しに「$failOnTimeout」を false にしてみたところ、「failed_jobs」テーブルにレコードは登録されませんでした。  

```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class MyJob12 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info(__METHOD__);

        sleep(70);  // 70秒ウェイト

        \Log::info('70 second passed');
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

コマンド
```
php artisan queue:listen --tries=3 --timeout=60
```

実行結果
```log
[2021-10-13 14:39:19] local.INFO: App\Jobs\MyJob12::handle  
[2021-10-13 14:40:11] local.ERROR: The process "'/usr/local/bin/php' 'artisan' 'queue:work' '--once' '--name=default' '--queue=default' '--backoff=0' '--memory=128' '--sleep=3' '--tries=3'" exceeded the timeout of 60 seconds. {"exception":"[object] (Symfony\\Component\\Process\\Exception\\ProcessTimedOutException(code: 0): The process \"'/usr/local/bin/php' 'artisan' 'queue:work' '--once' '--name=default' '--queue=default' '--backoff=0' '--memory=128' '--sleep=3' '--tries=3'\" exceeded the timeout of 60 seconds. at /var/www/html/my-laravel-app/vendor/symfony/process/Process.php:1213)
```

「failed_jobs」テーブルの中は、こんな感じになります。  

```
|  id   |  uuid                                  |  connection  |  queue    |  payload                                                        |  exception                                                                                                                                                                                                                                               |  failed_at            |
|:------|:---------------------------------------|:-------------|:----------|:----------------------------------------------------------------|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|:----------------------|
|  19   |  30004e6e-8c0b-4374-ab99-e20d10a15e33  |  database    |  default  |  {"uuid":"30004e6e-8c0b-4374-ab99-e20d10a15e33","displayName":  |  Illuminate\Queue\MaxAttemptsExceededException: App\Jobs\MyJob12 has been attempted too many times or run too long. The job may have previously timed out. in /var/www/html/my-laravel-app/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:750  |  2021/10/13 14:52:26  |
```

exception カラムにエラーの原因が書いているので、障害発生時の調査に使えそう。  
（queue コネクションに RDBを使わないケースが多いと思うけど）  

SQS でもエラーの詳細が取れるかは未調査。  
分かったら後で書く。  



