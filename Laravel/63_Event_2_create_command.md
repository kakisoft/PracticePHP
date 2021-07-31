## 作成方法

## 最終結論：イベント・リスナーを個別に作成

### コマンド
「--event」オプションにて、対応するイベントを追加
```
php artisan make:event App\\Events\\MyEvent03
php artisan make:listener MyListener03 --event MyEvent03
```

### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        \App\Events\MyEvent03::class => [
            \App\Listeners\MyListener03::class
        ],

    ];
```

「php artisan event:list」コマンドは案外アテにならない。  
設定ミスした内容でも、存在しないクラスを書いても、リスト上に出てきてしまう。  

_______________________________________________________________________________________________
### 方法１．EventServiceProvider.php を編集し、「event:generate」コマンドで追加。  
【※こっちの方法は、もう主流ではないっぽい。】  

以前は、EventServiceProvider にて集中管理していたらしい。  

「protected $listen」に、コードを追加
#### app\Providers\EventServiceProvider.php
```php
    protected $listen = [
        // 'Eventクラス' => [
        //     'Eventクラスに対応した Listener クラス',
        // ],

        // Registered::class, SendEmailVerificationNotification::class は、Laravel 標準の user に紐づいたクラス？  
        // 対応するファイルが自動生成されなかった。  
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // ↓のように階層を指定しない場合、「Providers」フォルダに生成される。
        PublishProcessor::class => [   // app\Providers\PublishProcessor.php
            MessageSubscriber::class   // app\Providers\MessageSubscriber.php
        ],
        ReviewRegistered::class => [   // app\Providers\ReviewRegistered.php
            ReviewIndexCreator::class  // app\Providers\ReviewIndexCreator.php
        ],

        // ↓のように書くと、「Events」「Listeners」の階層にファイルが作成される。
        'App\Events\AccessDetection' => [
            'App\Listeners\AccessDetectionListener',
        ]
    ];
```
Registered::class, SendEmailVerificationNotification::class は、Laravel 標準の user に紐づいたクラス？  
対応するファイルが自動生成されなかった。  


#### ※リスナー検知(Event Discovery)
https://reffect.co.jp/laravel/laravel-event-listener  
Laravelのバージョン5.8.9以降ではEventServiceProvider.phpでイベントとリスナーの関連付けを行わなくても自動でリスナーを見つけてくれる機能が追加されました。  
 ⇒ 以前は、リスナーを登録する時には必須だった？  

#### コマンド
```
php artisan event:generate
```

 * app\Providers\MessageSubscriber.php
 * app\Providers\PublishProcessor.php
 * app\Providers\ReviewIndexCreator.php
 * app\Providers\ReviewRegistered.php


#### my-laravel-app\app\Providers\MessageSubscriber.php
```php
namespace App\Providers;

use App\Providers\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSubscriber
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
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        //
    }
}
```


#### app\Providers\PublishProcessor.php
```php
namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublishProcessor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
}
```


#### app\Providers\ReviewIndexCreator.php
```php
namespace App\Providers;

use App\Providers\ReviewRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReviewIndexCreator
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
     * @param  ReviewRegistered  $event
     * @return void
     */
    public function handle(ReviewRegistered $event)
    {
        //
    }
}
```

#### app\Providers\ReviewRegistered.php
```php
namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
}
```

_______________________________________________________________________________________________
### 方法２．「make:event」コマンドで追加。
※　App\Events\　フォルダに格納するようにした方がよいのでは？  

```
php artisan make:event App\\CustomNamespace\\PublishProcessor
```

#### app\CustomNamespce\PublishProcessor.php
ファイルが自動生成される。
```php
namespace App\CustomNamespace;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublishProcessor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
}
```

## イベントリスナーのひな形の生成
```
php artisan make:listener MessageSubscriber --event PublishProcessor
```

#### app\Listeners\MessageSubscriber.php
```php
namespace App\Listeners;

use App\Events\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSubscriber
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
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        //
    }
}
```
