```
php artisan inspire
```
__________________________________________________________________________
## Command の実装方法

 1. クロージャ―で実装
 2. Command クラスを実装

__________________________________________________________________________
## 1. クロージャ―で実装
お手軽。  
routes\console.php に実装。  
実プロダクトではあんまり使わない方が良さそう。  

##### routes\console.php
```php
Artisan::command('hello:closure', function () {
    $this->comment('Hello closure command');    // 文字列出力
})->describe('サンプルコマンド（クロージャ）');    // コマンド説明
```

##### コマンド確認
```
php artisan list

=>
 hello
  hello:closure        サンプルコマンド（クロージャ）
```

##### 使用例
```
php artisan hello:closure

=>
Hello closure command
```


Artisan::command の第一引数に、コマンド名を指定。  
Artisan::command の第二引数に、コマンド実行時に処理されるクロージャーを指定。  

Artisan::command メソッドは、\Illuminate\Foundation\Console\ClosureCommand クラスのインスタンスを返す。  
これが持つ describe メソッドでコマンドの説明を指定している。  

__________________________________________________________________________
## 2.Command クラスを実装

make:command コマンドで Command クラスの雛形を作成する

```
php artisan make:command HelloCommand
php artisan make:command sample/SampleCommand
```

##### コマンドのヘルプ（ 引数の  ）
```
php artisan <yourcommand> -h
php artisan hello:class -h
```

##### app\Console\Commands\HelloCommand.php
```php
class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:class';  // この Command クラスを実行するためのコマンド名。（ COMMAND : php artisan hello:class

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'サンプルコマンド（クラス）'; // php artisan list での説明文

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()  // Command で実行する処理
    {
        $this->comment('Hello class command');
        return 0;
    }
}
```


## コンソール
https://readouble.com/laravel/5.3/ja/artisan.html  
https://laravel.com/docs/8.x/artisan  


#### 出力レベル
設定
```php
use Symfony\Component\Console\Output\OutputInterface;


// 出力レベルを設定
$this->info('VERBOSITY_QUIET'       , OutputInterface::VERBOSITY_QUIET);         // 常に出力。
$this->info('VERBOSITY_NORMAL'      , OutputInterface::VERBOSITY_NORMAL);        // デフォルトの出力レベル。--quiet 以外で出力
$this->info('VERBOSITY_VERBOSE'     , OutputInterface::VERBOSITY_VERBOSE);       // -v, -vv, -vvv で出力
$this->info('VERBOSITY_VERY_VERBOSE', OutputInterface::VERBOSITY_VERY_VERBOSE);  // -vv, -vvv で出力
$this->info('VERBOSITY_DEBUG'       , OutputInterface::VERBOSITY_DEBUG);         // -vvv でのみ出力
```

##### vendor\symfony\console\Output\OutputInterface.php
```php
interface OutputInterface
{
    public const VERBOSITY_QUIET = 16;
    public const VERBOSITY_NORMAL = 32;
    public const VERBOSITY_VERBOSE = 64;
    public const VERBOSITY_VERY_VERBOSE = 128;
    public const VERBOSITY_DEBUG = 256;
```
__________________________________________________________________________
## URL を指定して実行（Laravel 内部から実行）

##### routes\web.php
```php
Route::get('/hello-command', function () {
    Artisan::call('hello:class');
});


Route::get('/hello-command2', function () {
    Artisan::call('hello:class2', [
        'name'     => 'kaki',
        '--switch' => false,
    ]);
});

// Kernel クラスを使う
Route::get('/hello-command-k', function (Kernel $artisan) {
    $artisan->call('hello:class');
});
```


## スケジューラから実行
[schedule_1](./64_schedule_1.md)

__________________________________________________________________________
## エラー表示
```
php artisan error
php artisan error -v
```


