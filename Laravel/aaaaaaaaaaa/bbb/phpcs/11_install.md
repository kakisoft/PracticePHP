## install
composer global require "squizlabs/php_codesniffer=*"

composer require "squizlabs/php_codesniffer=*"
composer require --dev "squizlabs/php_codesniffer=*"


## uninstall
composer remove squizlabs/php_codesniffer


## help
./vendor/bin/phpcs -h
./vendor/bin/phpcbf -h


## use
phpcs  --report=source  --standard=PSR2  [phpファイル名  または ディレクトリ名 ] 



phpcs --report=source  --standard=PSR2  [phpファイル名  または ディレクトリ名 ] 


./vendor/bin/phpcs --report=source --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php


________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________



jobFunctionTypeConstant

app\Constants\JobFunctionTypeConstant.php
app/Constants/JobFunctionTypeConstant.php





________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________
________________________________________________________________________________________________________________________


```
root@ddfa20fadae0:/var/www/html/my-laravel-app# ./vendor/bin/phpcs --report=source --standard=PSR2 app/Repositories/PlaylistRepository.php

PHP CODE SNIFFER VIOLATION SOURCE SUMMARY
------------------------------------------------------------------------
STANDARD  CATEGORY            SNIFF                                COUNT
------------------------------------------------------------------------
Squiz     Classes             Valid class name not camel caps      1
------------------------------------------------------------------------
A TOTAL OF 1 SNIFF VIOLATION WERE FOUND IN 1 SOURCE
------------------------------------------------------------------------

Time: 1.26 secs; Memory: 8MB
```




 <report>       Print either the "full", "xml", "checkstyle", "csv"
                "json", "junit", "emacs", "source", "summary", "diff"
                "svnblame", "gitblame", "hgblame" or "notifysend" report,
                or specify the path to a custom report class
                (the "full" report is printed by default)




./vendor/bin/phpcs --report=full --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=xml --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=checkstyle --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=csv --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=json --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=junit --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=emacs --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=source --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=summary --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=diff --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=svnblame --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=gitblame --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=hgblame --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php
./vendor/bin/phpcs --report=notifysend --standard=phpcs.xml app/Constants/JobFunctionTypeConstant.php




