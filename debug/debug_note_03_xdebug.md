## インストールされているPHPが非デバッグ版かどうかを確認
```
php -i | grep 'Debug Build'

（こうなってたらOK）
Debug Build => no
```


## Xdebug のインストール状況確認
```
php -m
```



## xdebug のインストール
https://qiita.com/NakanishiTetsuhiro/items/19012ca88ce501a6f6a4

### pearをインストール
```
curl -O https://pear.php.net/go-pear.phar
php -d detect_unicode=0 go-pear.phar
sudo php /usr/lib/php/ install-pear-nozlib.phar

```

### パスを通す
```
export PATH=$PATH:$HOME/pear/bin/
```

### SIPをオフ
```
（やらなくても問題ない？）
csrutil disable
```

### xdebugをインストール
```
pecl install xdebug
```

### /etc/php.ini に追記
```
zend_extension=/usr/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so
```

### インストール状況を確認
```
php -i | grep xdebug
```

### csrutilをオンする
```
csrutil enable
```





