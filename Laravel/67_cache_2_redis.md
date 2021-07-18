Redis のデータの保存先。  

data\redis\dump.rdb

_________________________________________________________
# 設定

## PhpRedis をインストール
```
pecl install redis
```

## docker-compose.yml
```yaml
  redis:
    image: "redis:6.0"
    restart: always
    ports:
      - "6379:6379"
    volumes:
      - "./data/redis:/data"
```

## .env
```
　　　：
CACHE_DRIVER=redis
　　　：
　　　：
　　　：

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## config\cache.php
file → redis
```php
    'default' => env('CACHE_DRIVER', 'redis'),

    'stores' => [
//中略

        // ここの内容は、正直良く分かってない。
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],
```

## config\database.php
phpredis。（以下、Laravel デフォルト設定）
```php
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],
```

## キャッシュをクリア
```
php artisan config:clear
php artisan config:cache
```

__________________________________________________________1_______________________
# サンプルソース

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


__________________________________________________________1_______________________
## troubleshoot
ある日、何をやってもブラウザに「500 エラー」としか出なくなってて、laravel.log を見たら、こんなの出てた。  

```
local.ERROR: Please make sure the PHP Redis extension is installed and enabled. 
{"exception":"[object] (LogicException(code: 0): Please make sure the PHP Redis extension is installed and enabled. 
at /var/www/html/my-laravel-app/vendor/laravel/framework/src/Illuminate/Redis/Connectors/PhpRedisConnector.php:77)
```

あれ？　特に何も触ってないのに？  
と思いきや、.env を弄ってて、環境設定ファイルが読み込みエラーになってたのが原因だった。  

それ以外の全てのエラーを優先して前面に出て来るとは、なかなか主張が強いな・・  


