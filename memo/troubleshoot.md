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
