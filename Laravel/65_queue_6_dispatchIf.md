【Laravel】バックグラウンド処理のついて整理してみる８（ジョブ：dispatchIf）
________________________________________________________________________________________________

## 条件付きでジョブをディスパッチするメソッド「dispatchIf / dispatchUnless」
ジョブをディスパッチする時、登録するかどうかを条件で判断してくれる「dispatchIf」というメソッドがあるらしい。

### dispatchIf / dispatchUnless
https://readouble.com/laravel/8.x/ja/queues.html  
https://laravel.com/docs/8.x/queues  

以下、公式のサンプルソース。
```php
ProcessPodcast::dispatchIf($accountActive, $podcast);

ProcessPodcast::dispatchUnless($accountSuspended, $podcast);
```

しかし、これだけでは使い方がさっぱり。  

『第一引数に無名関数を渡し、それをポーリングして、true になったらジョブをキューに登録する』  
という動きを期待したが、特に説明は無いみたいだ。  

だって、単純に「第一引数に true を渡したらジョブをキューに登録。false を渡したら登録しない」という動作なら、  
if 文書けばいいじゃーん。わざわざこんなメソッド作る必要ねーよ。って多分全員思うから。  
```php
if($accountActive){
    ProcessPodcast::dispatch($podcast);
}
```

## Laravel のソースを読んでみる
多分、ここ。  

### framework\src\Illuminate\Foundation\Bus\Dispatchable.php
https://github.com/laravel/framework/blob/f13ae4cdec690028b9fab83c5e4cc140a80c042a/src/Illuminate/Foundation/Bus/Dispatchable.php#L27
```php
trait Dispatchable
{

//（中略）

    /**
     * Dispatch the job with the given arguments if the given truth test passes.
     *
     * @param  bool  $boolean
     * @param  mixed  ...$arguments
     * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        return $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }
```

第一引数に true を渡せばジョブにキューを放り込んでくれそうな気がするけど、false の時の動作がイマイチよく分からない。  

Fluent クラスの挙動が分かれはピンと来るんだろうけど、今の自分には読んでもさっぱり。


## 試しに動かしてみる
特定の URL を叩いたら dispatchIf をコールするという極めてシンプルなもの。

### routes\api.php
```php
// http://localhost:8000/api/dispatchIf-1
Route::get('dispatchIf-1', function(){
    \App\Jobs\MyJob01::dispatchIf(true);
    return 'dispatchIf-1';
});

// http://localhost:8000/api/dispatchIf-2
Route::get('dispatchIf-2', function(){
    \App\Jobs\MyJob01::dispatchIf(false);
    return 'dispatchIf-2';
});
```

キューはこんな感じになりました。
```
|  id   |  queue    |  payload
|:------|:----------|:-----------------------------------------
|  1    |  default  |  {"uuid":"acded","displayName":"MyJob01",
```

第一引数に true を渡したジョブはキューに登録されて、false を渡したジョブはキューに登録されていない。  

うん。
**何が嬉しいんだ。これ。**  

普通に if 文を使って分岐させればいいじゃねーか。  
もしくは早期リターンで返して dispatch を実行しないとか。  

存在意義が分からん・・・  


## 期待していた動き
「第一引数に無名関数を渡す。ポーリングし、false を返している間はキューにジョブを登録しないけど、  
true を返すようになったら登録する」  

という動き。  

コードで書くと、こんな感じ。
```php
$isSomeJobFinished = function ($id) {
    $jobStatus = App\Models\JobStatuses::find($id);
    return $jobStatus['is_finished'];
};


// http://localhost:8000/api/dispatchIf-3
Route::get('dispatchIf-3', function(){
    \App\Jobs\MyJob01::dispatchIf($isSomeJobFinished(1));
    return 'dispatchIf-3';
});
```

こんな感じに書いてもエラーにはならなかったし、何なら正常に動いたんだけど、  
しばらくして true を返すようになっても、ジョブが登録される、という動きは無かった。  

何のために存在しとんねん。このメソッド。  





