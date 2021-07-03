## Laravel Telescope
デバッグ支援

__________________________________________________________________________
## dump-server
https://github.com/beyondcode/laravel-dump-server  

#### 概要
dump() の結果をコンソールに出力させるためのツール。  

Laravel のヘルパ関数の dump() をそのまま実行すると、 HTTP レスポンスに割り込む形で内容が出力されるので開発時に何度もブラウザ画面をリロードせざるを得なかったりしますが、Dump Server を使うと出力がコンソールに回されるため、処理を中断されずに変数の中身を確認することが出来る。  

#### install
```
composer require --dev beyondcode/laravel-dump-server
```

#### lanch
```
php artisan dump-server

php artisan dump-server > dump.txt
php artisan dump-server --format=html > dump.html
```

#### ex
```
Laravel Var Dump Server
=======================

 [OK] Server listening on tcp://127.0.0.1:9912

 // Quit the server with CONTROL-C.


GET http://localhost:8000/api/event01
-------------------------------------

 ------------ -------------------------------------------
  date         Sat, 03 Jul 2021 10:42:05 +0000
  controller   "Closure"
  source       AccessDetectionListener.php on line 29
  file         app/Listeners/AccessDetectionListener.php
 ------------ -------------------------------------------

"Access Detected param=bpr6CGosGh"
```


