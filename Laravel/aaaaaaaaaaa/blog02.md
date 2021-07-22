

____________________________________________________________________________________


## Command クラスの handle メソッドの戻り値の意味
以前、こんなの書きました。  
[Laravel：Command クラスの handle メソッドに記述されている return 0 って何？](https://www.kakistamp.com/entry/2021/07/17/002438)  

##### コード例
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
        return 0;  //← これは一体何？
    }
}
```

概要をまとめると、こんな感じ。

 * Command クラスの handle() メソッドの戻り値は、「終了コード」
 * 終了コードは、「0 : 成功」「0以外 : 失敗（エラーコード）」（別に Laravel に限らず、システム全般に適用できる）
 * Linux の場合、「 echo $? 」コマンドで出力できる。
 * return を省略した場合、0 が返る
 * この値で、コマンドが成功したか失敗したかを判別できるようにしておいた方が、障害が発生した時の手掛かりにしやすそう


コマンドラインから叩く場合、「;」で繋げると良さげ。
```
php artisan command:name ; echo $?
```


## スケジューラでもリターンコードはできる？
結論としては、出来ませんでした。  
（詳細は冒頭で紹介したブログを参照）  

が、Schedule クラスには onSuccess メソッドと onFailure メソッドがあり、これを使えば成功したかどうかを検出できるのでは？  

と思ったので実験。

## onSuccess と onFailure
Kernel クラスは、こんな感じ。  

### Console\Kernel.php
```php
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleExecuteCommand01($schedule);
        $this->scheduleExecuteCommand02($schedule);
        $this->scheduleExecuteCommand03($schedule);
    }

    private function scheduleExecuteCommand01(Schedule $schedule)
    {
        $schedule->command(Batch01Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Batch01Command was successful.');
            })
            ->onFailure(function () {
                \Log::info('Batch01Command failed.');
            });
    }

    private function scheduleExecuteCommand02(Schedule $schedule)
    {
        $schedule->command(Batch02Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Batch02Command was successful.');
            })
            ->onFailure(function () {
                \Log::info('Batch02Command failed.');
            });
    }

    private function scheduleExecuteCommand03(Schedule $schedule)
    {
        $schedule->command(Batch03Command::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Batch03Command was successful.');
            })
            ->onFailure(function () {
                \Log::info('Batch03Command failed.');
            });
    }
```

Batch01Command は 0 を返し、  
Batch02Command は 0 以外の値を返すようにする。  

### app\Console\Commands\Batch01Command.php
```php
    public function handle()
    {
        return 0;
    }
```


### app\Console\Commands\Batch02Command.php
```php
    public function handle()
    {
        return 1;
    }
```


### app\Console\Commands\Batch03Command.php
```php
    public function handle()
    {
        // 戻り値を指定しない
    }
```


以下のような結果になりました。

### storage\logs\laravel.log
```log
[2021-07-22 13:30:17] Batch01Command was successful.  
[2021-07-22 13:30:17] Batch02Command failed.  
[2021-07-22 13:30:21] Batch03Command was successful.  
```

Batch01Command、Batch02Command は、バッチリ意図通りです。  
そして、return を省略すると 0 が返るので、Batch03Command も予想通り。  

という訳で、コマンドのリターンコードを受け取って判別、という事はできないですが、onSuccess メソッドと onFailure メソッドを使って、コマンドが成功したか失敗したかを判別できそうです。  


## どこまでエラーを識別してくれる？
戻り値を指定しなかった場合は 0 が返るのですが、メソッド内で明らかなエラーが起こった時も 0 を返すの？  

と思い、以下のようなコードで実験。  


### Console\Kernel.php
```php
    private function scheduleExecuteCommand04(Schedule $schedule)
    {
        $schedule->command(Batch04Command::class, [0])
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Batch04Command was successful.');
            })
            ->onFailure(function () {
                \Log::info('Batch04Command failed.');
            });
    }
```


### app\Console\Commands\Batch04Command.php
```php
    public function handle()
    {
        $param1 = $this->argument('param1');

        $val1 = 10 / $param1;

        \Log::info($param1);
        \Log::info($val1);
    }
```

### やってる事

 * コマンド実行時に、コマンドライン引数として「 0 」という値を渡している
 * 引数として受け取った値（ 0 ）で割る（ゼロ割をする）。Try catch による捕捉をしない。

以下のような結果になりました。

### storage\logs\laravel.log
```log
[2021-07-22 13:44:43] local.ERROR: Division by zero {"exception":"[object] (ErrorException(code: 0): Division by zero at /var/www/html/my-laravel-app/app/Console/Commands/Batch01Command.php:42)
[stacktrace]
#0 /var/www/html/my-laravel-app/app/Console/Commands/Batch01Command.php(42): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, 'Division by zer...', '/var/www/html/m...', 42, Array)
#1 /var/www/html/my-laravel-app/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Console\\Commands\\Batch01Command->handle()

（中略）

[2021-07-22 13:44:49] local.INFO: Batch01Command failed.  
```

ゼロ割によるエラーが出力されています。  

そして、onFailure に分岐したようで、「Batch01Command failed」を出力し、しっかりとエラー扱いにしてくれています。  

コマンドの場合はどうなるの？  
省略した場合は 0 が返るから、正常終了と見なされるの？  
と、気になったので調べてみた。
```
php artisan command:batch04 0 ; echo $?
```

結果、こんな感じ。
```
   ErrorException 

  Division by zero


（中略）

  15  artisan:37
      Illuminate\Foundation\Console\Kernel::handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
1
```
ノイズが混ざって見づらくなってるけど、「1」が返ってきています。  

また、ゼロ割が発生しないようにコマンドを叩いたら、「0」が返ってきました。
```
> php artisan command:batch04 1 ; echo $?
> 0
```

省略時は 0 が返って来るようですが、明らかなエラーが発生した場合は 0以外の値が返って来るようです。  

しかし、  
「PHPの処理としては正常に終了しているけど、レコードがちゃんと更新されていない（本当はレコードが更新されているけど、更新件数が 0件）」  
といった処理は異常終了として


