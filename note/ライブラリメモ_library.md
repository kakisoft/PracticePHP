# ヘルプ表示
https://www.php.net/manual/en/features.commandline.options.php
```
php -h
```

# インストールチェック
```
php -m
php -m | grep redis
```

```
php -i
php -i | grep pcntl
```

-m : Show compiled in modules  
-i : PHP information  

___________________________________________________________
## php-devel
PHP開発用


## php-pgsql
PostgreSQLモジュール


## php-mysqlnd
mysqlnd を使うほうが、 MySQL Client Server library (libmysqlclient) よりもおすすめです。 どちらのライブラリも、開発が続いています。  
<http://php.net/manual/ja/mysqlinfo.library.choosing.php>  


## mysqli

## php-mysql (MySQLモジュール)

## php-mbstring
マルチバイト文字モジュール


## FPM (FastCGI Process Manager)  php-fpm / php7.1-fpm
FPM (FastCGI Process Manager) は PHP の FastCGI 実装のひとつで、 主に高負荷のサイトで有用な追加機能を用意しています。  
  
この SAPI は、PHP 5.3.3 以降にバンドルされています。
　  
（参考）  
<https://qiita.com/kotarella1110/items/634f6fafeb33ae0f51dc>  
　   

## www.conf
php-fpm を使う時のコンフィグファイル（？）
```
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
```

## OPcache ( php-opcache )
OPcache はコンパイル済みのバイトコードを共有メモリに保存し、PHP がリクエストのたびにスクリプトを読み込み、パースする手間を省くことでパフォーマンスを向上させます。  
　  
このPHP拡張モジュールは PHP 5.5.0 以降のバージョンにバンドルされています。 PHP 5.2, 5.3, 5.4 では » PECL で利用可能です。
　  
（参考）  
<https://qiita.com/morimorim/items/fb39ae7d673a8b88f413>  


## php-mcrypt
暗号化・複号
```
警告
この機能は PHP 7.1.0 で 非推奨 となり、 PHP 7.2.0 で削除 されました。

この機能の代替として、これらが使えます。

Sodium (PHP 7.2.0から利用可能)
OpenSSL
```
この関数は、CBC, OFB, CFB, ECB 暗号モードの DES, TripleDES, Blowfish (デフォルト), 3-WAY, SAFER-SK64, SAFER-SK128, TWOFISH, TEA, RC2 , GOST のような広範なブロックアルゴリズムをサポートする mcrypt ライブラリへのインターフェイスです。加えて、"フリーではない" とされている RC6 および IDEA もサポートします。 CFB 及び OFB は既定では 8bit です。


## php-phpunit-PHPUnit
PHPUnit is a programmer-oriented testing framework for PHP.  
<https://phpunit.de/>  


## php-gd
画像処理


## php-pecl-xdebug
PHPのデバッグ用拡張モジュール


## php-pecl-xhprof
XHProf: A Hierarchical Profiler for PHP



## PDO クラス
