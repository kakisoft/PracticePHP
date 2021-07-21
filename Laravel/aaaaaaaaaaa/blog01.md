

____________________________________________________________________________________

## query() public static method
https://hotexamples.com/jp/examples/illuminate.database.eloquent/Model/query/php-model-query-method-examples.html
```
Begin querying the model.
public static query ( ) : Builder
return
```

## newQuery() public method
https://hotexamples.com/jp/examples/illuminate.database.eloquent/Model/newQuery/php-model-newquery-method-examples.html
```
Get a new query builder for the model's table.
public newQuery ( ) : Builder
return
```




## framework\src\Illuminate\Database\Eloquent\Model.php
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Database/Eloquent/Model.php#L1232
```php
    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes());
    }
```



##
https://blog.sarabande.jp/post/10539365200

> self は記述されたクラスに束縛されるのに対して、static は呼び手のクラスに束縛される。



