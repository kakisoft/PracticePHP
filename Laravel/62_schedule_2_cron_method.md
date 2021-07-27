## cron を動かす場合、こっちの方が使いやすい
php artisan schedule:work


## 条件によっては動作しない
php artisan schedule:run



```php
    protected function schedule(Schedule $schedule)
    {
        $JOB06_CONF = '21 * * * *';

        $event05 =$schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB06_CONF);
        dump($event05->expression);  //=> "21 * * * *"

        //==============================================================

        $JOB06_CONF = '*/1 * * * *';

        $event06 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB06_CONF);
        dump($event06->expression);  //=> "*/1 * * * *"
    }
```


```php
    protected function schedule(Schedule $schedule)
    {
        $event01 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->everyMinute();
        dump($event01->expression);  //=> "* * * * *"

        $event02 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->hourly();
        dump($event02->expression);  //=> "0 * * * *"

        $event04 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron('1 * * * *');
        dump($event04->expression);  //=> "1 * * * *"
    }
```


```php
    protected function schedule(Schedule $schedule)
    {
        $MINUTE = 10;

        $events = [];
        for($i=0; $i<=1; $i++){
            $cronParam = ($MINUTE + $i) . ' * * * *';
            $events[] = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($cronParam);
        }
    }
```


## schedule:run の良く分からない点
『cron メソッドを使う場合、「schedule:run」は上手く動かないけど、「schedule:work」だと動くから、（開発段階でも）そっちを使った方が良さそう』
・・・という結論になるかと思いきや、良く分からない現象に遭遇した。  

以下のように「/x」付けて記述すると、「schedule:run」で起動可能。  
ちなみに「/x」は、min に限定されない。  

## 総括
 * Laravel のジョブスケジューリングについて、設定に柔軟性を持たせたい場合、cron メソッドが恐らく最も有用な選択肢。
 * cron メソッドに渡す内容は、crontab の設定内容そのものになるので、コンフィグでは crontab の内容を設定できるようにしておいた方が無難な気がする。
 * cron メソッドを使用した場合、schedule:run　コマンドにて強制的にジョブが起動しない。schedule:work で起動して、ジョブが稼働する時間が来るまで待て！
 * ただし、cron メソッドに引数に「'* * * * *'」を渡した場合、schedule:run で起動可。

schedule:run　コマンドでジョブが起動できないのは開発時に煩らしさを感じる点なので、強制的に動作させるオプションを作成してもいい気がする。  
具体提起には、「–for-dev」みたいなオプション引数を渡した時は cron メソッドの引数を 「'* * * * *'」 に置換するとか。  


______________________________________________________________________________
## 【Laravel】Schedule の cron メソッドを使って、バッチ起動のスケジューリングに柔軟性を持たせてみよう！
https://kaki-engine.com/laravel-schedule-cron-method/

