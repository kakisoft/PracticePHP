【Laravel】Artisan::call でコマンドを実行した時の挙動は非同期？重複実行あり？

______________________________________________________________________________

## Artisan::call の挙動について
Artisan::call でコマンドを実行できますが、これらがどんな挙動をするのか確認してみました。

### 呼び出すコマンド
```php
class SampleCommand extends Command
{

//（中略）

    public function handle()
    {
        Artisan::call(Batch01Command::class);
        Artisan::call(Batch02Command::class);
        Artisan::call(Batch03Command::class);
    }
```

### Batch01Command, Batch02Command, Batch02Command の handle メソッド
全て共通。  
20秒おきにログを出力します。  
```php
    public function handle()
    {
        $this->info(__METHOD__);
        \Log::info(__METHOD__);

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 20 second');
        \Log::info(__METHOD__. ': after 20 second');

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 40 second');
        \Log::info(__METHOD__. ': after 40 second');

        // 20 秒間遅延させる
        sleep(10);

        $this->info(__METHOD__ . ': after 60 second');
        \Log::info(__METHOD__. ': after 60 second');
    }
```

### laravel.log
```log
[2021-08-14 06:00:57] local.INFO: App\Console\Commands\Batch01Command::handle  
[2021-08-14 06:01:07] local.INFO: App\Console\Commands\Batch01Command::handle: after 20 second  
[2021-08-14 06:01:17] local.INFO: App\Console\Commands\Batch01Command::handle: after 40 second  
[2021-08-14 06:01:27] local.INFO: App\Console\Commands\Batch01Command::handle: after 60 second  
[2021-08-14 06:01:27] local.INFO: App\Console\Commands\Batch02Command::handle  
[2021-08-14 06:01:37] local.INFO: App\Console\Commands\Batch02Command::handle: after 20 second  
[2021-08-14 06:01:47] local.INFO: App\Console\Commands\Batch02Command::handle: after 40 second  
[2021-08-14 06:01:57] local.INFO: App\Console\Commands\Batch02Command::handle: after 60 second  
[2021-08-14 06:01:57] local.INFO: App\Console\Commands\Batch03Command::handle  
[2021-08-14 06:02:07] local.INFO: App\Console\Commands\Batch03Command::handle: after 20 second  
[2021-08-14 06:02:17] local.INFO: App\Console\Commands\Batch03Command::handle: after 40 second  
[2021-08-14 06:02:27] local.INFO: App\Console\Commands\Batch03Command::handle: after 60 second  
```

Batch01Command 開始 → Batch01Command 終了 → Batch02Command 開始 → Batch02Command 終了 → ...  

と、順番に実行するようです。  


## 実行オプションは？
Schedule から起動する時は、withoutOverlapping や runInBackground といった豊富なオプションが指定できますが、Artisan::call では出来ないようです。  

理由としては、「$schedule->command」の戻り値は Event クラスだけど、Artisan::call の戻り値は $exitCode となっているのが原因。  


## $schedule->command の戻り値

### framework\src\Illuminate\Console\Scheduling\Schedule.php
```php
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
```php
    public function exec($command, array $parameters = [])
    {
        if (count($parameters)) {
            $command .= ' '.$this->compileParameters($parameters);
        }

        $this->events[] = $event = new Event($this->eventMutex, $command, $this->timezone);

        return $event;
    }
```


## Artisan::call の戻り値

### framework\src\Illuminate\Console\Application.php
```php
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
```php
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $commandName = $this->getCommandName(
            $input = $input ?: new ArgvInput
        );

        $this->events->dispatch(
            new CommandStarting(
                $commandName, $input, $output = $output ?: new BufferedConsoleOutput
            )
        );

        $exitCode = parent::run($input, $output);

        $this->events->dispatch(
            new CommandFinished($commandName, $input, $output, $exitCode)
        );

        return $exitCode;
    }
```

## 非同期で実行するには？
まずはこれで無事に実行できました。
```php
event(Artisan::call(Batch01Command::class));
```

が、戻り値が Event 型ではないため、withoutOverlapping 等のメソッドを使用できません。  
というか、そういう制御をしたいなら、ShouldQueue が居るんじゃねーのか。  

「new Event()」見たいな感じで Event クラスのインスタンスを生成して・・・という事をやろうとしたが、要求される第一引数が EventMutex 型（排他制御）と、何やら無暗に触らない方が良さそうな物だったので、変な迂回路を探すのは止めといたよさそう。  

という事で、こういう事をしたいなら、イベントとリスナーを使う。  

場合によってはスケジューラで回した方が簡単か。  

