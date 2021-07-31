【Laravel】バックグラウンド処理のついて整理してみる３（イベントとリスナーとキュー）
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

### キュー（ Queue ）
ジョブを貯めておく箱。  
貯めておいたジョブを順番に処理する。  

### ジョブ（ job ）
キューに放り込まれる何らかの処理。  
ユーザが応答を待たず、バックグラウンドプロセスで動かしたいもの。  

___________________________________________________________________________
## イベントとキューを組み合わせて使ってみる
前々回の続き。  

イベントとリスナーを使ったので、今度はイベントとキューを使ってみる。  

キューは database を使用しています。詳細は前回を参照。  

# 手順

## イベントとリスナーを作成

artisan コマンドで、イベントとリスナーを作成。
```
php artisan make:event App\\Events\\MyEvent04
php artisan make:listener MyListener04 --event MyEvent04
```

## イベントとリスナーを登録。

### app\Providers\EventServiceProvider.php
```php
    protected $listen = [

        \App\Events\MyEvent04::class => [
            \App\Listeners\MyListener04::class
        ],

    ];
```

## リスナークラスに「implements ShouldQueue」を追加。
クラス名の末尾に追記。

### app\Listeners\MyListener04.php
```php
class MyListener04 implements ShouldQueue
{
```

## イベントを呼び出す処理を追加
前回同様、routes\api.php に書いてみる。  
my-event04 の URL を叩くとイベントが起動するようにしています。  

### routes\api.php
```php
// http://localhost:8000/api/my-event04
Route::get('my-event04', function(){
    \App\Events\MyEvent04::dispatch();
    return 'my-event04';
});
```

## 設定ファイルとルーティングのキャッシュをクリア　※重要※
キャッシュをクリアしないと、変更内容が反映されない事があります。
```
php artisan cache:clear
php artisan route:clear
```

その後、  
「http://localhost:8000/api/my-event04」  
の URL を叩く。  

## キューの内容
キューを database に指定していると、「jobs」というテーブルを参照すると、キューに溜まった内容を確認できます。

### jobs
payload の中身は長いので、適当な位置で切っています。

|  id   |  queue    |  payload                                                                               |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:---------------------------------------------------------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  1    |  default  |  {"uuid":"fb5ef934-a918","displayName":"MyListener04","job":"CallQueuedHandler@call",  |  0         |  « NULL »     |  1627686058    |  1627686058  |


## キューワーカーを起動
キューを捌くためのコマンドを実行
```
php artisan queue:work
```

こうやって始めて、リスナーの handle メソッドが動くようになります。  
ワーカー実行後は、jobs テーブルのレコードが削除されます。（redis や file を使用している場合、key と value が削除されます）  

こんな感じでリスナーにログを出力する処理でも記述しておくと、  
「イベントが発火した瞬間は、ログに何も出力されない」  
「キューのワーカーを動かすと、ログに出力される」  
という動作が確認できます。  

### app\Listeners\MyListener04.php
```php
    public function handle(MyEvent04 $event)
    {
        \Log::info(__METHOD__);
    }
```

