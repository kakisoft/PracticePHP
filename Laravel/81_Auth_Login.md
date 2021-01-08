## 認証機能生成（ログイン）
version 5
```
php artisan make:auth
```

version 6 以降だと、これ？  
https://laravel.com/docs/7.x/authentication  
https://qiita.com/kusumoto-t/items/fc6ef3f5bf1dbe5dc579  
```
php artisan ui vue --auth
```
以下が必要な場合もあるの？
```
composer require laravel/ui --dev
```

ログイン機能が作成される。（/home の階層）  
```php
Route::get('/home', 'HomeController@index')->name('home');
```
User クラスが無いとエラーになる。

#### 作成されるファイル

 * app/Http/Controllers/HomeController.php
 * resources/views/home.blade.php
 * resources/views/auth/login.blade.php
 * resources/views/auth/register.blade.php
 * resources/views/auth/passwords/email.blade.php
 * resources/views/auth/passwords/reset.blade.php
 * resources/views/layouts/app.blade.php


#### 更新されるファイル

 * routes/web.php

____________________________________________________________________
# Migration
migration 時に作成されるテーブル

 * users
 * password_resets


____________________________________________________________________
# 備考
デフォルトで作成されるUserモデルを使う事が前提になっている。  
そこを変えようとすると、色々面倒。  

デフォルトだと、User.php が app 直下にあるのがちょっと気持ち悪い。  

モデルを app/Model に移動させばいいんだけど、namespaceを App から Model\App に変えると動かない部分が出てくるので、フォルダを移動させつつも、名前空間はそのまま。  
ちょっと気持ち悪いけど、まぁ便利だからそのくらい目を瞑るか。  







