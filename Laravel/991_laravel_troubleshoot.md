## キャッシュをクリア
[09_artisan](./09_artisan.md)


```
php artisan config:clear | php artisan config:cache
```

```
php artisan cache:clear | php artisan config:clear | php artisan route:clear | php artisan view:clear | php artisan clear-compiled
```

```
php artisan cache:clear | php artisan config:clear | php artisan route:clear | php artisan view:clear | php artisan clear-compiled | php artisan optimize | php artisan config:cache
```

_________________________________________________________________________________________________________
## Permission denied

### log
```
UnexpectedValueException
The stream or file "/var/www/html/my-laravel-app/storage/logs/laravel.log" could not be opened in append mode: failed to open stream: Permission denied
```
権限を変更
```
chmod -R 777 storage/
```

### sessions
```
file_put_contents(/var/www/src/storage/framework/sessions/cct6lH7C4xwdtmMRPwTvWELTnX111j0xLyWvWlKf): Failed to open stream: Permission denied
```
https://qiita.com/naka46/items/e562e38764441d2b5b4a
```
chmod 777 storage/logs
chmod 777 storage/framework/sessions/
chmod 777 storage/framework/views/
```

_________________________________________________________________________________________________________
## Class XXX not found
https://qiita.com/niiyz/items/5b83ef5255a1ec64d9d6  
LaravelはAutoLoaderがあり、composerがクラス管理をしてる。  
そのため、composerの管轄外でクラス名等を変更すると、こういったエラー発生する事がある。  
　→（解決策）composerにクラス名を変更した事を通知する。  

```
composer dump-autoload
```


```vendor/composer/autoload_classmap.php``` にて、オートロードするファイルを確認できる。

_________________________________________________________________________________________________________
## composer requireエラー
```
> composer require beyondcode/laravel-websockets

Fatal error: require(): Failed opening required
```

⇒ composer install

_________________________________________________________________________________________________________
## composer install エラー
Windoes 環境のみで発生？
```
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - laravel/framework[v8.40.0, ..., 8.x-dev] require league/flysystem ^1.1 -> satisfiable by league/flysystem[1.1.0, ..., 1.x-dev].
    - league/flysystem[1.1.0, ..., 1.x-dev] require ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
    - Root composer.json requires laravel/framework ^8.40 -> satisfiable by laravel/framework[v8.40.0, ..., 8.x-dev].

To enable extensions, verify that they are enabled in your .ini files:
    - C:\tools\php74\php.ini
```

#### C:\tools\php74\php.ini
```
;extension=fileinfo
　　↓
extension=fileinfo
```

_________________________________________________________________________________________________________
# Model 関係

## laravelでpowershellからmigrateしようとしたらcould not find driverが出る
```
Illuminate\Database\QueryException  : could not find driver (SQL: select * from information_schema.tables where table_schema = laravel and table_name = migrations)
```

php.ini の DB接続設定がおかしい可能性が。
```
extension=sqlite3
```
とか。


## 外部制約エラー
```php
// Laravel 5.5 まで？
$table->unsignedInteger('post_id');

// Laravel 5.8以降
$table->unsignedBigInteger('post_id');
```

```
Migrating: 2020_04_26_153512_create_comments_table

   Illuminate\Database\QueryException 

  SQLSTATE[HY000]: General error: 1215 Cannot add foreign key constraint (SQL: alter table `comments` add constraint `comments_post_id_foreign` foreign key (`post_id`) references `posts` (`id`) on delete cascade)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:671
    667|         // If an exception occurs when attempting to run a query, we'll format the error
    668|         // message to include the bindings with SQL, which will make this exception a
    669|         // lot more helpful to the developer instead of just the database's errors.
    670|         catch (Exception $e) {
  > 671|             throw new QueryException(
    672|                 $query, $this->prepareBindings($bindings), $e
    673|             );
    674|         }
    675| 

      +9 vendor frames 
  10  database/migrations/2020_04_26_153512_create_comments_table.php:27
      Illuminate\Support\Facades\Facade::__callStatic("create")

      +22 vendor frames 
  33  artisan:37
      Illuminate\Foundation\Console\Kernel::handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
root@154b5cb61a5c:/var/www/html/my-laravel-app# 
```


## migration エラー（-m オプションを指定して Model作成時）
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'myapp01.migrations' doesn't exist
```
php artisan migrate:install


## migration エラー（-m オプションを指定して Model作成時）
```
file_put_contents(/var/www/html/my-laravel-app/database/migrations/2020_04_27_081707_create_posts_table.php): failed open stream: No such file or directory
```
未解決


_________________________________________________________________________________________________________
# 起動時のエラー
```
RuntimeException
No application encryption key has been specified.
```
暗号化キーが未設定の時に発生。

.env の　APP_KEY を設定する。
以下、キーを作成するコマンド。
```
php artisan key:generate
```

_________________________________________________________________________________________________________
## 419 unknown status

一時回避策

#### app\Http\Kernel.php
```php
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,      // ←これをコメントアウト
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
```

web 経由だからこんなのが出るので、api 経由にしておけばよいのでは。

