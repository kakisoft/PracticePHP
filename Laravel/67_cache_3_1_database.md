## 公式
https://www.oulub.com/docs/laravel/ja-jp/cache

```
構成
    ドライバーの前提条件

（中略）

アトミックロック
    ドライバーの前提条件 
```

通常の使用と、アトミックロック用で、テーブルを分ける必要がある？

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
https://blog.capilano-fw.com/?p=1344


php artisan make:migration create_cache_table

```php
    public function up()
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
        });
    }
```


php artisan migrate


------
cache
cache_locks


### .env
```
CACHE_DRIVER=database
```

### config/cache.php
```php
'database' => [
    'driver' => 'database',
    'table' => 'cache',
    'connection' => null,
],
```

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
## アトミックロック
https://www.oulub.com/docs/laravel/ja-jp/cache#lock-driver-prerequisites
ドライバーの前提条件
データベース

databaseキャッシュドライバーを使用する場合、キャッシュロックを含むテーブルを設定する必要があります。次の表のSchema宣言の例を示します。

```php
Schema::create('cache_locks', function ($table) {
    $table->string('key')->primary();
    $table->string('owner');
    $table->integer('expiration');
});
```
