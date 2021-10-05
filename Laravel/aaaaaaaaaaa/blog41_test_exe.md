【Laravel】キャッシュクリアコマンドには、テストコード実行前に流さない方がよいものがある

laravel-test-

テストコード実行時の注意点
Precautions when executing test code
Precautions when executing test code
caution-point-when-executing-test-code

_____________________________________________________________________
Laravel で、大きな修正を pull してきた時、キャッシュクリアとして以下のコマンドを叩いていました。  

 * php artisan cache:clear
 * php artisan config:clear
 * php artisan route:clear
 * php artisan view:clear
 * php artisan clear-compiled
 * php artisan optimize
 * php artisan config:cache

実際には以下のようにパイプで繋ぎ、コマンド１回で流してます。  

```
php artisan cache:clear | php artisan config:clear | php artisan route:clear | php artisan view:clear | php artisan clear-compiled | php artisan optimize | php artisan config:cache
```

ところが、テストコードを実行する時、上記のキャッシュクリアコマンドを叩いていると、テストにてエラーが発生してしまいました。  

１つ１つ調べてみると、以下の２つが原因でした。  

 * php artisan optimize
 * php artisan config:cache


## php artisan optimize
アプリをいい感じで最適化してくれる。  

・・・かと思いきや、実際は「php artisan config:cache」と「php artisan route:cache」を実行してるだけらしい。  
<https://qiita.com/mmmmmmanta/items/1df41c4cbc8e77e15326>  

ホンマかいな？  
と思い、Laravel ソースを見てみると、本当にそんな感じだった。  

### framework\src\Illuminate\Foundation\Console\OptimizeCommand.php
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/OptimizeCommand.php#L28
```php
class OptimizeCommand extends Command
{

//（中略）

    protected $name = 'optimize';

//（中略）

    public function handle()
    {
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info('Files cached successfully!');
    }
```

キャッシュクリアコマンドを見直す必要がありそう。

そして、テストコードを実行するにあたり、「config:cache」が問題になっていました。


## php artisan config:cache
コンフィグをキャッシュする。  
このコマンドが曲者で、テスト実行時に良くない挙動を起こす事がある。  

キャッシュしたコンフィグは、以下のディレクトリに格納される。
```
/bootstrap/cache/config.php
```

キャッシュファイルは .env をベースに作成される。（正確には OSの環境変数にて指定された .env ファイル）  

そして、このキャッシュファイルは、phpunit.xml の設定よりも優先度が高くなってしまう。  

例えば、.env と phpunit.xml の設定が以下だったとする。  

### .env
```ini
QUEUE_CONNECTION=sqs
```

### phpunit.xml
```xml
<server name="QUEUE_CONNECTION" value="sync"/>
```

テストコードを実行する側の意識としては、当然 phpunit.xml の設定が有効（ QUEUE_CONNECTION は sync ）と考えてしまうが、実際は**キャッシュされた設定（QUEUE_CONNECTION は sqs）を参照していまう。**  

ジョブや非同期処理が複雑に絡み合う処理が盛り込まれている場合、状況によっては上手く動かないケースがある。  
（バックエンド処理の部分が非同期で実行されてしまうため、処理が完了するよりも先にassertの行に到達してしまい、想定する結果が得られない、等）  

対策としては、テストコードにて、非同期処理が完了するまで wait を入れたりする事ぐらいだろうか。  
何にせよ、スマートな解決は難しそう。  


## 結論

***テストコードを実行する時、コンフィグをクリアする。（php artisan config:clear を実行する）***
***その後、コンフィグをキャッシュしない（php artisan config:cache を実行しない）***

ソースコードの内容によっては、こんな事に気を付けなくても正しく動くケースもありますが、こうしておいた方がイレギュラーな動作に悩まされる心配が少なくなるかと思います。  

____
＜参考＞  
https://github.com/laravel/framework/issues/13374  
https://github.com/laravel/framework/issues/32556  




https://qiita.com/acro5piano/items/9de74564c121d1a8e606

