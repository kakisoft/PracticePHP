【Laravel】クラスを指定してコマンドを実行する方法

______________________________________________________________________________

## ソースからコマンドを実行する方法
Artisan::call メソッドにて、コマンドクラスにて定義した $signature を指定します。
```php
// コマンド名を指定
Artisan::call('command:batch01');
```

が、この方法だとコマンドの命令名を変えたい場合、grep して置換していく必要があったり、コマンドを動的に作成していたりすると影響範囲の特定が難しくなってしまうので、できるならこの指定方法は避けたい。  

例えば、スケジューラからコマンドを実行する場合、コマンド名でなく、クラスを指定する事ができる。  
```php
$schedule->command(Batch01Command::class)
            ->everyMinute()
```
コマンドクラスにて定義した $signature を指定せず、コマンドクラスそのものを引数にする方法。  

もちろん、『$schedule->command('command:batch01')』と書く事も出来るけど、クラス名を指定する方が後の修正しやすいし、変更時の影響範囲の特定も簡単なので、そっちのが好み。


## 実験
結論として、この方法で行けました。
```php
Artisan::call(Batch01Command::class);
```

マニュアルには書かれていなかったのですが、「こう書いたら行けたらいいなー（まー、どうせエラー出るだろうけど、試しに実行してみるか）」と超適当な考えで書いてみたら、特に問題なく動いてあらびっくり。

__________________________________
## 調査
さすがに「マニュアルには書かれていないけど、こう書いたら何か分からんけど動いてます。」はナシだろう。  

という事で、「何故それで動くのか」という根拠を辿ってみる。  
マニュアルに詳しく書かれていないんで、ソースコードから辿ってみよう。  

まず、「$schedule->command」から。  
### framework\src\Illuminate\Console\Scheduling\Schedule.php
```php
    /**
     * Add a new Artisan command event to the schedule.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return \Illuminate\Console\Scheduling\Event
     */
    public function command($command, array $parameters = [])
    {
        if (class_exists($command)) {
            $command = Container::getInstance()->make($command)->getName();
        }

        return $this->exec(
            Application::formatCommandString($command), $parameters
        );
    }
```
最終的に、こういった内容に到達する事ができれば「Artisan::call にてクラス名を指定可能！」と言い切れるかと思います。  

という事で、「Artisan」クラスから追っていく。  

### framework\src\Illuminate\Support\Facades\Artisan.php
```php
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

/**
 * @method static \Illuminate\Foundation\Bus\PendingDispatch queue(string $command, array $parameters = [])
 * @method static \Illuminate\Foundation\Console\ClosureCommand command(string $command, callable $callback)
 * @method static array all()
 * @method static int call(string $command, array $parameters = [], \Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static int handle(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface|null $output = null)
 * @method static string output()
 * @method static void terminate(\Symfony\Component\Console\Input\InputInterface $input, int $status)
 *
 * @see \Illuminate\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ConsoleKernelContract::class;
    }
}

```


### framework\src\Illuminate\Contracts\Console\Kernel.php
```php
interface Kernel
{
//（中略）

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null);
```

### framework\src\Illuminate\Foundation\Console\Kernel.php
```php
use Illuminate\Contracts\Console\Kernel as KernelContract;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Throwable;

class Kernel implements KernelContract
{

//（中略）

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     *
     * @throws \Symfony\Component\Console\Exception\CommandNotFoundException
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $this->bootstrap();

        return $this->getArtisan()->call($command, $parameters, $outputBuffer);
    }
```

getArtisan() から。
### framework\src\Illuminate\Foundation\Console\Kernel.php
```php
    /**
     * Get the Artisan application instance.
     *
     * @return \Illuminate\Console\Application
     */
    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Artisan($this->app, $this->events, $this->app->version()))
                                ->resolveCommands($this->commands);
        }

        return $this->artisan;
    }
```
Artisan クラスのインスタンスを返す模様。  

