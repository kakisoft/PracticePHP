【Laravel】schedule の onOneServer メソッドは、意外と安定しない？ ⇒ 他のサーバの監視チェックのためかも。

________


## 突然、動かなくなったコマンド
スケジューラからコマンドを起動する処理があったが、開発中に、これが突然動かなくなった。  

最近、キャッシュドライバの設定を弄ったから、それが原因か？（onOneServer メソッドは、内部的にキャッシュドライバを使用している）と思ったが、設定を元に戻しても現象は改善されず。  

ログにも出てこないし、before メソッドを実行した形跡も無い。  

コマンドなど存在しなかったかのような挙動だ。  

調べていくと、どうやら onOneServer() メソッドを入れていると安定して動かなくなっていたというのが原因の模様。  

onOneServer メソッドが内部的にキャッシュドライバを使っているという根拠については、以下を参照。  
[【Laravel】Schedule の onOneServer って、どんな動きをしているの？ Laravel のソースコードを追ってみた。](https://kaki-note-02.netlify.app/2021/07/24/)  

## 検証内容
こんな感じで、超シンプルな内容に書き換えて実験。
```php
    $schedule->command(Batch01Command::class)
                ->everyMinute()
                ->onOneServer()
                ;
```

動きをトレースしやすいように、キャッシュドライバは database に設定。  

起動はスケジューラより実施。
```
php artisan schedule:run
```

何度かコマンドを叩いてみたが、「実行される場合」と「実行されない場合」の２パターンがあった。  

cache テーブル、こんな感じ。  
（key の内容は長いので適当に省略しています）

```
|  key                                      |  value  |  expiration  |
|:------------------------------------------|:--------|:-------------|
|  laravel_cacheframework/schedule-9abf345  |  b:1;   |  1628311505  |
|  laravel_cacheframework/schedule-9abf346  |  b:1;   |  1628311565  |
|  laravel_cacheframework/schedule-9abf348  |  b:1;   |  1628311709  |
```

## 原因（多分）
動作確認のため、「php artisan schedule:run」を数秒おきに叩いていた。  

多分、「onOneServer」を使っている時、「他のサーバが実行中か」という事を確認するため、数秒おきにガシガシ叩くような操作には耐えきれないと推測。  

現に、「php artisan schedule:work」でワーカーから起動させる方法にすると、取りこぼしなく実行してくれた。  

そして、「onOneServer」をコメントアウトして実行すると、数秒おきに schedule:run を叩いても、取りこぼしなく実行してくれる。  


## 対策
今回、開発中という事もあり、スケジューラを数秒おきにガシガシ回す操作をしていたが、Laravel がそんな操作は耐えきれない。  
が、普通にワーカーを回す分には耐えられる。  

という事で、その機能を作っている間は一時的に「onOneServer()」をコメントアウトして、push する前に元に戻して最終動作確認、という方法でよさそう。  

この現象、バックグラウンドで何をしているのかよく分からないエンジニアが遭遇したら、結構深刻な気がする。  

理由としては、  
「メッセージが何も表示されなくなる（エラーログにも残らない）ので、原因が究明しづらい」  
「毎回同じことが再現できない。同じことを実行しているのに、場合によって結果が異なる」  
と、なかなか開発者泣かせの挙動をする。  

人によっては、  
「Laravel のこの機能、使えねーっすわ。全然挙動が安定しないしんで、もう使わない方向で行きましょう。  
つーか、フレームワークが裏側でやってる事なんで、どうしようもねーよ。俺は知らん。」  
といった短絡的な結論を出してしまうケースがあってもおかしくない気がしている。  

ちなみに「onOneServer()」をコメントアウトしても、run コマンドで実行しても、正常に実行されない事がありました。  
キャッシュにコマンド履歴が残っている場合、onOneServer() を使おうが使うまいが、問答無用で起動ロックがかかるようです。  
この辺でも開発者泣かせですね。  

その場合はキャッシュをクリアする必要があります。  

スケジューラの起動を、こんな感じでキャッシュクリアとセットしてしまう方がいいかも。
```
php artisan cache:clear | php artisan schedule:run
```



## その他分かった事
database の cache テーブルの中身には、スケジューラから捌いたコマンドがどんどん蓄積されていく。  

そして、「コマンドを叩いたけど、実行されなかった」場合には、レコードが追加されない。  

恐らく、テーブルの中身は「スケジューラから捌くジョブの一覧」が登録されていて、一定時間置かないと同一 key でレコードを作成しようとするが、既に作成済みだとレコードの追加がされず、キャッシュドライバに登録されない。  
という挙動をしていると思われる。  

ちなみに、スケジューラを起動しても、コマンドが実行されな買った場合、cacheテーブルのレコードを削除すると正常に動くようになりました。  

なので、  
***『スケジューラからジョブが動いていない！　起動した・スキップされた、というログすら残ってない！』***  
という現象に遭遇した場合、

**「とりあえず、キャッシュを削除してみて。」**  
という対策が考えられます。  



## 疑問点
キャッシュドライバを Redis とかにしておけば、時間経過と共に勝手に消えてくれそうなイメージがあるけど、溜まったジョブをクリアするにはどうしたら？  

ちなみにジョブが完了してもレコードは残り続けていました。  
キャッシュドライバを database にしていた場合、これを定期的に消すジョブを作成しなければならないのだろうか。  

expiration があるけど、これを見て削除してくれる処理があるのか？  

と思って Laravel のソースを読んでみたら、結構簡単に見つかった。  


### framework\src\Illuminate\Cache\DatabaseLock.php
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Cache/DatabaseLock.php#L52
```php
    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire()
    {
        $acquired = false;

        try {
            $this->connection->table($this->table)->insert([
                'key' => $this->name,
                'owner' => $this->owner,
                'expiration' => $this->expiresAt(),
            ]);

            $acquired = true;
        } catch (QueryException $e) {
            $updated = $this->connection->table($this->table)
                ->where('key', $this->name)
                ->where(function ($query) {
                    return $query->where('owner', $this->owner)->orWhere('expiration', '<=', time());
                })->update([
                    'owner' => $this->owner,
                    'expiration' => $this->expiresAt(),
                ]);

            $acquired = $updated >= 1;
        }

        if (random_int(1, $this->lottery[1]) <= $this->lottery[0]) {
            $this->connection->table($this->table)->where('expiration', '<=', time())->delete();
        }

        return $acquired;
    }
```

lottery が何のことかはよく分からないが、毎回消す訳ではなく、ランダムに消去する処理が走っているっぽい。  



