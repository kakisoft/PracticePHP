https://laravel.com/
## Laravel 5.5
PHP7以上  



## Composer
https://getcomposer.org/  
https://getcomposer.org/download/  

コマンドを実行。（以下、2019/06 時点のMac）
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

```
composer -V

or

php composer.phar -V
```

## Laravelインストール（バージョンを指定する場合、次項を参照）
「インストール ＆ プロジェクト作成」みたいな感じ。
```
php composer.phar create-project --prefer-dist laravel/laravel myblog

cd myblog/

php artisan --version
```
Laravel の 5.5 だとデフォルトで User モデルが作られる


## バージョンを指定してインストール
```
composer create-project --prefer-dist  "laravel/laravel=5.5" sampleproject
composer create-project --prefer-dist  "laravel/laravel=5.1.*" sampleproject

cd sampleproject
php artisan -V
```
その後、git init 等を忘れずに。  


### 備考（「laravel/laravel」）
https://packagist.org/  
に登録されているパッケージ名。  
（packagistはPHPで使える便利なプログラムが登録されているサイトです）  

laravel/larave  
は、  
「laravel というベンダーさんが開発している laravel という名前のプロジェクト」  
という意味。  


## オプションについて
--prefer-dist  
インストール方法を指定するオプション。  
ソースコードではなく zip 形式でインストール。  
https://readouble.com/laravel/5.5/ja/installation.html  



