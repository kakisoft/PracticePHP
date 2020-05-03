__________________________________________________________________________________________________________________
# CRUD

## CREATE（INSERT）
```php
$post = new App\Models\Post();
$post->title = 'title 1';
$post->body = 'body 1';
$post->save();



App\Post::create(['title'=>'title 2', 'body'=>'body 2']);
$post = new App\Models\Post::where('id', '>', 1);
```


## READ
```php
//==========< 全データを取得 >==========
$posts = App\Models\Post::all();
$posts = App\Models\Post::all()->toArray();
$posts = App\Models\Post::all()->toJson();


//==========< 条件を指定して参照（例：id が 1 より大きいデータを取得） >==========
$posts = App\Models\Post::where('id', '>', 1)->get();
$posts = App\Models\Post::where('id', '>', 1)->get()->toArray();
$posts = App\Models\Post::where('id', '>', 1)->first();


//==========< 並び替え（order by） >==========
$posts = App\Models\Post::where('id', '>', 1)->orderBy('created_at', 'desc')->get()->toArray();


//==========< limit >==========
$posts = App\Models\Post::where('id', '>', 1)->take(1)->get()->toArray();


//==========< 新しい順に取得 >==========
$posts = Post::orderBy('created_at', 'desc')->get();

// created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
// 以下で、上記と同一の意味。
$posts = Post::latest()->get();


//==========< id を指定して、一意のレコードを参照 >==========
$post = App\Models\Post::find(1);     //findを使う場合、get や firstは不要
$post = App\Models\Post::find(1)->toArray();
$post = Post::findOrFail($id);        // データが見つからなかった場合、例外を返す。

```

## UPDATE
```php
// 更新（単一レコード）
$post = App\Models\Post::find(1);
$post->title = 'title 3 updated';
$post->save();
App\Models\Post::all()->toArray();


// 条件を指定して UPDATE
App\Models\Post::where('id', 2)->update(['title' => 'after']);
```

## DELETE
```php
// 削除
$post = App\Models\Post::find(1);
$post->delete();
App\Models\Post::all()->toArray();
```

## MERGE / UPSERT（未登録であれば insert、登録済みであれば update）
```php
$post = App\Models\Post::updateOrCreate(
                                           ['id' => 1]
                                          ,['title' => 'title 4', 'body' => 'body 4']
                                       );

// saveメソッドは、
// 新しい Eloquent のインスタンスを作って新規に保存する
// 既存の Eloquent のインスタンスを取得してから更新する
// という使い方をすることが想定されている。
```


__________________________________________________________________________________________________________________
# MassAssignmentエラーを回避
MassAssignment は意図しないリクエストによって悪意のあるデータが挿入されてしまう脆弱性のこと。  
Laravel ではデフォルトで有効。  

### 設定（ app/Models/ のファイルを編集）
```php
class Post extends Model
{
    // fillable は ホワイトリスト
    protected $fillable = ['title', 'body'];

    // guarded は ブラックリスト。
    protected $guarded = ['id', 'email','password'];
}
```

________________________________________________________________________________________________________

