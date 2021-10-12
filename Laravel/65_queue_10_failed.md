# failed

## ジョブが死んだ時に実行されるメソッド
https://readouble.com/laravel/6.x/ja/queues.html#cleaning-up-after-failed-jobs


```php
    /**
     * 失敗したジョブの処理
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // 失敗の通知をユーザーへ送るなど…
    }
```
