## ビルトインWebサーバ起動
```
php -S <IP>:<Port>
（例）
php -S localhost:8000
```

## php.ini
```
php -i | grep php.ini
```

## マルチバイト関数
「mb_」で始まるマルチバイト関数（mb_strlenなど）を実行した時に、以下のエラーが出た時の対処。
```
Uncaught Error: Call to undefined function ...
```

php.iniファイルに、以下の設定を追加する。  
既に設定されている場合はコメントアウトする。
```
extension=php_mbstring.dll
``` 


C:\tools\php72\php.ini



## メソッドの前のアットマーク（「@stream_socket_client」とか）
エラー制御演算子。その式により生成されたエラーメッセージは無視されます。  
「エラーが発生しても、表示されない」って事？

_____________________________________________________________________
## APIコマンド（叩く）
### file_get_contents
これで HTTP 叩く事も多い。

### stream_socket_client
Zend だとこれ。  
「http_build_query」も合わせて。

### fgets
これでも行けるの？


_____________________________________________________________________



