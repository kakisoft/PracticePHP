## コマンド
```
php artisan make:observer UserObserver --model=User


php artisan make:observer SampleObserver --model=Sample
```


## app\Observers\SampleObserver.php


## app\Providers\EventServiceProvider.php
```php
use App\Models\Sample;
use App\Observers\SampleObserver;

    public function boot()
    {
        //（中略）

        Sample::observe(SampleObserver::class);
        // \App\Models\Sample::observe(\App\Observers\SampleObserver::class);
    }
```
