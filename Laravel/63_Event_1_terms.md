#### イベント一覧を表示
```
php artisan event:list
```

________________________________________________________________________
## CQRS (Command Query Responsibility Segregation)：コマンドクエリ責務分析
書き込み（コマンド）と、読み込み（クエリ）は、別々に取り扱うべき、という考え方。（設計パターン）

________________________________________________________________________
## 用語

### イベント（ Event ）
何かしらの動作や変更などが発生した際に発信されるもの。   
発生時の情報をオブジェクトとして表現する。  

### リスナー（ Listner ）
イベントに対応する処理を実行する機能。  

サーバサイドで同期的に処理 or キューと組み合わせて非同期で実行可。  

### ディスパッチャー（ Dispatcher ）
イベントを発行する機能。  
リスナークラスの実装次第で、サーバサイドでリスナーを起動させるか、socket.io（websocket）を通してWebブラウザに実行させるかをディスパッチャーが振り分ける。  

また、event ヘルパー関数を通して利用する事もできる。  

________________________________________________________________________
## イベントクラスの雛形に含まれるトレイト

|  トレイト                                       |  内容                                                |
|:-----------------------------------------------|:-----------------------------------------------------|
|  Illuminate\Queue\InteractsWithQueue           |  Queue と組み合わせて非同期イベントを実行する時に利用    |
|  Illuminate\Foundation\Events\Dispatchable     |  イベントクラスにて Dispatcher として作用させる時に利用  |
|  Illuminate\Broadcasting\InteractsWithSockets  |  socket.io を使ってブラウザにイベント通知する時に利用    |


```php
class AccessDetection
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
```

```php
abstract class AbstractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; 
```

________________________________________________________________________
________________________________________________________________________
________________________________________________________________________
# aaa

「ユーザを追加した時、メールを送信するイベントを発火」みたいな用途とかも。  
（Observer でも可）  

```php
class User extends Model
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AncientScope);
    }
}
```


同じことを　Observer でも出来そう。
