【PHP】Docker コンテナ起動の PHP にて、pcntl を有効にする方法

_____________________________________________________________________

Laravel の特定の機能を使う場合、pcntl（プロセス制御機能）が要求される事があります。  

それを使うためにはどうすれば？　という事を調べると、「PHPをコンパイルしてください」と凄いテンションが上がらない方法が見つかったりする。  

**PHP公式**    
[PHP: インストール手順 - Manual][https://www.php.net/manual/ja/pcntl.installation.php) ※PHP公式  

> PHPがサポートするプロセス制御機能は、デフォルトでは有効となってい ません。プロセス制御機能を有効にするには、  
> configure のオプションに > --enable-pcntl を付け、CGI 版あるいは CLI 版の PHP をコンパイルする必要があります。  

**Stack Overflow**  
[How to enable pcntl in php ( while using a framework like Symfony2 )](https://stackoverflow.com/questions/33036773/how-to-enable-pcntl-in-php-while-using-a-framework-like-symfony2)  
[How to enable PCNTL on Ubuntu server 16.04 - Stack Overflow](https://stackoverflow.com/questions/40408152/how-to-enable-pcntl-on-ubuntu-server-16-04)  


普段、Docker を使って開発しているデベロッパーにとっては、なかなか辛みのある修正。   

ですが、別に PHP をリコンパイルせずとも、Dockerfile を編集する事で pcntl（プロセス制御機能）を有効化する事は可能です。  

以下、編集例。  

```
RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl
```

Docker-composer を使っている場合、「docker-compose up -d --build」等のコマンドでリビルド。  

pcntl が有効となっているかは、コンテナログイン後に以下のコマンドで確認します。  
```
php -i | grep pcntl
```

以下の表示があれば、pcntl は有効となっています。  
```
pcntl support => enabled
```

php コマンドのオプションについては、以下を参照。  
[PHP: Options - Manual](https://www.php.net/manual/en/features.commandline.options.php)  

> -m    Show compiled in modules


**参考サイト**  
<https://github.com/codereviewvideos/docker-php-7/blob/master/Dockerfile>  


**おまけ**  
一応、こういう方法もあるみたい。  
[Installing PCNTL module for PHP without recompiling](https://newbedev.com/installing-pcntl-module-for-php-without-recompiling)  























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


