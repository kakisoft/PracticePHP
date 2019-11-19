## laravelでpowershellからmigrateしようとしたらcould not find driverが出る
```
Illuminate\Database\QueryException  : could not find driver (SQL: select * from information_schema.tables where table_schema = laravel and table_name = migrations)
```

php.ini の DB接続設定がおかしい可能性が。
```
extension=sqlite3
```
とか。


