# dispatch メソッド
dispatch メソッドは２種類ある？  
トレース先が複数あった。  

## vendor\laravel\framework\src\Illuminate\Foundation\Bus\Dispatchable.php
```php
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }
```


## vendor\laravel\framework\src\Illuminate\Foundation\helpers.php
```php
    function dispatch($job)
    {
        return $job instanceof Closure
                ? new PendingClosureDispatch(CallQueuedClosure::create($job))
                : new PendingDispatch($job);
    }
```



