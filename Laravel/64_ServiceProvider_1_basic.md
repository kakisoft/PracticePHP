# サービスプロバイダ : ServiceProvider
サービスコンテナへのバインド処理で利用する機能。　　

Laravel のライフサイクルでは、ビジネスロジックが実行される前にサービスプロバイダが呼ばれる。
この他にも、ミドルウェアなど、開発者が処理を差し込めるタイミングが複数あるが、サービスプロバイダは、
フレームワークやアプリケーションに含まれるサービス（機能）の初期処理を行う目的で用意されている。

主な役割は３つ。

 * サービスコンテナへのバインド
 * イベントリスナーやミドルウェア、ルーティングの登録
 * 外部コンポーネントを読み込む

読み込むサービスプロバイダは config/app.php に定義する。

## config/app.php
```php
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
        App\Providers\DataBaseQueryLogProvider::class,
    ],
```

