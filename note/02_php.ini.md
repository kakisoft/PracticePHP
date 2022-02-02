## php.ini の場所（パス）を探す
```
php -i | grep php.ini
```
この方法も
```
php --ini
```


## ブラウザから php.ini の保存パスを確認
```
phpinfo()
で調べる事ができる。
```


## ファイル追記
```
echo "extension=redis.so" >> /usr/local/etc/php/php.ini
```

