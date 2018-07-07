# Windows

## 参考サイト
http://sprint-life.hatenablog.com/entry/2014/02/24/150423  
―http://pentan.info/server/windows/win_php_pear.html  


### １．
下記のURLより、PEARインストールのためのPHPのソースコードをダウンロードします。    
 ※PHP7  
http://pear.php.net/go-pear

#### （公式サイト）
https://pear.php.net/manual/en/installation.getting.php  
https://pear.php.net/go-pear.phar  

### ２．
PHPのインストールフォルダに、「PEAR」というフォルダを作って、そこに保存します。
```
where php

C:\tools\php72\php.exe
```


### ３．
以下のコードを、「go-pear.bat」として、PHPのインストールフォルダに保存。　　
その後、実行。
```
@ECHO OFF
set PHP_BIN=php.exe
%PHP_BIN% -d output_buffering=0 PEAR\go-pear.php
pause
```

```
PHPのインストールフォルダ(C:\Program Files\PHP または C:\PHP)
├ PEAR
│└ go-pear.php
└ go-pear.bat
```
## 環境変数追加
※choco 使った場合
```
PHP_PEAR_SYSCONF_DIR
C:\tools\php72\PEAR
```

## 最終的に使用したコマンド
C:\tools\php72\PEAR　にて実行。
```
php go-pear.phar
```
※要管理者権限



