【Laravel】ジョブのタイムアウトを設定には、特定の条件が必要？

_____________________________________________________________________

プロセス制御


## _
https://stackoverflow.com/questions/33036773/how-to-enable-pcntl-in-php-while-using-a-framework-like-symfony2
```

```


## Timeout
https://laravel.com/docs/8.x/queues#timeout

```
The pcntl PHP extension must be installed in order to specify job timeouts.
```


## インストール手順
https://www.php.net/manual/ja/pcntl.installation.php

PHPがサポートするプロセス制御機能は、デフォルトでは有効となってい ません。プロセス制御機能を有効にするには、 configure のオプションに --enable-pcntl を付け、CGI 版あるいは CLI 版の PHP をコンパイルする必要があります。


## 
https://github.com/codereviewvideos/docker-php-7/blob/master/Dockerfile
```
# Install various PHP extensions
RUN docker-php-ext-configure bcmath --enable-bcmath \
  && docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
```








```
wget "https://www.php.net/distributions/php-7.4.0.tar.gz"
tar xvf "php-7.4.0.tar.gz"
cd "php-7.4.0/ext/pcntl/"
phpize
./configure
make
```




________________________________________________________________________________________________

ジョブを実行する時、以下のようにタイムアウトの時間（X 秒経過するとエラー）を設定できる。  
```
php artisan queue:listen --timeout=60
```

他にも、タイムアウト時間を、コードに記述する事もできる。  

```php
namespace App\Jobs;

class ProcessPodcast implements ShouldQueue
{
    /**
     * タイムアウトになる前にジョブを実行できる秒数
     *
     * @var int
     */
    public $timeout = 120;
}
```

＜公式サイト＞  
https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs  


が、実験したところ、ソースコードにて指定された「120」が有効とならなかった。  
何か条件があるかもしれないし、




pcntl


php -m | grep pcntl
php -i | grep pcntl



https://rj-bl.hatenablog.com/entry/2017/04/09/165858

https://stackoverflow.com/questions/40408152/how-to-enable-pcntl-on-ubuntu-server-16-04

https://stackoverflow.com/questions/33036773/how-to-enable-pcntl-in-php-while-using-a-framework-like-symfony2



## 失敗したジョブの再試行
```
php artisan queue:failed
```





うっわ！やりたくない！
と思ってしまうような


pcntlというPHPのマルチスレッドプログラミングはdefaultでは使えないようです。

pcntl を 有効にして PHP をコンパイルすると、

プロセス制御のPCNTL関数を使えば似たようなことができるそうだ。



## _
一応、こういう方法もあるみたい。
https://newbedev.com/installing-pcntl-module-for-php-without-recompiling







_____

Alpine 
```
#===+====1====+====2====+====3====+====4====+====5====+====6====+====7====+====8====+====9====+====0
# 拡張モジュールビルドステージ： pcntl
#===+====1====+====2====+====3====+====4====+====5====+====6====+====7====+====8====+====9====+====0
FROM php:7.4-fpm-alpine AS build-pcntl
RUN set -xe && apk add --update-cache --no-cache autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c
RUN set -xe && docker-php-ext-install pcntl


# 拡張モジュールインストール： pcntl
COPY --from=build-pcntl ${PHP_EXTENSION_PATH}/pcntl.so ${PHP_EXTENSION_PATH}/pcntl.so
COPY --from=build-pcntl ${PHP_CONFIG_PATH}/docker-php-ext-pcntl.ini ${PHP_CONFIG_PATH}/docker-php-ext-pcntl.ini

```


