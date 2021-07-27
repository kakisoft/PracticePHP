【Laravel】バックグラウンド処理のついて整理してみる１（イベントとリスナー）
________________________________________________________________________________________________


Event, Listener, Dispatcher, Job, Queue ...  

何やら複雑に絡み合う事が多いこれらの処理ですが、結構いい加減に使っていたので、整理してみる。  

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

 * Event（イベント）
 * Listener（リスナー）

この２つはセット。  

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
１から作らずとも、雛形を生成するコマンドがある。  
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
        MyEvent03::class => [
            MyListener03::class
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



