【Laravel】バックグラウンド処理のついて整理してみる５（ジョブとキュー：処理の順番）
________________________________________________________________________________________________
前回の続き。  

「ジョブがキューに溜まった時、どんな順番で処理されるの？」  

というのをトレースしてみた。

QUEUE_CONNECTION は database を使用しています。

### .env
```
QUEUE_CONNECTION=database
```


## 検証１：全て同じジョブで実験
こんな感じで、キューにジョブが３つ溜まっているとする。
```
┌─── Queue ──────────────────┐
|                            |
|  ┌──────┬──────┬──────┐    |
|  | Job1 | Job2 | Job3 |    |
|  └──────┴──────┴──────┘    |
|                            |
└────────────────────────────┘
```

Job1・Job2・Job3、は、処理するのに、それぞれ 1分かかる。  

Job1・Job2・Job3 を、5秒おきに実行した時、ジョブをキューに登録して十個する時、処理される順番は？

 パターン１. Job1 を実行 → Job1 の終了を待たずに Job2 を実行 → Job2 の終了を待たずに Job3 を実行 → Job1 終了 → Job2 終了 → Job3 終了  
 パターン２. Job1 を実行 → Job1 終了 → Job2 を実行 → Job2 終了 → Job3 を実行 → Job3 終了  


「1」になるんじゃないの？  
と思いきや、異なる結果が出てしまった。  

以下、実験に使用したコード。  
「20秒おきにログを出力する」という、極めて単純なジョブ。  

### app\Jobs\MyJob01.php
```php
class MyJob01 implements ShouldQueue
{

//（中略）

    public function handle()
    {
        \Log::info(__METHOD__);

        // 20 秒待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 20 seconds later');

        // さらに 20 待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 40 seconds later');

        // さらに 20 待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 60 seconds later');
    }
}
```

ジョブを起動する処理は、こんな感じ。  
### routes\api.php
```php
// http://localhost:8000/api/my-job01
Route::get('my-job01', function(){
    \App\Jobs\MyJob01::dispatch();
    return 'my-job01';
});
```

ジョブの登録は、「ブラウザから URL を 3回叩く」というシンプルな操作。  

そして、ログに出力された内容が、こちら。  

### storage\logs\laravel.log
```log
[2021-08-01 05:28:33] MyJob01::handle  
[2021-08-01 05:28:53] MyJob01::handle: 20 seconds later  
[2021-08-01 05:29:13] MyJob01::handle: 40 seconds later  
[2021-08-01 05:29:33] MyJob01::handle: 60 seconds later  
[2021-08-01 05:29:33] MyJob01::handle  
[2021-08-01 05:29:53] MyJob01::handle: 20 seconds later  
[2021-08-01 05:30:13] MyJob01::handle: 40 seconds later  
[2021-08-01 05:30:33] MyJob01::handle: 60 seconds later  
[2021-08-01 05:30:33] MyJob01::handle  
[2021-08-01 05:30:53] MyJob01::handle: 20 seconds later  
[2021-08-01 05:31:13] MyJob01::handle: 40 seconds later  
[2021-08-01 05:31:33] MyJob01::handle: 60 seconds later  
[2021-08-01 05:31:33] MyJob01::handle  
[2021-08-01 05:31:53] MyJob01::handle: 20 seconds later  
[2021-08-01 05:32:13] MyJob01::handle: 40 seconds later  
[2021-08-01 05:32:33] MyJob01::handle: 60 seconds later  
```

あれ。  
並列で動かしている訳じゃないのか・・・？  

どう見ても順番に処理しているように見える。  

キューを捌いている間の動きが気になったので、jobs テーブルを監視してみた。（目視）  

jobs テーブル、こんな感じ。  
payload のレコードは長いので、適当に省略しています。  
```
|  id   |  queue    |  payload                                                         |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:-----------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  14   |  default  |  {"uuid":"422cadbe-6a6e","displayName":"MyJob01","job": (以下略)  |  1         |  1627795773   |  1627795722    |  1627795722  |
|  15   |  default  |  {"uuid":"8ae3f59c-05fc","displayName":"MyJob01","job": (以下略)  |  0         |  « NULL »     |  1627795732    |  1627795732  |
|  16   |  default  |  {"uuid":"02d0f052-d394","displayName":"MyJob01","job": (以下略)  |  0         |  « NULL »     |  1627795742    |  1627795742  |
```

