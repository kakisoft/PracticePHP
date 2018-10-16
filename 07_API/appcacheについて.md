
【参考サイト】  
https://qiita.com/hidekuro/items/dea83ebdf73e2f2277ae  

______________________________________________________________


## HTML4.x までの no-cache
```
<meta> 要素の http-equiv 属性に Pragma, Cache-Control, Expires などを指定して制御します。
```
```html
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<title>page title here</title>
</head>
<body>
（省略）
</body>
</html>
```

## HTML5 における no-cache
Offline application cache に従い、 CACHE MANIFEST ファイルで制御します。
```
<!DOCTYPE html>
<html lang="ja" manifest="sample.appcache">
<head>
<meta charset="UTF-8">
<title>page title here</title>
</head>
<body>
（省略）
</body>
</html>
```

## sample.appcache
```
CACHE MANIFEST
# version: 1.0.0

CACHE:
ajax-loader.gif

FALLBACK:
/main.py /static.html             # /main.py が取得できない時は /static.html を
images/large/ images/offline.jpg  # images/large/ 以下のリソースが取得できない時は images/offline.jpg を

NETWORK:
*
```

### CACHE MANIFEST
1行目の CACHE MANIFEST はキーワードで、必ずこの文字列を1行目に記述する必要があります。

### CACHE:
キャッシングするリソースの URI を列挙します。ワイルドカードは使用できません。

### NETWORK:
サーバーへの接続を必要とするリソースの URI を列挙します。ワイルドカードを使用できます。

### FALLBACK:
リソースにアクセス出来ない場合のフォールバックページを指定する、オプションのセクションです。ワイルドカードを使用できます。


## 最小の no-cache 例
```
CACHE MANIFEST
NETWORK:
*
```