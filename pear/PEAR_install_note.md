# Windows

## 参考サイト
http://pentan.info/server/windows/win_php_pear.html


### １．
下記のURLより、PEARインストールのためのPHPのソースコードをダウンロードします。  
http://pear.php.net/go-pear

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


#### エラーメッセージ
```
phar "C:\tools\php72\PEAR\go-pear.php" has a broken signaturePHP Warning:  requi
re_once(phar://go-pear.phar/index.php): failed to open stream: phar error: inval
id url or non-existent phar "phar://go-pear.phar/index.php" in C:\tools\php72\PE
AR\go-pear.php on line 1271
続行するには何かキーを押してください . . .
```

#### 解決策：参考サイト
http://d.hatena.ne.jp/MugeSo/20080907/1220772672
```

```


