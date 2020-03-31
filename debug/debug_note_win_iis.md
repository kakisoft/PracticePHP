# 【 IIS (for Windows Server) 】

## ログの保存場所

#### php.ini
```ini
error_log = C:\logs\php\php_errors.log
```

#### 設定確認
```php
phpinfo();
```
で確認することもできる。

```
display_errors
error_log
```
とかをチェック。



## php にて設定
```php
ini_set('display_errors', 'On');  //これは無くてもいいかも。
ini_set('error_log', 'C:\logs\php\tmp_log_01.log');
```



## 出力
```pnp
error_log("iniで設定したファイルに出力111");
ini_set('error_log', 'C:\logs\php\tmp_log_01.log');



error_log("iniで設定したファイルに出力222");
```
***※ ファイルパスを 「"」で囲むと上手く行かなかった。***  



## 出力（その場でパスを指定）
```php
$message = "aaa".PHP_EOL;
error_log($message,'3','C:\logs\php\tmp_log_02.log');
error_log(print_r($array01, true),'3','C:\logs\php\tmp_log_02.log');```
```
***※ ファイルパスを 「"」で囲むと上手く行かなかった。***  


## 出力した値をリアルタイムでトレース
```
tail -f C:\logs\php\tmp_log_02.log
```

_________________________________________________
# cmder設定
bash
```
vi ~/.bashrc
```

```
alias ll='ls -la'
alias tlog='tail -f /c/logs/php/tmp_log_02.log'
alias clog=': >  /c/logs/php/tmp_log_02.log'
```

```
source ~/.bashrc
```



