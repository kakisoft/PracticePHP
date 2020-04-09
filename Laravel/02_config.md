# コンフィグ（設定）

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

_____________________________________________________________________________
_____________________________________________________________________________
_____________________________________________________________________________
# コンフィグの解説

## env-helper
env と書かれている関数。こういの。  
.env ファイルから値を持ってくるための命令。
```php
//app.php
    'name' => env('APP_NAME', 'Laravel'),
```
（例）  
app に関しては env の APP_NAME に値が設定されていたらそれを、値が設定されていなかったら Laravel を使う意味になる。



_____________________________________________________________________________
_____________________________________________________________________________
_____________________________________________________________________________
# トラブルシュート  troubleshoot

## オートロード
vendor/composer/autoload_classmap.php  
composerが管理しているクラス。  
「Class XXX not found」というエラーが発生した場合、composer がクラスを認識していない可能性がある。  
その場合、以下のコマンドで解決。  
```
composer dump-autoload
```
