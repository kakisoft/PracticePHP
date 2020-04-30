# 本番用設定

## キャッシュをクリア
```
composer dump-autoload -o
php artisan optimize
```
本番環境では -o オプション付き、開発環境では -o オプションなしで運用。


#### composer dump-autoload -o
以下のファイルを生成

 * vendor/composer/autoload_classmap.php
 * vendor/composer/autoload_files.php
 * vendor/composer/autoload_namespaces.php
 * vendor/composer/autoload_psr4.php
 * vendor/composer/autoload_real.php



