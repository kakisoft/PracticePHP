## 公式サイト
https://getcomposer.org/  

## インストール
https://getcomposer.org/download/  
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


## インストール（Amazon Linux）
https://dev.to/alexandrefreire/install-composer-on-amazon-ami-running-on-ec2-10a6
```
sudo curl -sS https://getcomposer.org/installer | sudo php
sudo mv composer.phar /usr/local/bin/composer
sudo ln -s /usr/local/bin/composer /usr/bin/composer
```

＜公式インストールスクリプト＞  
https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md


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


## Chocolatey から
```
choco install composer
```

_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
_______________________________________________________________________
# Composer を使用して、ライブラリをインストール
```
composer install
```
インストールされるライブラリや、ライセンス、オーナーなどは、composer.json または composer.lock を参照。


## require
https://kekaku.addisteria.com/wp/20190902100602  
パッケージを追加するときに使います。パッケージ名やバージョンを指定して追加することもできます。  

このコマンドでは、composer.jsonに必要パッケージを記録します。  

ローカル開発環境で行なうべきコマンドです。  

https://www.webdesignleaves.com/pr/php/php_composer.php  
require サブコマンドは composer.json ファイルに新しいパッケージを追加し、ライブラリをインストールします。  
```
composer require predis/predis
```

________________________________________________
## ひな形から作成
```
composer init
（composer.json が作成される。何かいっぱい聞かれる）
　　↓
composer.json を編集。
　　↓
composer install
```


### composer.json 編集例
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

________________________________________________
## パッケージの追加
```
composer require vendor/package
composer require --dev vendor/package
composer require vendor/package:2.1
```
#### 使用例
```
composer require nesbot/carbon
composer require --dev phpunit/phpunit:3.7
```

--dev は、「"require-dev"」のセクションに追加される。

________________________________________________
## パッケージの削除
```
composer remove [package]
```
#### 使用例
```
composer remove nesbot/carbon
composer remove --dev phpunit/phpunit
```

________________________________________________
## パッケージの更新
```
composer update
```
ただし、composer.json から不要になったパッケージを手で削除して composer update は、あまり良くなさそう。
```
composer update --with-dependencies
```
ならＯＫ？  
でも、削除したいなら remove が良さげ。（割と最近追加されたコマンドみたい。）


________________________________________________
## オートロード
https://laraweb.net/surrounding/1642/  
PHPファイルの冒頭に require を書かずに済む仕組み。  
vendor/autoload.php というファイルがそれ。

```
composer dump-autoload
```

_______________________________________________________________________
# オプション

|     option        |  discription                                 |
|:------------------|:---------------------------------------------|
|  -–prefer-source  |  デフォルト。git cloneでソースを落としてくる。  |
|  --prefer-dist    |  zipでダウンロードする。こっちの方が高速。      |


## Composerの依存性チェックによる phpバージョンエラーを一時的に回避
```
composer install --ignore-platform-reqs
```

#### How to install Composer packages ignoring PHP version requirements
https://php.watch/articles/composer-ignore-platform-req  


_______________________________________________________________________
# メモ
composer.lock が存在する場合、composer.lock に書かれているバージョンをダウンロードする。
リポジトリには composer.lockも一緒にコミットをすると良さげ。


_______________________________________________________________________

# composer install と composer updateの違い
https://qiita.com/YusukeHigaki/items/47dd3ec23544225f7301

## composer install
composer.lockに書かれている各ライブラリをインストールする。

## composer update
composer.jsonをもとに各ファイルを最新版にアップデートする。


### composer.lock
現在使用しているバンドルのバージョン等が管理されます。

### composer.json
必要となるバンドルを記述します。


```
新しい環境ではじめにインストールするとき：
composer install

何か新しいバンドルを追加したい：
composer.json に追記して composer update

本番のライブラリを最新版にしたい：
開発環境でcomposer updateして問題なければcomposer.lockファイルを本番にコピーしてcomposer intallする
```

