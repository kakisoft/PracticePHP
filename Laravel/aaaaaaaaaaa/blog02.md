Laravel スケジューラによるバッチ起動に柔軟性を持たせたい：cron 編

__________________________________________________________________________________________
**【環境】**  
Laravel のバージョン： 8.16.1  
PHP のバージョン： 7.4.7  

前回の続き。  

Laravel にて、スケジューラを使用してバッチを起動する場合、「->everyMinute()」「->everyTenMinutes()」といったメソッドが用意されているが、「コンフィグで　5分間隔/10分間隔といった設定を、柔軟に切り替えができるようにしたい。」といった事をやりたい場合、これらの固定化されたメソッド使って実現するのはちょっと厳しい。  

ただ、「cron」というメソッドが用意されているので、これを使えば柔軟に対応できるのでは？  
と考え、実験してみた。  

## 公式サイトからの参照
https://laravel.com/docs/8.x/scheduling


|  Method                           |  Description                                              |
|:----------------------------------|:----------------------------------------------------------|
|  ->cron('* * * * *');             |  Run the task on a custom cron schedule                   |


## Laravel にて cron を使用する時の大きな謎
上記のように、Laravel 側で親切なメソッドを用意しているにもかかわらず、Laravel で cron を使ったジョブスケジューラについて調べていると、ほとんど全部といっていい内容が OS上で cron を起動させて、そのたびに「artisan schedule:run」を回すというやり方。  
何でやねん。  
つーか面倒くせえ。  

cron メソッドを使う方法は、あまりメジャーではないのか？  
それとも、使う事により大きな問題でもあるのか・・？

でも、やりたいことが「起動する時間を、コンフィグで柔軟に設定できるようにしたい」という事なので、Laravel の外に起動トリガーを置いてしまうと、設定内容をフレームワークの外に置く事になるので、それは避けたい。  

という事で cron メソッドを使って実験してみる。  


## スケジューリングされた内容を確認する方法
スケジューリングされた内容は、$schedule を受けて、expression メソッドを使用すると、cron 形式で確認可能です。
```php
    protected function schedule(Schedule $schedule)
    {
        $event01 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->everyMinute();
        dump($event01->expression);  //=> "* * * * *"

        $event02 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->hourly();
        dump($event02->expression);  //=> "0 * * * *"
    }
```

## schedule:run でバッチを起動
cron メソッドに渡す内容を動的にしてみるも、どうも上手く動かない。  

という事で、試しに以下のように渡す値をベタ書きにして実験。
```php
    protected function schedule(Schedule $schedule)
    {
        $event04 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron('1 * * * *');
        dump($event04->expression);  //=> "1 * * * *"
    }
```

「php artisan schedule:run」で起動させてみると、以下のメッセージが表示される。  
```
No scheduled commands are ready to run.
```

ちなみに、cron の引数を「'* * * * *'」にした場合は正常に稼働する。  
min の部分のみでなく、「*」のどれを変えても結果は同一だった。  

もちろん、バッチが起動した形跡は無し。  


## schedule:work でバッチを起動してみる
上記の「schedule:run」コマンドは、スケジューリングが「everyMinute()」であろうと「hourly()」であろうと、コマンドを打った瞬間に実行してくれるコマンド。  

常駐させて実行するには「schedule:work」コマンドを使うので、今度はそれで実験。  

・・・結果、正常にバッチが起動できました。   

以下のように、cron に渡す値を動的にしても、正常に稼働しました。  
```php
    protected function schedule(Schedule $schedule)
    {
        $JOB06_CONF = '21 * * * *';

        $event05 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB06_CONF);
        dump($event05->expression);  //=> "21 * * * *"


        //==============================================================

        $JOB06_CONF = '*/1 * * * *';

        $event06 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB06_CONF);
        dump($event06->expression);  //=> "*/1 * * * *"
    }
```


## schedule:run の良く分からない点
『cron メソッドを使う場合、「schedule:run」は上手く動かないけど、「schedule:work」だと動くから、（開発段階でも）そっちを使った方が良さそう』  
・・・という結論になるかと思いきや、良く分からない現象に遭遇した。  


以下のように「/x」付けて記述すると、「schedule:run」で起動可能。  
ちなみに「/x」は、min に限定されない。  
```php
    protected function schedule(Schedule $schedule)
    {
        $JOB06_CONF = '*/1 * * * *';

        $event06 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB06_CONF);
        dump($event06->expression);  //=> "*/1 * * * *"
    }
```


## schedule:run の挙動を、さらに調査
以下のコードにて、「schedule:run」を実行してみた。
```php
    protected function schedule(Schedule $schedule)
    {
        $JOB07_CONF = '50 * * * *';

        $event07 = $schedule->command(HelloCommand::class)->description('Hello command Scheduler')->cron($JOB07_CONF);
    }
```

どうやら、**稼働する時間によって、実行結果が変わる**模様。  

上記では「毎時 50分」に起動するようになっている。  
6:49, 6:50 といった、設定された時間に極めて近い時間帯に実行すると正常に稼働し、それ以外の時間帯に実行すると「No scheduled commands are ready to run.」というメッセージが出て稼働できなかった。  

「schedule:run」コマンドは、メソッドで定義されたスケジュールが「->hourly()」だろうと、コマンドを叩くと即時に実行してくれる強制力があるのだが、cron メソッドに限り、その力は働かない模様。  

なので、他のスケジューリングメソッドと同じ感覚では使う事が出来ない。  
「schedule:work を使えば、schedule:run　は、開発時以外は使わずに済むのでは？」と思っていたが、cron でスケジュールを回して schedule:run コマンド叩いているやり方も結構見かけたので、そういう使い方は NG。  
という事は念頭に入れておいた方が良さそう。  


## cron メソッドについて、もう少し実験
cron メソッドの引数を自由に設定できるので、こんな感じで複数ジョブを作成可。  
以下の例はちょっと乱暴だけど、「1分おきの時間差で、特定のバッチを起動」みたいな使い方ができそうな気がする。  
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

## 総括

 * Laravel のジョブスケジューリングについて、設定に柔軟性を持たせたい場合、cron メソッドが恐らく最も有用な選択肢。
 * cron メソッドに渡す内容は、crontab の設定内容そのものになるので、コンフィグでは crontab の内容を設定できるようにしておいた方が無難な気がする。
 * cron メソッドを使用した場合、schedule:run　コマンドにて強制的にジョブが起動しない。schedule:work で起動して、ジョブが稼働する時間が来るまで待て！
 * ただし、cron メソッドに引数に「'* * * * *'」を渡した場合、schedule:run で起動可。

schedule:run　コマンドでジョブが起動できないのは開発時に煩らしさを感じる点なので、強制的に動作させるオプションを作成してもいい気がする。  
具体提起には、「--for-dev」みたいなオプション引数を渡した時は cron メソッドの引数を 「'* * * * *'」 に置換するとか。  

