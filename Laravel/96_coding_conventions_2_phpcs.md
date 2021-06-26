# PHP_CodeSniffer
PHPCS （PHP_CodeSniffer）というツールで、コーディング規約に準じているかチェックできる。  

https://github.com/squizlabs/PHP_CodeSniffer


## ツール解説
phpcs phpcbf  
の２種類が存在している。  

* phpcs : PHP Code Sniffer （コードの解析のみ）
* phpcbf : PHP Code Beautifier and Fixer （整形）


#### 実行
```
./vendor/bin/phpcs --report=source --standard=PSR2 app/Repositories/PlaylistRepository.php
```

____________________________________________________________________
## install
公式の説明資料は、これ。
```
composer global require "squizlabs/php_codesniffer=*"
```

グローバルインストールする必要は無いのでは？　あと、「--dev」がいいと思う。
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
ヘルプ表示
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

____________________________________________________________________
____________________________________________________________________
____________________________________________________________________
# コマンドラインオプション

## report （出力形式）
解析結果の出力形式を、json や csv で出力する事も出来る。  

--report=<report>  
```
root@13d9d18742b7:/var/www/html/my-laravel-app# ./vendor/bin/phpcs -h

Usage: phpcs [-nwlsaepqvi] [-d key[=value]] [--colors] [--no-colors]
  [--cache[=<cacheFile>]] [--no-cache] [--tab-width=<tabWidth>]
  [--report=<report>] [--report-file=<reportFile>] [--report-<report>=<reportFile>]
  [--report-width=<reportWidth>] [--basepath=<basepath>] [--bootstrap=<bootstrap>]
  [--severity=<severity>] [--error-severity=<severity>] [--warning-severity=<severity>]
  [--runtime-set key value] [--config-set key value] [--config-delete key] [--config-show]
  [--standard=<standard>] [--sniffs=<sniffs>] [--exclude=<sniffs>]
  [--encoding=<encoding>] [--parallel=<processes>] [--generator=<generator>]
  [--extensions=<extensions>] [--ignore=<patterns>] [--ignore-annotations]
  [--stdin-path=<stdinPath>] [--file-list=<fileList>] [--filter=<filter>] <file> - ...

 <report>       Print either the "full", "xml", "checkstyle", "csv"
                "json", "junit", "emacs", "source", "summary", "diff"
                "svnblame", "gitblame", "hgblame" or "notifysend" report,
                or specify the path to a custom report class
                (the "full" report is printed by default)
```

エラーの詳細を調べる場合、--report=full がおススメ。  


## standard （適用する規約）
```
 <standard>     The name or path of the coding standard to use
```
規約を指定する方法と、ファイルをしているする方法がある。
```
phpcs app/Repositories/PlaylistRepository.php
phpcs --standard=PSR2 app/Repositories/PlaylistRepository.php
phpcs --standard=/path/to/MyStandard/ruleset.xml
```
また、--standard オプションを省略した時の挙動は以下。  
The default coding standard used by PHP_CodeSniffer is the PEAR coding standard. To check a file against the PEAR coding standard, simply specify the file's location:

ただし、以下のファイルが存在していた場合、デフォルトとして読み込む模様。（PEAR より優先度高）  

 * .phpcs.xml
 * phpcs.xml
 * .phpcs.xml.dist
 * phpcs.xml.dist

#### 該当ソース
https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Config.php#L348
```php
            $defaultFiles = [
                '.phpcs.xml',
                'phpcs.xml',
                '.phpcs.xml.dist',
                'phpcs.xml.dist',
            ];
```

適用の優先順位

.phpcs.xml > phpcs.xml > .phpcs.xml.dist > phpcs.xml.dist  


____________________________________________________________________
# スクリプト

composer スクリプトで実行できるようにする
```
composer phpcs
```

## composer.json
```json
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ],
        "phpmd": [
            "./vendor/bin/phpmd --exclude '*/bootstrap/*,*/config/*,*/database/*,*/node_modules/*,*/public/*,*/resources/*,*/routes/*,*/storage/*,*/vendor/*,*/tests/*,*/server.php,*/app/Console/Kernel.php' ./ ansi ./phpmd.xml || exit 0"
        ],
        "phpcs": [
            "./vendor/bin/phpcs --colors --standard=phpcs.xml ./ || exit 0"
        ],
```

____________________________________________________________________
____________________________________________________________________
____________________________________________________________________
# ルールセット

## 公式
https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/ruleset.xml



____________________________________________________________________
____________________________________________________________________
____________________________________________________________________
# tmp

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

