<?php

/*
１．ビルトインサーバ起動

php -S localhost:8000 91_add_xdebug_win.php


２．phpinfo() にて設定確認。（php実行パスとか）。この内容をコピー。
http://localhost:8000/


*/


phpinfo();


/*
３．「手順．２」でコピーした phpinfo() の内容を、xdebug の以下のページにペースト。最適なDLLを提示してくれる。

https://xdebug.org/wizard


４．「手順．３」にてダウンロードした dll を
ext フォルダに配置。


５．php.ini を編集。以下を追記。（他の設定については後で書く！）

## php.ini
※ファイル指定時に「.\ext\」といったパスは不要っぽい。
```
[xDebug]
zend_extension = "php_xdebug-2.9.4-7.3-vc15-nts-x86_64.dll"
;xdebug.remote_enable = 1
;xdebug.remote_host = 127.0.0.1
;xdebug.remote_port = 9000
;xdebug.remote_handler = dbgp
```

６．再表示。

『 xdebug 』の項目があるかチェック。



＜備考＞

ビルトインサーバからの起動だと、こんな感じにメッセージを表示してくれるので、エラーの追跡に便利。
--------------------------------------------------------------------------------------------------
[Wed Mar 25 15:08:30 2020] PHP Warning:  Failed loading Zend extension 'ext\php_xdebug-2.9.4-7.3-vc15-nts-x86_64.dll' (tried: ext\ext\php_xdebug-2.9.4-7.3-vc15-nts-x86_64.dll (指定されたモジ
ュールが見つかりません。), ext\php_ext\php_xdebug-2.9.4-7.3-vc15-nts-x86_64.dll.dll (指定されたモジュールが見つかりません。)) in Unknown on line 0
PHP 7.3.11 Development Server started at Wed Mar 25 15:08:30 2020

--------------------------------------------------------------------------------------------------


*/


//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
//                                 ローカルインストール以外の php を実行する場合
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
/*

C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86

C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php -S localhost:8000
C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php.exe -S localhost:8000


C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php -S localhost:8000
C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php.exe -S localhost:8000
・・・といった操作では出来なかったので、環境変数を書き換え。


＜環境変数の表示＞
set


＜環境変数の設定＞
コンパネ → システム → システムの詳細設定 → 詳細設定 → 環境変数

特別な設定をしていなければ、「システム環境変数」の「Path」


・・・・では上手く行かず。
何かいい方法ないかな。もしくは再起動が必要なだけ？


*/