id が 14, 15, 16 のレコードから順番に attempts が 1 になってレコードが消える。  

全てのレコードの attempts が 1 になる（同時に平行してジョブが実行される）という動きは確認できなかった。  

同一ジョブであればそうなるのだろうか？　という事で、再実験。  

________________________________________________________________________________________________
## 検証２：全て異なるジョブで実験

こんな感じで、別のジョブを作って動かしてみる。
```
php artisan make:job MyJob02
php artisan make:job MyJob03
```

handle メソッドの内容は全部同じ。

### app\Jobs\MyJob02.php、app\Jobs\MyJob02.php
```php
    public function handle()
    {
        \Log::info(__METHOD__);

        // 20 秒待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 20 seconds later');

        // さらに 20 待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 40 seconds later');

        // さらに 20 待機させた後、ログを出力
        sleep(20);
        \Log::info(__METHOD__. ': 60 seconds later');
    }
}
```

ジョブを順番にキューに蓄積。  

### routes\api.php
```php
// http://localhost:8000/api/my-job01-03
Route::get('my-job01-03', function(){
    \App\Jobs\MyJob01::dispatch();
    sleep(5);
    echo 'my-job01';

    \App\Jobs\MyJob02::dispatch();
    sleep(5);
    echo 'my-job02';

    \App\Jobs\MyJob03::dispatch();
    sleep(5);
    echo 'my-job03';

    return 'my-job01-03';
});
```

jobs テーブル、こんな感じになりました。  
MyJob01～03 が、順番に登録されています。  
```
|  id   |  queue    |  payload                                                          |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  7    |  default  |  {"uuid":"bb74136d-c974","displayName":"MyJob01","job":"（以下略） |  1         |  1627804941   |  1627804939    |  1627804939  |
|  8    |  default  |  {"uuid":"8316ddaf-4448","displayName":"MyJob02","job":"（以下略） |  0         |  « NULL »     |  1627804944    |  1627804944  |
|  9    |  default  |  {"uuid":"6e4d9b1e-6bec","displayName":"MyJob03","job":"（以下略） |  0         |  « NULL »     |  1627804949    |  1627804949  |
```

ログはこうなりました。  

### storage\logs\laravel.log
```log
[2021-08-01 08:02:21] MyJob01::handle  
[2021-08-01 08:02:41] MyJob01::handle: 20 seconds later  
[2021-08-01 08:03:01] MyJob01::handle: 40 seconds later  
[2021-08-01 08:03:21] MyJob01::handle: 60 seconds later  
[2021-08-01 08:03:21] MyJob02::handle  
[2021-08-01 08:03:41] MyJob02::handle: 20 seconds later  
[2021-08-01 08:04:01] MyJob02::handle: 40 seconds later  
[2021-08-01 08:04:21] MyJob02::handle: 60 seconds later  
[2021-08-01 08:04:21] MyJob03::handle  
[2021-08-01 08:04:41] MyJob03::handle: 20 seconds later  
[2021-08-01 08:05:01] MyJob03::handle: 40 seconds later  
[2021-08-01 08:05:21] MyJob03::handle: 60 seconds later  
```

MyJob01 を実行 → MyJob01 終了 → MyJob02 を実行 → MyJob02 終了 → MyJob03 を実行 → MyJob03 終了  

と、順番に処理されている。  
並列で同時に動くわけではなかったのか・・・。  


________________________________________________________________________________________________
## 検証３：全て異なるジョブで実験 - queue を分ける

ディスパッチする時、onQueue でキューを指定してみる。  

