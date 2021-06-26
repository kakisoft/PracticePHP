# PHP_CodeSniffer
PHPCS （PHP_CodeSniffer）というツールで、コーディング規約に準じているかチェックできる。  

https://github.com/squizlabs/PHP_CodeSniffer


## ツール解説
phpcs phpcbf  
の２種類が存在している。  

* phpcs : PHP Code Sniffer （コードの解析のみ）
* phpcbf : PHP Code Beautifier and Fixer



____________________________________________________________________
## install
公式の説明資料は、これ。
```
composer global require "squizlabs/php_codesniffer=*"
```

グローバルにする必要は無いのでは？　あと、「--dev」が良さそう
```
composer require "squizlabs/php_codesniffer=*"
composer require --dev "squizlabs/php_codesniffer=*"
```

## uninstall
```
composer remove squizlabs/php_codesniffer
```

## バージョン確認
```
phpcs --version
./vendor/bin/phpcs --version
```

____________________________________________________________________
## コマンドラインから使用
```
./vendor/bin/phpcs -h
./vendor/bin/phpcbf -h
```

## 実行
```
phpcs  --report=source  --standard=PSR2  [phpファイル名  または ディレクトリ名 ] 
```

```
./vendor/bin/phpcs app/Repositories/PlaylistRepository.php

./vendor/bin/phpcs --report=source  --standard=PSR2  app/Repositories/PlaylistRepository.php
./vendor/bin/phpcbf --report=source  --standard=PSR2  app/Repositories/PlaylistRepository.php
```

## ルールを指定して実行
```
phpcs   --standard=/path/to/MyStandard/ruleset.xml
```


## 使用可能なルール一覧を表示
```
./vendor/bin/phpcs -i

//=> The installed coding standards are MySource, PEAR, PSR1, PSR12, PSR2, Squiz and Zend
```


