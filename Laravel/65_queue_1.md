## official document
https://laravel.com/docs/8.x/queues


## コンフィグファイル
#### config\queue.php

#### .env
```
QUEUE_CONNECTION=sync
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
```
1.QueueにJobがあるか問い合わせを行う  
2.もしJobがあれば、そのJobを実行させる  