### routes\api.php
```php
// http://localhost:8000/api/my-job01-03-2
Route::get('my-job01-03-2', function(){
    \App\Jobs\MyJob01::dispatch()->onQueue('my-queue01');;
    sleep(5);
    echo 'my-job01';

    \App\Jobs\MyJob02::dispatch()->onQueue('my-queue02');;
    sleep(5);
    echo 'my-job02';

    \App\Jobs\MyJob03::dispatch()->onQueue('my-queue03');;
    sleep(5);
    echo 'my-job03';

    return 'my-job01-03-2';
});
```

その後、キューワーカーを起動。
```
php artisan queue:work
```

jobs テーブルには、こんな感じのレコードが作成されました。  
queue のカラムに、onQueue で指定した内容が入っています。  
```
|  id   |  queue       |  payload                                                         |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:-------------|:-----------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  16   |  my-queue01  |  {"uuid":"1ef02feb-115d","displayName":"MyJob01","job":（以下略） |  0         |  « NULL »     |  1627807062    |  1627807062  |
|  17   |  my-queue02  |  {"uuid":"b0fa7d01-d6a8","displayName":"MyJob02","job":（以下略） |  0         |  « NULL »     |  1627807067    |  1627807067  |
|  18   |  my-queue03  |  {"uuid":"b988a5ed-c471","displayName":"MyJob03","job":（以下略） |  0         |  « NULL »     |  1627807072    |  1627807072  |
```

しかし、いっこうにジョブが処理される様子が無い。  

php artisan queue:work コマンドを使った時って、処理する queue は default オンリーだっけ？  
と思い、公式を見てみるも、省略した時の挙動の説明は特に無し。  

```
Description:
  Start processing jobs on the queue as a daemon

Usage:
  queue:work [options] [--] [<connection>]

Arguments:
  connection                 The name of the queue connection to work

Options:
      --name[=NAME]          The name of the worker [default: "def
      --queue[=QUEUE]        The names of the queues to work
```
仕方ないので、Laravel のソースを追ってみる。  

どうやら、省略した時は 'default' という名前を使うみたい。  

### framework\src\Illuminate\Queue\WorkerOptions.php
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Queue/WorkerOptions.php#L100
```php
    public function __construct($name = 'default', $backoff = 0, $memory = 128, $timeout = 60, $sleep = 3, $maxTries = 1,
                                $force = false, $stopWhenEmpty = false, $maxJobs = 0, $maxTime = 0, $rest = 0)
    {
        $this->name = $name;
        $this->backoff = $backoff;
        $this->sleep = $sleep;
        $this->rest = $rest;
```



仕方なく、queue の名称を指定してワーカーを起動してみる。
```
php artisan queue:work --queue=my-queue01,my-queue02,my-queue03
```

その時の jobs テーブルの中身、こんな感じ。  
attempts が 1 になり、ジョブが処理され始めました。
```
|  id   |  queue       |  payload                                                          |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:-------------|:------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  13   |  my-queue01  |  {"uuid":"ecab806b-1294","displayName":"MyJob01","job":"（以下略） |  1         |  1627806648   |  1627806647    |  1627806647  |
|  14   |  my-queue02  |  {"uuid":"adbf7292-f068","displayName":"MyJob02","job":"（以下略） |  0         |  « NULL »     |  1627806652    |  1627806652  |
|  15   |  my-queue03  |  {"uuid":"d7f61076-e8b5","displayName":"MyJob03","job":"（以下略） |  0         |  « NULL »     |  1627806657    |  1627806657  |
```

その時のログの内容、こんな感じ。

```log
[2021-08-01 08:30:48] MyJob01::handle  
[2021-08-01 08:31:08] MyJob01::handle: 20 seconds later  
[2021-08-01 08:31:28] MyJob01::handle: 40 seconds later  
[2021-08-01 08:31:48] MyJob01::handle: 60 seconds later  
[2021-08-01 08:31:48] MyJob02::handle  
[2021-08-01 08:32:08] MyJob02::handle: 20 seconds later  
[2021-08-01 08:32:28] MyJob02::handle: 40 seconds later  
[2021-08-01 08:32:48] MyJob02::handle: 60 seconds later  
[2021-08-01 08:32:48] MyJob03::handle  
[2021-08-01 08:33:08] MyJob03::handle: 20 seconds later  
[2021-08-01 08:33:28] MyJob03::handle: 40 seconds later  
[2021-08-01 08:33:48] MyJob03::handle: 60 seconds later  
```

