【Laravel】Schedule の onOneServer って、どんな動きをしているの？


________________________________________________________________________________

## Laravel スケジューラの onOneServer って？
Laravel の Task Scheduling には、「onOneServer」というメソッドがあります。  

スケジューラを実行しているサーバが複数あった場合、あるサーバが既に実行していると、その他のサーバは実行しないようにする仕組みです。  

コードで書くと、こんな感じ。（公式サンプル）  
```php
$schedule->command('report:generate')
                ->fridays()
                ->at('17:00')
                ->onOneServer();
```

自前で書いたのは、こんな感じ。
```php
    private function scheduleExecuteCommand05(Schedule $schedule)
    {
        $schedule->command(Batch05Command::class)
            ->everyMinute()
            ->onOneServer()
            ->runInBackground()
            ->withoutOverlapping();
    }
```


https://laravel.com/docs/8.x/scheduling#running-tasks-on-one-server

> To utilize this feature, your application must be using the database, memcached, dynamodb, or redis cache driver as your application's default cache driver. In addition, all servers must be communicating with the same central cache server.

キャッシュドライバに、memcached, dynamodb, redis を使っていないとダメらしい。  

こういう事か？  

### config\cache.php
```php
    'default' => env('CACHE_DRIVER', 'redis'),
```

考えてみたら当たり前か。  
サーバが複数立ち上がっていて、それらが共通して参照できるリソースが無いと、サーバ間のマルチ実行重複チェックなんて出来ないだろうし。  

かといって、実験するのもリソース集めるのが面倒だな。  
何とか疑似的にそういう状況を作れないものかと Laravel ソースを読んでみた。  

ログ仕込んだりして実験するには、GitHub 上のソースから読むより、vendor フォルダ以下のソースを読んだ方が解析しやすいかと思います。  
ファイルで言うと、だいたい以下のような場所。  

vendor\laravel\framework\src\Illuminate\Console\Scheduling\Event.php  
vendor\laravel\framework\src\Illuminate\Console\Scheduling\CallbackEvent.php  

onOneServer メソッド、こんな感じ。  

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\Event.php
```php
    /**
     * Allow the event to only run on one server for each cron expression.
     *
     * @return $this
     */
    public function onOneServer()
    {
        $this->onOneServer = true;

        return $this;
    }
```

onOneServer() メソッドがやっている事は、プライベート変数を書き換えるだけど、超シンプルな処理。  

「$this->onOneServer」は、どこで使われているの？  
と思って調べたら、こんな感じだった。  

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\ScheduleRunCommand.php
```php
    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
     * @param  \Illuminate\Contracts\Debug\ExceptionHandler  $handler
     * @return void
     */
    public function handle(Schedule $schedule, Dispatcher $dispatcher, ExceptionHandler $handler)
    {
        $this->schedule = $schedule;
        $this->dispatcher = $dispatcher;
        $this->handler = $handler;

        foreach ($this->schedule->dueEvents($this->laravel) as $event) {
            if (! $event->filtersPass($this->laravel)) {
                $this->dispatcher->dispatch(new ScheduledTaskSkipped($event));

                continue;
            }

            if ($event->onOneServer) {
                $this->runSingleServerEvent($event);
            } else {
                $this->runEvent($event);
            }

            $this->eventsRan = true;
        }

        if (! $this->eventsRan) {
            $this->info('No scheduled commands are ready to run.');
        }
    }
```

 * ->onOneServer() を付けた場合、runSingleServerEvent を実行
 * ->onOneServer() を付けなかった場合、runEvent を実行

runSingleServerEvent は以下。  

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\ScheduleRunCommand.php
```php
    /**
     * Run the given single server event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @return void
     */
    protected function runSingleServerEvent($event)
    {
        if ($this->schedule->serverShouldRun($event, $this->startedAt)) {
            $this->runEvent($event);
        } else {
            $this->line('<info>Skipping command (has already run on another server):</info> '.$event->getSummaryForDisplay());
        }
    }
```

ここで runEvent と合流しています。  

続いて serverShouldRun 行ってみよう。  

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\Schedule.php
```php
class Schedule
{

//（中略）

    /**
     * Determine if the server is allowed to run this event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @param  \DateTimeInterface  $time
     * @return bool
     */
    public function serverShouldRun(Event $event, DateTimeInterface $time)
    {
        return $this->schedulingMutex->create($event, $time);
    }
```

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\SchedulingMutex.php
```php
interface SchedulingMutex
{
    /**
     * Attempt to obtain a scheduling mutex for the given event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @param  \DateTimeInterface  $time
     * @return bool
     */
    public function create(Event $event, DateTimeInterface $time);
```

インターフェースに行きついてしまったので、次は SchedulingMutex を implement したクラスでしょうか。

### vendor\laravel\framework\src\Illuminate\Console\Scheduling\CacheSchedulingMutex.php
```php
class CacheSchedulingMutex implements SchedulingMutex, CacheAware
{

//（中略）

    /**
     * Attempt to obtain a scheduling mutex for the given event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @param  \DateTimeInterface  $time
     * @return bool
     */
    public function create(Event $event, DateTimeInterface $time)
    {
        return $this->cache->store($this->store)->add(
            $event->mutexName().$time->format('Hi'), true, 3600
        );
    }
```

キャッシュに何かをブッ込んでるみたい。  

と言う事は、「'default' => env('CACHE_DRIVER', 'file'),」という設定だったとしても、それが外部から読み取る方法が無いから他のサーバで実行される可能性がある、という話で、キャッシュへの書き込み処理については、コンフィグによって差は無い、と解釈できそう。  

それなら、キャッシュの保存先を DB にしておけば、ロックのために放り込んだデータをトレースできるのでは？


## キャッシュドライバを database に変えて実験
ジョブを実行すると、こんなレコードが生成されました。  

select * from cache  

|  key                                         |  value  |  expiration  |
|:---------------------------------------------|:--------|:-------------|
|  laravel_cacheframework/schedule-5c2c3b      |  b:1;   |  1627114042  |
|  laravel_cacheframework/schedule-5c2c3b0806  |  b:1;   |  1627031180  |
|  laravel_cacheframework/schedule-5c2c3b0807  |  b:1;   |  1627031241  |

※key の乱数部分は長いので一部カットしています  


ジョブの開始・終了でレコード数が増減したので、「キーと値がキャッシュドライバに存在するか」という事を判断材料にしていると思われます。  

この値をブッキングさせる事ができれば、疑似的に『他のサーバで実行中です』という状態を作り出せるのでは？  
と思ったが、疲れたのでこれ以降はまた後日。  



