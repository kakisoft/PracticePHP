## app\Providers\EventServiceProvider.php
```php
    protected $listen = [
        // 'Eventクラス' => [
        //     'Eventクラスに対応した Listner クラス',
        // ],


        // ↓のように書くと、「Events」「Listeners」の階層にファイルが作成される。
        'App\Events\AccessDetection' => [
            'App\Listeners\AccessDetectionListener',
        ]
    ];
```

## コマンド実行
```
php artisan event:generate
```

## app\Events\AccessDetection.php
```php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccessDetection
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $param;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }
    public function __construct($value)
    {
        $this->param = $value;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
```


## app\Listeners\AccessDetectionListener.php
```php
namespace App\Listeners;

use App\Events\AccessDetection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AccessDetectionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessDetection  $event
     * @return void
     */
    public function handle(AccessDetection $event)
    {
        dump('Access Detected param=' . $event->param);
    }
}
```


## routes\api.php
```php
//================================================================
//
//================================================================
// http://localhost:8000/api/event01
Route::get('event01', function(){
    event(new AccessDetection(str_random(10)));
    return 'hoge';
});
```

## dump-server 起動
```
php artisan dump-server
```


