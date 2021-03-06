## official document
https://laravel.com/docs/8.x/queues


## コンフィグファイル

#### .env
```
QUEUE_CONNECTION=sync
```

#### config\queue.php
```php
    'connections' => [

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'your-queue-name'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        ],

        'redis' => [
```

_______________________________________________________
## 用語

#### Queue
Jobを並ばせる「列」。  
保存先はDB/「どのDBにするか」によってドライバが変わる（SQS,Redis...）

#### Job
何らかの処理

#### Dispatch
JobをQueueに送ること

#### Worker
Queueの中のJobに対する処理するプロセス

## デッドレターキュー
https://dev.classmethod.jp/articles/sqs-dead-letter-queue-metrics-for-alert/  
正常に処理できないSQSメッセージを移動（退避）させるキューのこと。

 * 問題のあるメッセージを分離して、問題の原因を調査できる。
 * 元のキューのワーカーは、問題のあるメッセージを何度も受信してエラーし続けることを避けられる。そのため処理能力が向上する。



_______________________________________________________
## 登録されたジョブの例
[jobレコードの例](.\66_job_1.md)  

_______________________________________________________
# 使用方法

## テーブルを使う場合
```
php artisan queue:table
php artisan migrate
```

```php
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
```


#### config\queue.php
sync は、キューに入れた後、即実行。（同期実行）
```php
    'default' => env('QUEUE_CONNECTION', 'sync'),
```

#### .env
```
QUEUE_CONNECTION=sync

        ↓

QUEUE_CONNECTION=database
```

#### 設定ファイルのキャッシュをクリア　※重要※
```
php artisan cache:clear
```

#### ジョブ作成
```
php artisan make:job SendReminderEmail
```


#### app\Jobs\SendReminderEmail.php
```php
class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

// 中略

    public function handle()
    {
        // ※このログは/storage/log/laravel.logに記述されます。
        Log::info('「登録が完了しました」というメールを送信');
    }
}
```

#### routes\api.php
```php
use App\Jobs\SendReminderEmail;

//================================================================
//                           Queue
//================================================================
// http://localhost:8000/api/SendReminderEmail01
Route::get('/SendReminderEmail01', function () {
    $log = (new SendReminderEmail)->delay(10);
    dispatch($log);
    return 'ユーザー登録完了を通知するメールを送信しました。01';
});

// http://localhost:8000/api/SendReminderEmail02
Route::get('/SendReminderEmail02', function () {
    SendReminderEmail::dispatch("dispatch");
    return 'ユーザー登録完了を通知するメールを送信しました。02';
});

// http://localhost:8000/api/SendReminderEmail03
Route::get('/SendReminderEmail03', function () {
    SendReminderEmail::dispatch("dispatch")->onQueue('emails');
    return 'ユーザー登録完了を通知するメールを送信しました。03 - "emails" キュー ';
});
```

#### Workerの起動
```
php artisan queue:work
php artisan queue:work sqs --verbose --tries=3 --timeout=90
```
1.QueueにJobがあるか問い合わせを行う  
2.もしJobがあれば、そのJobを実行させる  

#### 別のQueue_Connectionを利用する
https://reffect.co.jp/laravel/laravel-queue-setting-manuplate
```php
SendWelcomeMail::dispatch($user)->onConnection('redis');
```
```
php artisan queue:work redis
```

## キューのイメージ

#### キュー
select * from jobs

|  id   |  queue    |  payload                                                                                                                           |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:-----------------------------------------------------------------------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  1    |  default  |  {"uuid":"05004a83-c6f5","displayName":"App\\Jobs\\SendReminderEmail","job":"Illuminate\\Queue\\CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625302485    |  1625302485  |
|  2    |  default  |  {"uuid":"ec278c58-3cef","displayName":"App\\Jobs\\SendReminderEmail","job":"Illuminate\\Queue\\CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625523028    |  1625523028  |
|  3    |  emails   |  {"uuid":"c8fdb0e8-5985","displayName":"App\\Jobs\\SendReminderEmail","job":"Illuminate\\Queue\\CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625534698    |  1625534698  |


#### デッドレターキュー
select * from dead_jobs

|  id   |  queue      |  payload                                                                                                                           |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:------------|:-----------------------------------------------------------------------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  1    |  dead_job1  |  {"uuid":"12e0e551-d51e","displayName":"App\\Jobs\\SendReminderEmail","job":"Illuminate\\Queue\\CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625302485    |  1625302485  |

別テーブルが作成されるイメージ。

```
{
	"uuid": "ec278c58-3cef-40c6-9fb7-aa6807f9da73",
	"displayName": "App\\Jobs\\SendReminderEmail",
	"job": "Illuminate\\Queue\\CallQueuedHandler@call",
	"maxTries": null,
	"maxExceptions": null,
	"failOnTimeout": false,
	"backoff": null,
	"timeout": null,
	"retryUntil": null,
	"data": {
		"commandName": "App\\Jobs\\SendReminderEmail",
		"command": "O:26:\"App\\Jobs\\SendReminderEmail\":10:{s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"
	}
}
```
```
"command": 
"O:26:\"App\\Jobs\\SendReminderEmail\":10:
{
    s:3:\"job\";N;
    s:10:\"connection\";N;
    s:5:\"queue\";N;
    s:15:\"chainConnection\";N;
    s:10:\"chainQueue\";N;
    s:19:\"chainCatchCallbacks\";N;
    s:5:\"delay\";N;
    s:11:\"afterCommit\";N;
    s:10:\"middleware\";
    a:0:{}s:7:\"chained\";
    a:0:{}}
"
```


```
{
	"uuid": "c8fdb0e8-5985-44d4-b828-d7208f9f9bfd",
	"displayName": "App\\Jobs\\SendReminderEmail",
	"job": "Illuminate\\Queue\\CallQueuedHandler@call",
	"maxTries": null,
	"maxExceptions": null,
	"failOnTimeout": false,
	"backoff": null,
	"timeout": null,
	"retryUntil": null,
	"data": {
		"commandName": "App\\Jobs\\SendReminderEmail",
		"command": "O:26:\"App\\Jobs\\SendReminderEmail\":10:{s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";s:6:\"emails\";s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"
	}
}

```
```
"command": 
"O:26:\"App\\Jobs\\SendReminderEmail\":10:
{
    s:3:\"job\";N;
    s:10:\"connection\";N;
    s:5:\"queue\";s:6:\"emails\";s:15:\"chainConnection\";N;
    s:10:\"chainQueue\";N;
    s:19:\"chainCatchCallbacks\";N;
    s:5:\"delay\";N;
    s:11:\"afterCommit\";N;
    s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}
}
"
```
