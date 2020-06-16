# CRUD

__________________________________________________________________________________________________________________
## 発行したSQLをトレース

#### toSql() を使う
```php
$query = Post::latest()->toSql();
//=> "select * from `posts` order by `created_at` desc"


$query = \App\User::where('id', 1);
dd($query->toSql(), $query->getBindings());
//=>
// "select * from `users` where `id` = ?"
// array:1 [▼
//   0 => 1
// ]
```

#### enableQueryLog / getQueryLog を使う
「get()」等の、値を取得するメソッドが必要みたい。  
　  
SQL実行前に DB::enableQueryLog() でクエリログを有効化し、  
SQL実行後に DB::getQueryLog() メソッドを利用する。  
クエリの内容や、実行時間を取得できる。
```php
\DB::enableQueryLog();

$all_post_records = Post::all();
$user = \App\User::where('id', 1)->get();
$latest_post_records = Post::latest()->take(5)->get();

dd(\DB::getQueryLog());
```


__________________________________________________________________________________________________________________
# クエリビルダ（生SQLに近い操作）
https://readouble.com/laravel/5.3/ja/queries.html  

```php
// これを追加
use Illuminate\Support\Facades\DB;

// ↑を追加しない場合、↓みたいに、先頭に「\」を付加。
\DB::table('comments')->where('post_id', '=', 2)->delete();
```


## 生SQLに近い形式（モデルを作成せず、テーブル名を指定する）
```php
//==========< クエリビルダ >==========
$query = DB::table('users')->select('name');
$users = $query->addSelect('age')->get();


//==========< SELECT >==========
$users = DB::table('users')->select('name', 'email as user_email')->get();


//==========< DISTINCT >==========
$users = DB::table('users')->distinct()->get();


//==========< COUNT >==========
$users = DB::table('users')->count();


//==========< MAX >==========
$price = DB::table('orders')->max('price');


//==========< WHERE >==========
$users = DB::table('users')
                ->where('votes', '>=', 100)
                ->get();

$users = DB::table('users')
                ->where('votes', '<>', 100)
                ->get();

$users = DB::table('users')
                ->where('name', 'like', 'T%')
                ->get();


//==========< IN / NOT IN >==========
$users = DB::table('users')
                    ->whereIn('id', [1, 2, 3])
                    ->get();


$users = DB::table('users')
                    ->whereNotIn('id', [1, 2, 3])
                    ->get();


//==========< BETWEEN >==========
$users = DB::table('users')
                    ->whereBetween('votes', [1, 100])->get();


//==========< AVG >==========
$price = DB::table('orders')
                ->where('finalized', 1)
                ->avg('price');


//==========< GROUP BY >==========
$users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count, status'))
                     ->where('status', '<>', 1)
                     ->groupBy('status')
                     ->get();


//==========< JOIN >==========
// INNER JOIN
$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

// LEFT JOIN
$users = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->get();


//==========< EXISTS/ NOT EXISTS >==========
return DB::table('orders')->where('finalized', 1)->exists();

return DB::table('orders')->where('finalized', 1)->doesntExist();


//==========< UPDATE >==========
DB::table('comments')
        ->where('id', 8)
        ->update(['body' => 'changed']);



//==========< DELETE >==========
DB::table('comments')->where('post_id', '=', 2)->delete();


```

__________________________________________________________________________________________________________________
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


//==========< カウント >==========
$comment = Comment::count();
$comment = Comment::where('post_id', 1)->count();
$comment = Comment::where('post_id', 2)->where('id', '>=', 4)->count();
$number_of_cleared_users = Question01RegistrationInformation::where('is_cleared', Question01RegistrationInformation::IS_CLEARED___TRUE)->count();


//==========< 最大値 >==========
$max = App\Flight::where('active', 1)->max('price');


//==========< 複数条件を指定 >==========
$query = Question01RegistrationInformation::query();
$query->where('name', $name);
$query->where('id', '>=', 10);
$query->where('is_cleared', Question01RegistrationInformation::IS_CLEARED___TRUE);
$query->whereIn('id',[14, 15, 16]);
$registration_information = $query->get();


//==========< or条件 >==========
$comments->where(function($comments) use ($q){
    $comments->where('title', 'LIKE', "%$q%")
    ->orWhere('comment_body', 'LIKE', "%$q%");
});


// 性別：男 and  (10才以下 or スコアが70以上) のユーザーリスト
$user_list = $UserModel::where('sex' , 'male')
　　->where(function($query){
　　　　$query->where('age', '<', 10)
　　　　　　->orWhere('score', '>', 70);
　　})
　　->get()->toArray();
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

