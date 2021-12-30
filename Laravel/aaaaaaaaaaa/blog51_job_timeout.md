【Laravel】ジョブがタイムアウトした時に failed メソッドを実行するための条件

________________________________________________________________
【 環境 】
Laravel のバージョン： 8.16.1
PHP のバージョン： 7.4.7


前回、こんなのを書きました。  

[【Laravel】ジョブがタイムアウトした場合、エラー扱いにして特定の処理を実行する事はできない？](https://kaki-note-02.netlify.app/2021/10/12/)  

> （内容）  
> ジョブが失敗した時に自動で実行するメソッド（ failed メソッド）が用意されていて、そこに失敗した時の処理を記述する事ができる。  
> しかし、タイムアウト時には failed メソッドが実行されない。  
> タイムアウト発生時に何かしらの処理を実行させる事はできないのでは？

色々試してみた結果、タイムアウト発生時に failed メソッドを実行する事が出来ました。  


### 変更点１：pcntl を有効化する
実は、タイムアウト時間を自由に制御するには pcntlというプロセス制御機構が必要となり、これを有効化する必要がある。  

詳細および設定方法については、こちらを。  
[Laravel : ジョブのタイムアウトを設定には、pcntl（PHPの拡張項目）を有効化する必要がある](https://www.kakistamp.com/entry/2021/12/29/163656)  
[PHP・Docker：Docker コンテナ起動の PHP にて、pcntl を有効にする方法](https://www.kakistamp.com/entry/2021/12/28/125832)


### 変更点２：待ち受けコマンドを「queue:work」にする
前回、キューの待ち受けコマンドに「queue:listen」を使っていたのですが、「queue:work」で動かしてみました。  

具体的には、以下のコマンドを使用しています。  

```
php artisan queue:work --tries=3 --timeout=10
```

### ソースコード
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

### あとがき
「queue:listen」の場合、１度コマンドを実行すると後はずっと動いてくれるので、cron などで定期的にジョブ実行する仕組みが不要となる。  
しかし、「queue:work」は１回しか実行してくれないので、本番環境やステージング環境で動かす場合、定時実行の仕組みを用意する必要がある。  

ちょっと面倒だけど、タイムアウト時に特定のフラグを解除しないと後続バッチに影響が出る、といった場合はその方法がよさそう。  

ちなみに、何故 listen と work の違いで、このような挙動の差が生まれているのかまではよく分かってません。  
何となく、Laravel のバグっぽい気がします。  