続いて「->call」  
### framework\src\Illuminate\Console\Application.php
```php
    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     *
     * @throws \Symfony\Component\Console\Exception\CommandNotFoundException
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        [$command, $input] = $this->parseCommand($command, $parameters);

        if (! $this->has($command)) {
            throw new CommandNotFoundException(sprintf('The command "%s" does not exist.', $command));
        }

        return $this->run(
            $input, $this->lastOutput = $outputBuffer ?: new BufferedOutput
        );
    }
```

### framework\src\Illuminate\Console\Application.php
```php
    /**
     * Parse the incoming Artisan command and its input.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return array
     */
    protected function parseCommand($command, $parameters)
    {
        if (is_subclass_of($command, SymfonyCommand::class)) {
            $callingClass = true;

            $command = $this->laravel->make($command)->getName();
        }

        if (! isset($callingClass) && empty($parameters)) {
            $command = $this->getCommandName($input = new StringInput($command));
        } else {
            array_unshift($parameters, $command);

            $input = new ArrayInput($parameters);
        }

        return [$command, $input ?? null];
    }
```

と、ここで「$schedule->command」のおさらい。
### framework\src\Illuminate\Console\Scheduling\Schedule.php
```php
    public function command($command, array $parameters = [])
    {
        if (class_exists($command)) {
            $command = Container::getInstance()->make($command)->getName();
        }
```

とてもよく似た処理に到達しました。
```php
$command = Container::getInstance()->make($command)->getName();

$command = $this->laravel->make($command)->getName();
```
あとは、「$this->laravel」が、Container クラスもしくは Container クラスのサブクラスであることを探し当てる事ができれば調査完了。  


### framework\src\Illuminate\Console\Application.php
```php
class Application extends SymfonyApplication implements ApplicationContract
{
    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $laravel;

//（中略）

    /**
     * Create a new Artisan console application.
     *
     * @param  \Illuminate\Contracts\Container\Container  $laravel
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @param  string  $version
     * @return void
     */
    public function __construct(Container $laravel, Dispatcher $events, $version)
    {
        parent::__construct('Laravel Framework', $version);

        $this->laravel = $laravel;
```

という事で、「$this->laravel」が、Container クラスという事が判明しました。  

なので、『Artisan::call にて、クラスを指定して実行可能』と言い切って問題なさそうです。  


__________________________________________________________________________________________
## おまけ１：Command クラスの getName() メソッドについて
どうやら、「コマンドの $description の内容を取って来る」という内容みたいです。  

以下、その根拠となった setName メソッド。  

### symfony\console\Command\Command.php
```php
    /**
     * Sets the name of the command.
     *
     * This method can set both the namespace and the name if
     * you separate them by a colon (:)
     *
     *     $command->setName('foo:bar');
     *
     * @return $this
     *
     * @throws InvalidArgumentException When the name is invalid
     */
    public function setName(string $name)
    {
        $this->validateName($name);

        $this->name = $name;

        return $this;
    }
```

クラス名を渡せば、  
「そのクラスがコマンドクラス（もしくはそのサブクラス）かどうかをチェックし、コマンドクラスであれば getName で $description を取得し、それを実行」  
という流れになる模様。  

という事で、挙動には全然問題ナシですね。  


## おまけ２：渡す内容が Command クラスかどうかのチェック
以下のように、書けるので、
```php
// コマンド実行：クラスを指定
Artisan::call(Batch01Command::class);
```

こんな感じでも書けます。
```php
// コマンド実行：クラスを指定（動的）
Artisan::call($targetClass);
```

ただし、引数の $targetClass がコマンドクラスでない場合、コマンド実行できずエラーが発生します。  

エラーを発生さえないようにするには、$targetClass をチェックする必要があるのですが、上記ソースで Laravel がその方法を示してくれているので、このロジックは参考にしてよさそうです。  

### 記述例
```php
use Symfony\Component\Console\Command\Command as SymfonyCommand;

//（中略）

    if (!is_subclass_of($targetCommand, SymfonyCommand::class)) {
        return;
    }

    Artisan::call($targetClass);
```

