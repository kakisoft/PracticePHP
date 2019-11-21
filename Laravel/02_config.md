# コンフィグ

## .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

　 ↓

DB_CONNECTION=sqlite

※注意※
余計なものを消しておかないと、 
Illuminate\Database\QueryException  : Database (homestead) does not exist. (SQL: PRAGMA foreign_keys = ON;)
といったエラーが発生する。
```


## config/app.php
```
'timezone' => 'UTC',


'timezone' => 'Asia/Tokyo',

--------------------
'locale' => 'en',


'locale' => 'ja',

```

_________________________________________________________
## env-helper
env と書かれている関数。こういの。  
.env ファイルから値を持ってくるための命令。
```php
//app.php
    'name' => env('APP_NAME', 'Laravel'),
```
（例）  
app に関しては env の APP_NAME に値が設定されていたらそれを、値が設定されていなかったら Laravel を使う意味になる。




