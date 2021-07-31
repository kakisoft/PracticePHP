## artisan コマンドで雛形を作成
Listener には、Event を指定。
```
php artisan make:event App\\Events\\MyEvent04
php artisan make:listener MyListener04 --event MyEvent04
```

## イベントとリスナーを登録。

### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        \App\Events\MyEvent04::class => [
            \App\Listeners\MyListener04::class
        ],

    ];
```

### app/Events/MyEvent04.php
```php
class MyEvent04
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

//（中略）

    public function myMethod02($arg1)
    {
        \Log::info($arg1);
        \Log::info(__METHOD__);
        return;
    }
}
```

### app/Listeners/MyListener04.php
「implements ShouldQueue」を追加。
```php
class MyListener04 implements ShouldQueue
{

//（中略）

    public function handle(MyEvent04 $event)
    {
        $event->myMethod02("arg1");
    }
}
```

### routes\api.php
```php
// http://localhost:8000/api/my-event04
Route::get('my-event04', function(){
    \App\Events\MyEvent04::dispatch();
    return 'my-event04';
});
```

