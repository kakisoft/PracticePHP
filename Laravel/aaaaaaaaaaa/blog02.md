【Laravel】バックグラウンド処理のついて整理してみる１（イベントとリスナー）
________________________________________________________________________________________________


Event, Listener, Dispatcher, Job, Queue ...  

何やら複雑に絡み合う事が多い、バックグラウンドで処理をさせる時に使う事が多いパーツですが、結構いい加減に使っていたので整理してみました。  

___________________________________________________________________________
## 用語

### イベント（ Event ）
何かしらの動作や変更などが発生した際に発信されるもの。   
発生時の情報をオブジェクトとして表現する。  

### リスナー（ Listener ）
イベントに対応する処理を実行する機能。  

サーバサイドで同期的に処理 or キューと組み合わせて非同期で実行可。  

### ディスパッチャー（ Dispatcher ）
イベントを発行する機能。  
リスナークラスの実装次第で、サーバサイドでリスナーを起動させるか、socket.io（websocket）を通してWebブラウザに実行させるかをディスパッチャーが振り分ける。  

また、event ヘルパー関数を通して利用する事もできる。  

___________________________________________________________________________
## イベントとリスナーについて

 * イベント（Event）
 * リスナー（Listener）

この２つはセット。  

イベントを定義し、それを検知するためのリスナーを定義する、という関係。

app\Providers\EventServiceProvider.php  
にて、登録されたイベントリスナーを確認できる。  

#### 例：app\Providers\EventServiceProvider.php
```php
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PublishProcessor::class => [   // Eventクラス
            MessageSubscriber::class   // Event に対応する Listener クラス
        ],
        ReviewRegistered::class => [
            ReviewIndexCreator::class
        ],

        'App\Events\AccessDetection' => [  // こういう書き方もできる
            'App\Listeners\AccessDetectionListener',
        ]

    ];
```

登録されたイベント一覧は、以下のコマンドで確認できる。  

```
php artisan event:list
```

#### 出力例

+--------------------------------+---------------------------------------+
| Event                          | Listeners                             |
+--------------------------------+---------------------------------------+
| App\Events\AccessDetection     | App\Listeners\AccessDetectionListener |
| App\Providers\PublishProcessor | App\Providers\MessageSubscriber       |
| App\Providers\ReviewRegistered | App\Providers\ReviewIndexCreator      |
+--------------------------------+---------------------------------------+


## generate コマンドによる、イベントとリスナーの作成
１から作らずとも、雛形を生成するコマンドが用意されている。  
コマンドは大きく分けて２種類。  

 * １．イベントとリスナーを同時に作成（今は主流ではない？）
 * ２．イベントを作成するコマンド、リスナーを作成するコマンドを、個別に打つ。（今はこっちが主流みたい。階層分けができる）


詳細は以下。  

### １―１．イベントとリスナーを同時に作成する（クラスを記述）
ただし、こっちは現在では主流ではないっぽい。  

欠点としては、「app\Providers」の階層にイベントとリスナーが作成される。  

**作り方**  
「EventServiceProvider.php」に、作成したいイベントとリスナーを定義する。  
(この時点では、"MyEvent01", "MyListener01" は、プロジェクト内に存在しない。)  

#### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        // 追記した部分
        MyEvent01::class => [
            MyListener01::class
        ],

    ];
```

記述後、コマンドを入力。
```
php artisan event:generate
```

以下の階層にファイルが生成される。  
```
app
 └─Providers
     ├─MyEvent01.php
     └─MyEvent01.php
```

Providers と同じ階層に作成されるので、ちょっと整理しづらい。  

あと、イベントとリスナーが増えた時にはカオス化しそう。  


### １―２．イベントとリスナーを同時に作成する（クラスのパスを記述）
以下の方法で、「Event」「Listener」の階層に分ける事が出来る。  

EventServiceProvider.php の $listen を、クラス名でなく、クラスが存在する（generate コマンドで生成される予定の）パスを指定できる。  
（この時点で、"MyEvent02", "MyListener02" は、プロジェクト内に存在しない。）


#### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        // 追記した部分
        'App\Events\MyEvent02' => [
            'App\Listeners\MyListener02',
        ],

    ];
```

記述後、コマンドを入力。
```
php artisan event:generate
```

以下の階層にファイルが生成される。  
```
app
 ├─Events
 │   └─MyEvent02.php
 │
 └─Listeners
     └─MyListener02.php
```
パスを文字列で指定しているので、IDE によるコードジャンプが使えないと、人によっては好みが分かれそう。  
自分は断然、IDEの機能の恩恵を最大に享受したい派。  

オープンソースを見渡しても、この方法でイベントとリスナーを結び付けている人は少数派っぽい。  


### ２．イベントとリスナーを個別に作成
イベントを作成するコマンド。  

