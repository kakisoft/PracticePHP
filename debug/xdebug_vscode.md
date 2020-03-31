## VS Code + PHP Debug によるデバッグ
#### １．
PHP Debug（vscode プラグイン）  
をインストール　　

#### ２．
php.ini を編集。  
```
[xDebug]
xdebug.remote_enable = 1
xdebug.remote_autostart = 1

zend_extension = "php_xdebug-2.9.4-7.3-vc15-nts-x86_64.dll"
;xdebug.remote_enable = 1
;xdebug.remote_host = 127.0.0.1
;xdebug.remote_port = 9000
;xdebug.remote_handler = dbgp
```
※ ext フォルダに php_xdebug を配置しておく。  


#### ３．
左メニューからデバッグのウィンドウを開き、  
To create a lanch.json file  

```
.vscode\launch.json
```
を編集。（別にデフォルトでもいいけど）  

メニューから開く場合、  
Run → Add Configuration → PHP  


#### ４．
ブレークポイントを設定し、  
Run。  


