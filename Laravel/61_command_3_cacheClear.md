
```php
    public function handle()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('db:wipe');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('db:seed --class=LocalSeeder');
        Artisan::call('command:createQueue');
        return 0;
    }
```



