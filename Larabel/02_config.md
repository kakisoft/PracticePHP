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


