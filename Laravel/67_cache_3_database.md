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

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
