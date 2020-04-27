## 公式サイト
<https://getcomposer.org/>

## インストール
<https://getcomposer.org/download/>
```
Command-line installation


php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

インストールというより、git clone に近いのか？

```
＜Globally＞
mv composer.phar /usr/local/bin/composer
```

## インストール
php composer-setup.php --install-dir=bin --filename=composer



## パッケージスト
composer を使ってインストールできる定番パッケージリスト。  
https://packagist.org/  


https://twitteroauth.com/  


________________________________________________________________________
# Win
## composerインストール（Win）
公式サイトより、「Composer-Setup.exe 」をダウンロード。


```
composer -V


composer create-project --prefer-dist laravel/laravel myblog
```


## コマンドラインから
まだ試してない。
https://getcomposer.org/doc/00-intro.md#manual-installation


_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
# 使う
```
composer init
（composer.json が作成される。何かいっぱい聞かれる）
　　↓
composer.json を編集。
　　↓
composer install
```


## composer.json 編集例
before
```json
    "require": {}
```

after
```json
    "require": {
        "phpunit/phpunit": "3.7.*"
    }
```


