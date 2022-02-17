## Delete の場合
delete でインデックスを指定する場合、USING 句が必要らしい。  
具体的には、こんな感じになる。  
```sql
delete from items USING items FORCE INDEX ( items_index_1 ) 
 where owner_id = 1
```
先頭に explain を付けて実行すると、「items_index_1」が使われている事が確認できる。  

＜参考＞  
[オプティマイザヒントでDELETEステートメントに使わせるインデックスを強制する(MySQL 8.0から)](https://yoku0825.blogspot.com/2021/05/deletemysql-80.html)  
[MySQL :: MySQL 8.0 Reference Manual :: 8.9.3 Optimizer Hints](https://dev.mysql.com/doc/refman/8.0/en/optimizer-hints.html)  



## 追記：Elquent Model を使う場合
from メソッドにて DB::raw を使う事ができるみたい。
```php
    public function pruebaMethod01()
    {
        $ownerId = 1;

        $this->model = app()->make(Item::class);

        return $this->model
            ->from(DB::raw('items USING items FORCE INDEX ( items_index_1 )'))
            ->withTrashed()
            ->where('owner_id', $ownerId)
            ->forceDelete();
    }
```

