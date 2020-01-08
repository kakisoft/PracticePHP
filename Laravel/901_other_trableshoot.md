## Class XXX not found
https://qiita.com/niiyz/items/5b83ef5255a1ec64d9d6  
LaravelはAutoLoaderがあり、composerがクラス管理をしてる。  
そのため、composerの管轄外でクラス名等を変更すると、こういったエラー発生する事がある。  
　→（解決策）composerにクラス名を変更した事を通知する。  

```
composer dump-autoload
```


```vendor/composer/autoload_classmap.php``` にて、オートロードするファイルを確認できる。

