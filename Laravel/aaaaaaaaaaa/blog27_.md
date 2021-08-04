【Laravel】バックグラウンド処理のついて整理してみる７（スケジューラとジョブ）
________________________________________________________________________________________________



スケジューラで何かしらの処理を実行させる時、コマンドを使う事が多いかと思いますが、スケジューラからキューにジョブを投げる事も可能です。

具体的には、こんな感じ。

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new MyJob01)->everyMinute();
    }
```
上記の処理では、１分ごとにキューにジョブを蓄積していきます。  

ジョブの処理に１分以上かかる場合、キューにどんどんジョブが蓄積されて行きます。

command 同様、重複起動を防止するメソッド等が使用可能です。  

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new MyJob01)
                    ->everyMinute()
                    ->onOneServer()
                    ->runInBackground()
                    ->withoutOverlapping();
    }
```


キューを指定する場合、第二引数にて指定可能です。  

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new MyJob01, 'my-queue01')->everyMinute();
    }
```

キューの種別を指定する場合、第三引数にて指定可能です。  
以下では、'database' を使用しています。  
'sqs', 'redis' 等が指定できます。  

以下ではキュー名を指定していますが、第二引数を null　にすると、デフォルトキューの「default」を適用します。

### app\Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new MyJob01, 'my-queue01', 'database')->everyMinute();
    }
```

## 思った事
スケジューラから直接キューにジョブを放り込むと、運用保守フェーズにて  

「あれ？　スケジュール通りちゃんと動いていないぞ。  
今回はとりあえずコマンドを直接叩いて実行しておくか。」  

という事がやりづらくなってしまうので、コマンドを経由した方がよさそうな気がします。  

プロジェクトの規模が小さければアリだとは思いますが、あんまり積極的に使う気は起きなかったし、勧める気も特にないかな。  



## 参考サイト
Laravel 公式  
https://laravel.com/docs/8.x/scheduling#scheduling-queued-jobs


