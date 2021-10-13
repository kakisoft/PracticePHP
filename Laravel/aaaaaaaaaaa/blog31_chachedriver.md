【Laravel】キャッシュドライバをdatabase にする場合、chache のテーブルは２つ必要

____________________________________________________________

Laravel でキャッシュドライバを使用する場合、Redis や Memcached の他にも、RDBを使用する事が出来ます。  
具体的には、.env にて以下のように設定します。
```
CACHE_DRIVER=database
```

スケジューラやジョブについて調査したい時、管理先を RDB にしておくと、中で何をやっているのかトレースしやすいので、シビアな処理速度が求められないのであれば、この設定は全然アリだと思っています。  
（スケジュールからコマンドを実行する時、内部的にキャッシュドライバを使用している）  

が、ある日、こんなエラーが発生しました。  
```
PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'cache_locks' doesn't exist in /application/vendor/laravel/framework/src/Illuminate/Database/Connection.php:485
Stack trace:
```

cache_locks というテーブルが無いとな？  

ちなみに cache で使うテーブルは、以下の内容で登録済み。  

```php
Schema::create('cache', function ($table) {
    $table->string('key')->unique();
    $table->text('value');
    $table->integer('expiration');
});
```

コンフィグでも、対象のテーブルに誤りがない事を確認。  

### config\cache.php
```php
    'database' => [
        'driver' => 'database',
        'table' => 'cache',
        'connection' => null,
    ],
```

cache_locks など使っている覚えなど無いのに、これはどこから？  

と思って調べてみたら、どうやらアトミックロックにて使用するらしい。  

（公式）  
https://www.oulub.com/docs/laravel/ja-jp/cache#atomic-locks  


> アトミックロックは、競合状態を心配することなく、分散ロックの操作を可能にします。
> たとえば、 Laravel Forge はアトミックロックを使用して、サーバー上で一度に1つのリモートタスクのみが実行されるようにします。 
> Cache::lockメソッドを使用してロックを作成および管理できます：


追加する内容、こんな感じ。  
```php
Schema::create('cache_locks', function ($table) {
    $table->string('key')->primary();
    $table->string('owner');
    $table->integer('expiration');
});
```

どうやら、分散ロックを実現する場合、コレが必要になるらしい。  

ローカルで実行した時はエラーが発生しなかったが、AWS 上にデプロイした時には発生したので、恐らく、ECS等で複数コンテナで動いている時のみ発生する可能性があると思われます。  
（詳細未調査）  

「固定で 'cache_locks' というテーブル名なの？」と思い、Laravel のソースを見てみましたが、デフォルトだとその名前のようです。  

使用するテーブル名は「config\cache.php」にて変更可。  

## framework\src\Illuminate\Cache\CacheManager.php
Laravel フレームワークのソース
```php
    /**
     * Create an instance of the database cache driver.
     *
     * @param  array  $config
     * @return \Illuminate\Cache\Repository
     */
    protected function createDatabaseDriver(array $config)
    {
        $connection = $this->app['db']->connection($config['connection'] ?? null);

        $store = new DatabaseStore(
            $connection,
            $config['table'],
            $this->getPrefix($config),
            $config['lock_table'] ?? 'cache_locks',
            $config['lock_lottery'] ?? [2, 100]
        );

        return $this->repository($store->setLockConnection(
            $this->app['db']->connection($config['lock_connection'] ?? $config['connection'] ?? null)
        ));
    }
```

### config\cache.php

```php
    'stores' => [

//（中略）

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'lock_table' => 'cache_locks',
            'connection' => null,
        ],
```