順番に処理されてるぞ。。  

調べてみると、「--queue」オプションは優先順位を指定する時にも使うようで、単にキューを指定するだけでなく、以下のような使い方も想定しているらしい。
```
php artisan queue:work --queue=high,low
```
https://laravel.com/docs/8.x/queues#queue-priorities


________________________________________________________________________________________________
## 検証４：全て異なるジョブで実験 - queue を分ける・ワーカーも分ける

ソースはさっきと同じで、今度はワーカーの起動方法を変えてみる。  

以下のように、ワーカーを３つ起動してみました。
```
php artisan queue:work --queue=my-queue01
php artisan queue:work --queue=my-queue02
php artisan queue:work --queue=my-queue03
```


jobs テーブル、こんな感じ。  
全レコードに対し、attempts が 1 になりました。
```
|  id   |  queue       |  payload                                                         |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:-------------|:-----------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  19   |  my-queue01  |  {"uuid":"965932ab-5905","displayName":"MyJob01","job":（以下略） |  1         |  1627812724   |  1627812724    |  1627812724  |
|  20   |  my-queue02  |  {"uuid":"77dd59ed-c600","displayName":"MyJob02","job":（以下略） |  1         |  1627812731   |  1627812729    |  1627812729  |
|  21   |  my-queue03  |  {"uuid":"d5ba0e84-8cdf","displayName":"MyJob03","job":（以下略） |  1         |  1627812736   |  1627812734    |  1627812734  |
```

ログはこんな感じ。

```log
[2021-08-01 10:12:05] MyJob01::handle  
[2021-08-01 10:12:11] MyJob02::handle  
[2021-08-01 10:12:16] MyJob03::handle  
[2021-08-01 10:12:25] MyJob01::handle: 20 seconds later  
[2021-08-01 10:12:31] MyJob02::handle: 20 seconds later  
[2021-08-01 10:12:36] MyJob03::handle: 20 seconds later  
[2021-08-01 10:12:45] MyJob01::handle: 40 seconds later  
[2021-08-01 10:12:51] MyJob02::handle: 40 seconds later  
[2021-08-01 10:12:56] MyJob03::handle: 40 seconds later  
[2021-08-01 10:13:05] MyJob01::handle: 60 seconds later  
[2021-08-01 10:13:11] MyJob02::handle: 60 seconds later  
[2021-08-01 10:13:16] MyJob03::handle: 60 seconds later  
```

並列で処理されていました。  

________________________________________________________________________________________________
## 全てのキューワーカーを一度に起動させるには？

調べてみたが、どうやら無いみたい。  

[Laravel run all queues at once](https://stackoverflow.com/questions/37672173/laravel-run-all-queues-at-once)  

苦肉の策として出来る事と言えば、コマンドで何とかするぐらい。
```
php artisan queue:work --queue=queue1,queue2,queue3
```
こうしてしまうと、キューに優先順位が付けられてしまうので、それを防ぐには、こう。

```
php artisan queue:work --queue=queue1
   & php artisan queue:work --queue=queue2
   & php artisan queue:work --queue=queue3
```

どのみち、キューの名前を知らないとジョブを捌けない。  


## 分かった事
Laravel において、ジョブとキューを使って並列処理を実現するのは、かなり限定的な用途になるのでは？  

例えば、  
「受信したデータが 1万件あって、それを 1000件単位で分割して並列処理をする」  
という事を実現したい時、ジョブを分割してもキューを１つしか使っていないなら順番にしか処理しない。  

そして、ジョブを分割して複数のキューに登録したとしても、ワーカーはキューの名前をしらないとジョブを捌けないので、  
キューの名前を動的に設定するのは難しい。（登録するだけなら簡単だけど、それをワーカーに捌いてもらうにはどうしたら？　という事を考える必要がある）  

何かいい方法が見つかったら、また書く。  




