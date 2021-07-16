## 永久保存版！Laravel・Cacheの使い方大全
https://blog.capilano-fw.com/?p=1344


```php
$minutes = 10; // 有効期間（分）
\Cache::put('key', '保存データ', $minutes);


// デフォルト値を指定して取得
$cache = \Cache::get('key', '代わりのデータ');



$cache = \Cache::pull('key');   // キャッシュは削除されます




// 特定のキャッシュを削除したい
\Cache::forget('key'); // 「key」のキャッシュだけ削除



// 全てのキャッシュを削除したい
\Cache::flush(); // 全キャッシュを削除
```


#### 自動更新（作成）するキャッシュをつくりたい
put()やadd()を使えば、気軽に変数内のデータをキャッシュ化することができますが、毎回has()メソッドでキャッシュの存在チェックして、もしなければキャッシュを作成するというコードを書くのはめんどうだったりします。

その場合に使えるのがremember()です。

以下の例は10分ごとにキャッシュを更新する（つまり、10分間はキャッシュが有効になる）例です
```php
$minutes = 10;
$cache = \Cache::remember('key', $minutes, function(){

    return now()->toDateTimeString(); // 10分ごとに自動更新

});
```


また、有効時間を決めない場合は、rememberForever()を使いますが、こちらはキャッシュが手動で消されるまで更新されることはありません。
```php
$cache = \Cache::rememberForever('key', function(){

    return now()->toDateTimeString();

});
```


#### キャッシュ方法を切り替えたい
```php
\Cache::store('apc')->put('key', '保存データ', 10);
```

