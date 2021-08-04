【Laravel】バックグラウンド処理のついて整理してみる８（）
________________________________________________________________________________________________

## dispatchIf / dispatchUnless
https://readouble.com/laravel/8.x/ja/queues.html  
https://laravel.com/docs/8.x/queues  

条件付きでジョブをディスパッチする場合は、dispatchIf メソッドと dispatchUnless メソッドが使用できます。
```php
ProcessPodcast::dispatchIf($accountActive, $podcast);

ProcessPodcast::dispatchUnless($accountSuspended, $podcast);
```