ファイルが作成される位置を、「App/Events」の階層に指定できる。  
```
php artisan make:event App\\Events\\MyEvent03
```

リスナーを作成するコマンド。  

ファイルが作成される位置を指定せずとも、「App/Listeners」の階層に作成される。  
何だか、ちぐはぐだ。  

「--event」オプションで、結び付けたいイベントを指定します。
```
php artisan make:listener MyListener03 --event MyEvent03
```

作成されるファイルは、こんな感じになります。
```
app
 ├─Events
 │   └─MyEvent03.php
 │
 └─Listeners
     └─MyListener03.php
```

その後、$listen に、イベントとリスナーのセットを追加。  

#### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        // 追記した部分
        MyEvent03::class => [
            MyListener03::class
        ],

    ];
```

use を指定するのが面倒な場合はフルパスで。

#### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        // 追記した部分
        \App\Events\MyEvent03::class => [
            \App\Listeners\MyListener03::class
        ],

    ];
```


個別にセットしなくても、以下のコードを追記すると、自動でイベントとリスナーを拾ってくれます。

#### app\Providers\EventServiceProvider.php
```php
class EventServiceProvider extends ServiceProvider
{
    public function shouldDiscoverEvents()
    {
        return true;
    }
```

意図しない動作が起こる危険性があるのでは？　と感じてしまったため、避けた方がいい気がしている。  

Laravel で作成されたオープンソースをざっと見てみたところ、あまり使われていないみたいだ。  
あと、わざわざ「return false」と明示しているソースもあった。  
多分、何かと問題があったんだろう。  

という事で、「$listen」に登録しておく方が良さそうです。  
個人的にも、その方が分かりやすくて助かる。  


## その他のイベントの登録方法
他にも、こんな方法があるみたい。

#### app\Providers\EventServiceProvider.php
```php
    public function boot()
    {
        parent::boot();

        Event::listen(
            MyEvent03::class,
            MyListener03::class
        );

        $this->app['events']->listen(
            MyEvent04::class,
            MyListener04::class
        );
    }
```

何でこんなにいっぱい方法があるのかは謎だ。  

あちこちに書くと乱雑になってメンテしづらくなるので、全部「protected $listen」に記述した方がいいんじゃないか。  

こんな感じで、MyEvent03 と MyListener03 が結びつける必要があります。

## イベントに処理を記述
イベントにメソッドを定義し、処理したい内容を記述。  

今回はシンプルに「myMethod01()」というメソッドを作成し、ログを出力する処理を追加。  
```php
class MyEvent03
{
//（中略）

    public function myMethod01()
    {
        \Log::info(__METHOD__);
        return;
    }

}
```

## リスナーに、イベントのメソッドをコールする処理を追加
リスナーの handle メソッドに、先ほどイベントに定義したメソッドをコールする処理を追加。

```php
class MyListener03
{
//（中略）
    public function handle(MyEvent03 $event)
    {
        $event->myMethod01();
    }
}
```


## イベントを呼び出す
手っ取り早く動かすために、routes\api.php に書いてみる。  

イベントの呼び出し方法には、以下の方法があります。  

### routes\api.php
```php
// http://localhost:8000/api/my-event03-1
// 方法１：event メソッドを使用する
Route::get('my-event03-1', function(){
    event(new \App\Events\MyEvent03());
    return 'my-event03-1';
});

// http://localhost:8000/api/my-event03-2
// 方法２：ディスパッチャーを使用する
Route::get('my-event03-2', function(){
    \App\Events\MyEvent03::dispatch();
    return 'my-event03-2';
});
```

イベントを発生させると、リスナーの handle メソッドがコールされます。  

その後、リスナーの handle メソッドから、イベントの myMethod01() をコールしています。  



## php artisan event:list で表示した時の注意点
EventServiceProvider.php の $listen に、存在しないイベントとリスナーを追加してみる。

### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        // 存在しないイベントと存在しないリスナーを記述
        NotExistEvent::class => [
            NotExistListener::class
        ],

    ];
```

この状態で、「php artisan event:list」を実行してイベントリストを見ると、以下のようになる。
```
> php artisan event:list
+-----------------------------+--------------------------------+
| Event                       | Listeners                      |
+-----------------------------+--------------------------------+
| App\Providers\NotExistEvent | App\Providers\NotExistListener |
+-----------------------------+--------------------------------+
```

何と、存在しないイベントとリスナーが、あたかもコールできるかのように見えてしまう。  

このコマンド、案外アテになら無さそうです。  

ちなみに存在するクラスだったとしても、EventServiceProvider.php から参照できなかったりすると、イベントをキックしてもリスナーまで処理されません。  

「あれ？　イベントを発生させているはずなのに、リスナーが動いてないぞ。」となった時は、真っ先にここを疑ってみるといいかもしれません。   







