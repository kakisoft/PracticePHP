【Laravel】Command クラスの handle メソッドにて記述されている return 0 って何？

______________________________________________________
【 環境 】
**Laravel のバージョン： 8.16.1**  
**PHP のバージョン： 7.4.7**  


コマンドを作成する時、以下のようなコマンドで雛形を作ることが出来ます。
（例：SampleCommand クラス）
```
php artisan make:command SampleCommand
```

上記のコマンドで作成されるファイルは、こんな感じ。

#### app\Console\Commands\SampleCommand.php
```php
class SampleCommand extends Command
{

// 中略

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
```

handle メソッドの「return 0;」って何なんだ？  
と思って調べてみたら、どうやら、コマンドを実行した時に帰って来る終了コードらしい。


## 終了コードって？
直前に実行したコマンド（ジョブ等）が、成功したのか失敗したのかを識別するためのコード。  

Linux の場合、以下のコマンドで確認できる。
```
echo $?
```
0 : 成功  
0以外 : 失敗（エラーコード）  

といった感じ。  

PHPユニットの実行結果の合否判定にも使えます。
```
（例）
php artisan test --testsuite=Unit

```

## handle メソッドの return
コマンドから作成する雛形を実行した時、必ず 0 が返ってくるので、常に「成功」と判断される。  

何かしらの処理を実行して、成功したか/失敗したかを判断したいなら、リターンコードを返してもいいかもしんない。  
```php
    public function handle()
    {
        $returnCode = $this->accountService->destroyLockedAccount();

        // 本当は直接返してもいいけど、説明するにはこっちが分かりやすそうだったんで。
        return $returnCode
    }
```
ちなみに return を省略した場合「0」が返る。  


コマンドラインからコマンドを実行する場合「;」で繋げて実行結果を出力するといいかもしれません。
```
php artisan command:name ; echo $?
```


## スケジューラでもリターンコードは取得できる？
調べてみたが、どうやら出来ないみたい。  

$schedule->command の戻り値は event で、コマンドの実行結果を格納されるワケではない。  
メソッドチェーンの先に実行結果のリターンコードを取得できるメソッドが無いか調べてみたが、どうやら無さそう。  

という事で、スケジューラからコマンドを実行する場合、コマンドが成功したかどうかを判断する場合、各々のメソッドで識別が必要。
```php
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $event = $schedule->command(SampleCommand::class)
                                ->everyMinute();

        dump($event->expression);  //=> "* * * * *"


        //// 本当はこんな感じで書いてみたかった
        //
        // $returnCode = $schedule->command(SampleCommand::class)
        // if($returnCode === 0){
        //     \Log::info('SampleCommand は正常に終了しました。');
        // }else{
        //     \Log::error("SampleCommand は異常終了しました。エラーコード{$SampleCommand}");
        // }

    }
```




## 終了コードの出力





```php
    public function handle()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('db:wipe');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('db:seed --class=LocalSeeder');
        Artisan::call('command:createQueue');
        return 0;
    }
```


→ 終了コードを取得して、0 が返ってきたら、「テスト成功」と見なす事ができる。
　　　→　終了コード「0」を取得できた。（下図参照）


