## official : Events
https://laravel.com/docs/8.x/events#generating-events-and-listeners  


公式サイトを参考に書いてみた。  
が、イベントの登録辺りから良く分かんない。


________________________________________________________________________________________________
## 生成コマンドF
```
php artisan make:event PodcastProcessed

php artisan make:listener SendPodcastNotification --event=PodcastProcessed
```
以下のように、階層が分かれてくれる。  
EventServiceProvider を使うよりも、こっちの方がいい気がする。  

 * app\Events\PodcastProcessed.php
 * app\Listeners\SendPodcastNotification.php

今は、こっちが主流？  


## Manually Registering Events
Typically, events should be registered via the EventServiceProvider $listen array; however, you may also register class or closure based event listeners manually in the boot method of your EventServiceProvider:

#### app\Providers\EventServiceProvider.php
```php
use App\Events\PodcastProcessed;
use App\Listeners\SendPodcastNotification;
use Illuminate\Support\Facades\Event;

use function Illuminate\Events\queueable;

/**
 * Register any other events for your application.
 *
 * @return void
 */
public function boot()
{
    Event::listen(
        PodcastProcessed::class,
        [SendPodcastNotification::class, 'handle']
    );

    Event::listen(function (PodcastProcessed $event) {
        //
    });

    //-----------------------------------------------
    //     Queueable Anonymous Event Listeners
    //-----------------------------------------------
    Event::listen(queueable(function (PodcastProcessed $event) {
        //
    }));

}
```

________________________________________________________________________________________________

これは「EventServiceProvider.php」に書けばいいのか？  
```php
Event::listen(queueable(function (PodcastProcessed $event) {
    //
})->onConnection('redis')->onQueue('podcasts')->delay(now()->addSeconds(10)));
```
キューにジョブが送られた事を検知して発生するイベント、という意味だろうか。



