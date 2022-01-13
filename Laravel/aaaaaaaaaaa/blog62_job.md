【Laravel】ジョブのタイムアウトを設定する変数「$timeout」は、コメントアウト時でも有効？

________________________________________________________________
【 環境 】
Laravel のバージョン： 8.16.1
PHP のバージョン： 7.4.7


## ジョブのタイムアウト時間の設定
前回、こんなのを書きました。  

[【Laravel】ジョブがタイムアウトした時に failed メソッドを実行するための条件](https://kaki-note-02.netlify.app/2021/12/29/)  

ジョブを実行する時、タイムアウト時間をソースコードにも設定する事ができます。  

具体的には、「public $timeout」という定型文のような変数があり、この変数を追加すると、Laravel が自動でその変数の値を読み取り、タイムアウト時間として設定してくれます。  

```php
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
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 10;  // ←この変数を追加

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

## コメントアウトを無視して実行するタイムアウト設定
このタイムアウト設定だが、何とも妙な動きをする。  

具体的には、コメントアウトしていても、その内容を読み取り、タイムアウト時間として使用している節がある。  

以下、検証内容。  
キューの待ち受けコマンドは以下を使用しました。  
```
php artisan queue:work
```

### 実験１：タイムアウト時間 - 10秒（コメントアウト）
```
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    // public $timeout = 10;  // ←こんな感じでコメントアウト
```

**結果**  
```log
```


]
この状態で、キューの待ち受けコマンドを発行します。  
以下、コマンド例。  
```
php artisan queue:work
```

ちなみに、コマンド実行時に、「--timeout=60」といったオプションを付けた場合、ソースコードに記述されたタイムアウト時間の方が優先順位が高くなります。  

また、コマンド・変数共にタイムアウト時間を設定しなかった場合、デフォルト値の「60秒」という値が設定されます。  
（Laravel ソースコードより解析）  

## $timeout の設定内容について
ところが、このタイムアウト時間を設定する変数「$timeout」だが、どうも妙な動きをするケースがある。  

具体的には、コメントアウトをしていても、その値が有効となっている節がある。  
以下、検証のために書いたソースコードと実行結果。  



________



> ＜概要＞  
> ジョブが失敗した時に自動で実行するメソッド（ failed メソッド）が用意されていて、そこに失敗した時の処理を記述する事ができる。  
> 
> しかし、タイムアウト時には failed メソッドが実行されない。  
> 
> タイムアウト発生時に何かしらの処理を実行させる事はできないのでは？

色々試してみた結果、タイムアウト発生時に failed メソッドを実行する事が出来ました。  


### 変更点１：pcntl を有効化する
実は、タイムアウト時間を自由に制御するには pcntl というプロセス制御機構が必要となり、これを有効化する必要がある。  

詳細および設定方法については、こちらを。  
[Laravel : ジョブのタイムアウトを設定には、pcntl（PHPの拡張項目）を有効化する必要がある](https://www.kakistamp.com/entry/2021/12/29/163656)  
[PHP・Docker：Docker コンテナ起動の PHP にて、pcntl を有効にする方法](https://www.kakistamp.com/entry/2021/12/28/125832)


### 変更点２：待ち受けコマンドを「queue:work」にする
前回、キューの待ち受けコマンドに「queue:listen」を使っていたのですが、「queue:work」で動かしてみました。  

具体的には、以下のコマンドを使用しています。  

```
php artisan queue:work --tries=3 --timeout=10
```
ジョブのタイムアウト時間を 10秒に設定しています。  

### ソースコード
ジョブ実行時に、70秒のウェイトがかかるようにしています。  

上記コマンドにて、タイムアウト時間が 10秒としているので、必ずタイムアウトが発生するようになります。  
```php
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

### 実行結果
```log
[2021-12-30 03:24:41] local.INFO: App\Jobs\MyJob12::handle  
[2021-12-30 03:24:51] local.INFO: Send user notification of failure, etc...  
```
こんな感じで、タイムアウト時に failed メソッドが実行されました。  


### あとがき
「queue:listen」の場合、１度コマンドを実行すると後はずっと動いてくれるので、cron などで定期的にジョブ実行する仕組みが不要となる。  
しかし、「queue:work」は１回しか実行してくれないので、本番環境やステージング環境で動かす場合、定時実行の仕組みを用意する必要がある。  

ちょっと面倒だけど、タイムアウト時に特定のフラグを解除しないと後続バッチに影響が出る、といった場合はその方法がよさそう。  

ちなみに、何故 listen と work の違いで、このような挙動の差が生まれているのかまではよく分かってません。  
何となく、Laravel のバグっぽい気がします。  


