【Laravel】バックグラウンド処理のついて整理してみる４（ジョブとキュー）
________________________________________________________________________________________________

Event, Listener, Dispatcher, Job, Queue ...  

何やら複雑に絡み合う事が多い、バックグラウンドで処理をさせる時に使う事が多いパーツですが、結構いい加減に使っていたので整理してみました。  

___________________________________________________________________________
## 用語

### キュー（ Queue ）
ジョブを貯めておく箱。  
貯めておいたジョブを順番に処理する。  

### ジョブ（ job ）
キューに放り込まれる何らかの処理。  
ユーザが応答を待たず、バックグラウンドプロセスで動かしたいもの。  

___________________________________________________________________________

ジョブ → キューに溜まる → 溜まったキューを順番に処理する  

という流れになります。　　

# 使い方

## ジョブを作成
artisan コマンドで作成可能です。
```
php artisan make:job MyJob01
```

以下の階層にファイルが作成されます。
```
app
 └─Jobs
     └─MyJob01.php
```

## Job に処理したい内容を記述
Jabクラスの handle メソッドに、処理したい内容を記述します。  

とりあえずログを出力するだけの簡単な処理を追加。  

### Jobs\MyJob01.php
```php
class MyJob01 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//（中略）

    public function handle()
    {
        \Log::info(__METHOD__);
    }
}
```

## ジョブを起動する処理を追加
簡単に、「api/my-job01 の URL を叩くとジョブが起動する」という処理を追加。

### routes\api.php
```php
// http://localhost:8000/api/my-job01
Route::get('my-job01', function(){
    \App\Jobs\MyJob01::dispatch();
    return 'my-job01';
});
```

ブラウザから「api/my-job01」を叩くと、Job クラスの handle メソッドに記述した内容を実行します。  
（別に実行するのはブラウザからじゃなくてもいいけど）  


