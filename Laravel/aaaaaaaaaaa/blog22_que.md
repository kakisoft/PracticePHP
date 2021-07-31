【Laravel】バックグラウンド処理のついて整理してみる２（キューをデータベースで使ってみる）
________________________________________________________________________________________________

Event, Listener, Dispatcher, Job, Queue ...  

何やら複雑に絡み合う事が多い、バックグラウンドで処理をさせる時に使う事が多いパーツですが、結構いい加減に使っていたので整理してみました。  

___________________________________________________________________________
## 用語

### キュー（ Queue ）
ジョブを貯めておく箱。  
貯めておいたジョブを順番に処理する。  

### ジョブ（ job ）
キューに放り込まれる何らかの処理。  
ユーザが応答を待たず、バックグラウンドプロセスで動かしたいもの。  

___________________________________________________________________________
## キューについて
「ジョブを貯めていって、順番に処理していくもの」  

という何となくな認識があるものの、「裏側で何やらごちゃごちゃやってるんだろうなー」ぐらいに考えて、  
どう動いているかをトレースする人は少数派なんじゃないかと思います。

ですが、Laravel では、キューの保存先を DB に設定する事ができて、実際にどんなジョブが溜まっていって、どう捌かれていっているのかを目視確認する事が可能です。  
（別に file でも redis でも出来るんだけど、DB でトレースするのが一番楽。）  

テーブルにトレースした場合、こんな感じになります。

```
|  id   |  queue    |  payload                                                                                            |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:----------------------------------------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  1    |  default  |  {"uuid":"05004a83-c6f5","displayName":"SendReminderEmail","job":"QueuedHandler@call",     （以下略） |  0         |  « NULL »     |  1625302485    |  1625302485  |
|  2    |  default  |  {"uuid":"ec278c58-3cef","displayName":"SendReminderEmail","job":"CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625523028    |  1625523028  |
|  3    |  emails   |  {"uuid":"c8fdb0e8-5985","displayName":"SendReminderEmail","job":"CallQueuedHandler@call", （以下略） |  0         |  « NULL »     |  1625534698    |  1625534698  |
```


以下、キューをデータベースで使う時の手順です。

## テーブルを作成
「queue:table」の artisan コマンドを叩くと、テーブル「jobs」の migration ファイルが作成される。  
その後、migrate。  
```
php artisan queue:table
php artisan migrate
```

ちなみに、こんな感じの内容です。
```php
class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
    }
```

## 設定変更
キューの接続を database 変更。

.env ファイルを編集。
#### .env
```
QUEUE_CONNECTION=database
```

config\queue.php を編集。  
先ほど、「jobs」というテーブルを作成ましたが、別のテーブルで扱う事も可能です。  
#### config\queue.php
```conf
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],
```

以上で、キューをデータベースで扱う場合の設定は完了です。  

次回、これを使っていきます。  
