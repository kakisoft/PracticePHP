CACHE_DRIVER=file  
にした時、デフォルトのファイルパスは以下。

framework/cache/data

____________________________________________________________________________
# conf

## .env
```
       :
CACHE_DRIVER=file
       :
       :
       :

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```


## .env.staging
```
       :
CACHE_DRIVER=redis
       :
       :
       :

REDIS_HOST=kakisofsampleapp001-stg-web-cache.8kr2iz.ng.0001.apne1.cache.amazonaws.com
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## config\cache.php
Laravel のデフォルトみたい
```php
    'default' => env('CACHE_DRIVER', 'file'),

    'stores' => [

//中略
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
//中略

        // ここの内容は、正直良く分かってない。
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],
```

## config\database.php
```php
    'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],
```

_________________________________________________________________________________
## routes\web.php
```php
use Illuminate\Support\Facades\Cache;

//============================================================================================
//                                       Cache
//============================================================================================
// http://localhost:8000/cache/put
Route::get('/cache/put', function () {
    echo "put";
    Cache::put('key01', 'value01');
});

// http://localhost:8000/cache/remember
Route::get('/cache/remember', function () {
    echo "remember";

    $cache = \Cache::remember('key02', 10, function(){
        return "value02_remember";
    });

    dump($cache);
});

// http://localhost:8000/cache/get
Route::get('/cache/get', function () {
    echo "get";

    $cache01 = Cache::get('key01');
    $cache02 = Cache::get('key02');

    dump($cache01);
    dump($cache02);
});

// http://localhost:8000/cache/forget
Route::get('/cache/forget', function () {
    echo "forget";

    Cache::forget('key01');
    Cache::forget('key02');
});
```