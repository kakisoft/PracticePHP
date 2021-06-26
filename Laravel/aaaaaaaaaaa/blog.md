PHP_CodeSniffer を使って、コーディング規約に準拠しているかをチェックする
__________________________________________________________________________________________

PHP_CodeSniffer（PHPCS） というツールで、書いたコードがコーディング規約に準拠しているかをコマンド１発で確認できるようになる。  

コマンドは「phpcs」。

#### PHP_CodeSniffer 公式サイト
https://github.com/squizlabs/PHP_CodeSniffer  

#### ツール解説
phpcs と  phpcbf の２種類のツールがある。  

* phpcs : PHP Code Sniffer （コードの解析のみ）
* phpcbf : PHP Code Beautifier and Fixer （整形する）


## インストール
公式の説明資料は、これ。  
```
composer global require "squizlabs/php_codesniffer=*"
```

グローバルインストールする必要は無いのでは？　あと、本番で使う必要は無いので、「--dev」オプションを付けた方がいいと思う。  
なので、自分が使用したコマンドは以下。  
```
composer require --dev "squizlabs/php_codesniffer=*"
```

## アンインストール
```
composer remove squizlabs/php_codesniffer
```

## バージョン確認
```
./vendor/bin/phpcs --version
```

## ヘルプ表示
```
./vendor/bin/phpcs -h
./vendor/bin/phpcbf -h
```

## 実行
最小構成
```
phpcs [ファイル名 orディレクトリ名]
```

よく使うオプションを付けると、こんな感じ
```
phpcs --report=source --standard=PSR2 [ファイル名 orディレクトリ名]
```

##### 使用例
```
./vendor/bin/phpcs app/Repositories/PlaylistRepository.php

./vendor/bin/phpcs --report=source --standard=PSR2 app/Repositories/PlaylistRepository.php
./vendor/bin/phpcbf --report=summary --standard=/MyStandard/phpcs.xml app/Repositories/PlaylistRepository.php
```

##### 実行結果例
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

## オプション解説

### --report ： 出力形式を選択
以下から選択可。

 * full
 * xml
 * vcheckstyle
 * csv
 * json
 * junit
 * emacs
 * source
 * summary
 * diff
 * svnblame
 * gitblame
 * hgblame
 * notifysend

詳細はヘルプコマンドを。  

エラーの詳細を調べる場合、--report=full が情報量が多くておススメ。   

通常の使用は、「xml」「json」といった形式に出力とか。  
あとは、「source」「summary」等がダイジェストで確認できていい感じ。  


## --standard ： 適用する規約を選択
「PSR2」等のコーディング規約を指定する方法と、コーディング規約ファイルを指定する方法の２通りがある。

#### コーディング規約を指定して実行
```
./vendor/bin/phpcs --report=source --standard=PSR2  app/Repositories/PlaylistRepository.php
```
使用可能なコーディング一覧は、以下のコマンドで確認可。
```
./vendor/bin/phpcs -i

//=> The installed coding standards are MySource, PEAR, PSR1, PSR12, PSR2, Squiz and Zend
```

#### コーディング規約ファイルを指定して実行
```
./vendor/bin/phpcbf --report=summary --standard=phpcs.xml app/Repositories/PlaylistRepository.php
```
コーディング規約の PSR2 をベースに記述した場合の phpcs.xml の記述例が以下。（公式）  
<https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/ruleset.xml>  

上記のではファイル名が「ruleset.xml」となっているが、ファイル名は「phpcs.xml」という名前がおススメ。  
理由は後述。  

ノンカスタマイズの PSR2 を使う場合の最小構成は、こんな感じ。
##### phpcs.xml
```xml
<?xml version="1.0"?>
<ruleset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" name="PSR2" xsi:noNamespaceSchemaLocation="../../../phpcs.xsd">
    <description>The PSR-2 coding standard.</description>
    <arg name="tab-width" value="4"/>

    <rule ref="PSR2"/>
</ruleset>
```

#### コーディング規約を指定しなかった場合（--standard オプション省略時）
「PEAR」が適用される。  
コーディング規約を暗黙にしておくのは避けたいので、しっかりと明示しておく方がよさそう。  

ちなみに、--standard オプションを指定しなかった場合でも、「phpcs.xml」というファイルが存在していれば、それをコーディング規約定義ファイルとして読み込んでくれる。  

「どういう事だ？」と思って調べてみたら、「.phpcs.xml」「phpcs.xml」「.phpcs.xml.dist」「phpcs.xml.dist」というファイルが存在していた場合、「--standard=phpcs.xml 」とファイル名を指定しなくても、暗黙的にそれらを定義ファイルとして読み込んでくれるみたい。

##### PHP_CodeSniffer : 該当ソース
https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Config.php#L348
```php
            $defaultFiles = [
                '.phpcs.xml',
                'phpcs.xml',
                '.phpcs.xml.dist',
                'phpcs.xml.dist',
            ];
```

適用の優先順位は  

.phpcs.xml > phpcs.xml > .phpcs.xml.dist > phpcs.xml.dist  

の順番。  
適用されるファイルは１つだけ。（.phpcs.xml と phpcs.xml が存在していた場合、適用されるのは .phpcs.xml のルールのみ）  

混乱の原因になるので、ファイルは１つだけにしておく。  


次回、定義ファイルの詳細について書く予定。  



