【Laravel】クラスを指定してコマンドを実行する方法

______________________________________________________________________________

## コマンドを実行する方法

```php
// コマンド名を指定
Artisan::call('command:batch01');
```


スケジューラからコマンドを実行する場合、コマンド名でなく、クラスを指定する事ができます。
```php
$schedule->command(Batch01Command::class)
            ->everyMinute()
```
コマンドそのものを


```php
$schedule->command('command:batch01')
                ->everyThirtyMinutes()
```


この方法で行けた。
```php
Artisan::call(Batch01Command::class);
```



__________________________________


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


### framework\src\Illuminate\Support\Facades\Artisan.php
```php
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


