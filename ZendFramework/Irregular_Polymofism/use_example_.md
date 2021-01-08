#### コール
```php
$MasterItemModelObj = new MethodIntercepter( new MaterialModel() );
```

#### 使う
```php
// MaterialModel のメソッドをコール。
$MasterItemModelObj->getItems();
```



・・・改めて思ったけど、どう見ても MethodIntercepter のインスタンスを作ってるようにしか見えない点が非常に気持ち悪い。  
抽象クラスを使えばよいのでは？  


