## Routeクラスのエラーメッセージ（コードチェック）
https://qiita.com/AkiYanagimoto/items/047c3492749a407c2ace  

PHP Intelephense （拡張機能）によるもの。  
特定ルールを除外する。  

プラグイン検索ウィンドウにて「 PHP Intelephense 」→ 右クリック → Extension Settings  

以下のチェックを外す  
```
intelephense.diagnostics.undefinedClassConstants
intelephense.diagnostics.undefinedConstants
intelephense.diagnostics.undefinedFunctions
intelephense.diagnostics.undefinedMethods
intelephense.diagnostics.undefinedProperties
intelephense.diagnostics.undefinedTypes
```

以下だけでも可。  
https://github.com/bmewburn/vscode-intelephense/issues/780  
```
intelephense.diagnostics.undefinedTypes
```




