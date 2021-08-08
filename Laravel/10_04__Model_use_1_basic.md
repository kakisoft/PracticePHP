# CRUD
https://laravel.com/docs/8.x/eloquent  

__________________________________________________________________________________________________________________
## Model 定義に使えるデータ型
[15_Model_use_data_type.md](./15_Model_use_data_type.md)  

__________________________________________________________________________________________________________________
## 戻り値の型

|  命令     |  戻り値                |  使用例                              |
|:----------|:----------------------|:------------------------------------|
|  find()   |  Model のオブジェクト   |  App\Model::find(1)                 |
|  first()  |  Model のオブジェクト   |  App\Model::where('id',1)->first()  |
|  get()    |  Collection クラス     |  App\Model::where('id',1)->get()    |
|  all()    |  Collection クラス     |  App\Model::all()                   |
|  where()  |  Builder クラス        |  App\Model::where('id',1)           |

__________________________________________________________________________________________________________________
## オブジェクトをセット
https://readouble.com/laravel/7.x/ja/container.html
```php
$this->model = app(Item::class);
$this->model = app()->make(Item::class);  // こっちの方が良さそう
```

```php
$query = $this->model->query();
$query->select(
    'id',
    'code',
    'name'
);
$query->where('owner_id', '=', $ownerId);
$query->where('name', 'like', '%' . $params['name'] . '%');
$query->orderBy('code', 'asc');
$query->paginate($limit);

$records = $query->get();             // Collection
$records = $query->get()->toArray();  // Array
```

__________________________________________________________________________________________________________________
## 発行したSQLをトレース

#### toSql() を使う
```php
$query = Post::latest()->toSql();
//=> "select * from `posts` order by `created_at` desc"


$query = \App\User::where('id', 1);
dd($query->toSql(), $query->getBindings());  // プレースホルダの値は「 getBindings() 」で取得
//=>
// "select * from `users` where `id` = ?"
// array:1 [▼
//   0 => 1
// ]
```

#### toSql() - 検証
```php
// latest - OK
$query = Author::latest()->toSql();

// where - OK
$query = Author::where('gender', '=', 1)->toSql();

// instance - OK
$author = new Author();
$query = $author->where('gender', '=', 1)->toSql();


// model - OK
$this->model = app()->make(Author::class);
$query = $this->model->where('gender', '=', 1)->toSql();

```

##### エラー
```
Object of class Illuminate\Database\Eloquent\Builder could not be converted to string
```
単にメソッド名を間違えてる可能性が。「 toSQL() 」とか。  


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


// create では id を指定できない？無視されてるみたい ⇒ seeder の中では有効
// また、create メソッドは、「fillable property」の影響を受ける。（id　を指定してレコードを登録できなかったり）
App\Post::create(['title'=>'title 2', 'body'=>'body 2']);
$post = new App\Models\Post::where('id', '>', 1);


Item::create([
    'id' => 1,
    'name' => 'London to Paris',
    'sub_name' => 'LP'
]);
```


## firstOrCreate / firstOrNew
// firstOrCreate でも id は指定できない？無視されてるみたい ⇒ seeder の中では有効
```php
Artist::firstOrCreate(['name' => 'Avril Lavigne']);
Artist::firstOrCreate(['name' => 'Justin Bieber']);
Artist::firstOrCreate(['name' => 'Taylor Swift']);

Artist::firstOrCreate(['id' => 11, 'name' => 'Avril Lavigne']);
Artist::firstOrCreate(['id' => 12, 'name' => 'Justin Bieber']);
Artist::firstOrCreate(['id' => 13, 'name' => 'Taylor Swift']);


//==========< firstOrCreate ：該当のレコードが無ければ作成 >==========
// インスタンスが戻り値として返ってくる
$item1 = Item::firstOrCreate([
    'name' => 'London to Paris',
    'sub_name' => 'LP'
]);

$item2 = Item::firstOrCreate(
    ['name' => 'London to Paris2'],
    ['sub_name' => 'LP2']
);

if ($item2->wasRecentlyCreated) {
    // This is a new Item
}
else{
    // This Item was found in the database
}

//==========< firstOrNew は、インスタンスの作成のみ >==========
$id = 3;
$item3 = Item::query()->where('id', '=', $id)->firstOrNew([
    'name' => 'name3',
    'sub_name' => 'sub_name3'
]);

// save でレコード作成
$item3->save();
```
bulkFirstOrCreate  
https://github.com/laravel/ideas/issues/1695  


## insert （Model を指定）
id を指定して insert できる
```php
// Model を直接操作
// insert メソッドは、「fillable property」の影響を受けない。（fillable 設定をしていても、id　を指定してレコードを登録できる）
Item::insert([
    'id' => 1,  // id を指定しなくても OK
    'name' => 'London to Paris4',
    'sub_name' => 'LP4'
]);


// インスタンスから
$requiredData = [
    'id'         => 1002,
    'name' => 'London to Paris1002',
    'created_at' => new \Carbon\Carbon()  // created_at が null になるので、明示する必要がある。（↑も同様）
];

$item = new Item();
$item->insert($requiredData);
```

## fill
key, value 形式で値を指定して値をセット。  
id の指定はできないみたい。  
```php
$user = new Item();
$user->fill([
    'name'     => 'London to Paris4',
    'sub_name' => 'LP4'
    ]);
$user->save();
```

## insert（DB を指定）
```php
DB::table('users')->insert([
    'name' => Str::random(10),
    'email' => Str::random(10).'@gmail.com',
    'password' => Hash::make('password'),
]);
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

//---[ first() ]---
$posts->name;
$posts->address;

//==========< 並び替え（order by） >==========
$posts = App\Models\Post::where('id', '>', 1)->orderBy('created_at', 'desc')->get()->toArray();


//==========< limit >==========
$posts = App\Models\Post::where('id', '>', 1)->take(1)->get()->toArray();


//==========< 新しい順に取得 >==========
$posts = Post::orderBy('created_at', 'desc')->get();

// created_at で新しい順に取ってくるという処理はよく行うので、latest() という書き方も用意されている。
// 以下で、上記と同一の意味。
$posts = Post::latest()->get();

// 件数とカラムを指定して、最新レコードを取得
$a1 = $this->model::latest()->select('name', 'email as user_email')->take($limit)->get()->toJson();


//==========< id を指定して、一意のレコードを参照 >==========
$post = App\Models\Post::find(1);     //findを使う場合、get や firstは不要
$post = App\Models\Post::find(1)->toArray();
$post = Post::findOrFail($id);        // データが見つからなかった場合、例外を返す。

// ※ 「toSql()」を使っても、where 文がトレースされない ※

//==========< カウント >==========
$comment = Comment::count();
$comment = Comment::where('post_id', 1)->count();
$comment = Comment::where('post_id', 2)->where('id', '>=', 4)->count();
$number_of_cleared_users = Question01RegistrationInformation::where('is_cleared', Question01RegistrationInformation::IS_CLEARED___TRUE)->count();


//==========< 最大値 >==========
$max = App\Flight::where('active', 1)->max('price');


//==========< 複数条件を指定 >==========
$query = Question01RegistrationInformation::query();
$query->where('name', $name);  // 記号を省略した場合、暗黙的に '='
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



//==========< パラメータ次第でwhere条件を付加 >==========
$query = $this->model->query();
$query->select('item_id', 'name');
// アイテムID
if (isset($params['item_id'])) {
    $query->where('item_id', $params['item_id']);
}
// 商品名
if (isset($params['name'])) {
    $query->where('name', 'like', "%{$params['name']}%");
}



//==========< with句を使ってリレーションを取得（取得内容は入れ子になる） >==========
/*
    [0] => Array
        (
            [id] => 1
            [title] => title01
            [body] => body01
            [comment] => Array
                (
                    [0] => Array(
                                   [post_id] => 1
                                   [body] => comment01
                                 )
                    [1] => Array
                        (
                            [post_id] => 1
                            [body] => comment02
                        )

                )
        )
*/


$query = Post::query();
$query->where('title', $params['title']);
$query->with(['comment' => function ($q) {   // ← Post（リレーション元）に、「comment」というリレーションを表現するメソッド名が必要。
    $q->select('post_id','body');  // ☆重要☆ キー項目を入れておかないと、上手く取れないみたいだぞ。
}]);
$query->select('id', 'title', 'body');  // ☆重要☆ キー項目を入れておいた方がいいみたいだぞ。


//-----( リレーションを表すメソッドの例 )-----
    public function comment() {
      return $this->hasMany(Comment::class);
    }
//-----------------------------------------


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
親子関係のあるデータをまとめて消したい場合、Migration クラスにて cascade を設定
```php
class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->string('body');
            $table->timestamps();

            $table
              ->foreign('post_id')
              ->references('id')
              ->on('posts')
              ->onDelete('cascade');
        });
    }
}
```

#### firstOrFail
モデルが見つからない時に、例外を投げたい場合もあります。  
これはとくにルートやコントローラの中で便利です。  
findOrFailメソッドとクエリの最初の結果を取得するfirstOrFailメソッドは、該当するレコードが見つからない場合にIlluminate\Database\Eloquent\ModelNotFoundException例外を投げます。
```php
$model = App\Flight::findOrFail(1);

$model = App\Flight::where('legs', '>', 100)->firstOrFail();
```

## 論理削除
```php
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();  // deleted_at が追加される
        });
    }
```
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes;  // このキーワードを入れると、削除処理は物理削除でなく、論理削除（deleted_atに日付が入る）となる。
    use HasFactory;

     protected $fillable = ['name', 'sub_name', 'cover', 'category_id'];
 }
```
ちなみに、migration ファイルに「$table->softDeletes()」を書かないと、Model クラスで「use SoftDeletes」を書いていても、物理削除として扱われるみたい。（試した）  


## forceDelete ：論理削除のカラムに対し、物理削除を実行
```php
Artist::whereIn('id', [4])->delete();
Artist::whereIn('id', [4])->forceDelete();

// 論理削除されたレコードを検索条件に含める場合は withTrashed を使うが、別に使わなくて↑のように書いても行けたぞ。
Artist::withTrashed()->whereIn('id', [5])->delete();
Artist::withTrashed()->whereIn('id', [5])->forceDelete();
```


## MERGE / UPSERT（未登録であれば insert、登録済みであれば update）
```php
// 第1引数：一致したかどうかの判定を行いたい変数（連想配列の形式）
// 第2引数：insertまたはupdateしたいデータを持つ変数（連想配列の形式）
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
# 生SQL




__________________________________________________________________________________________________________________
# トランザクション
https://readouble.com/laravel/5.4/ja/database.html

### 宣言
```php
use Illuminate\Support\Facades\DB;
```
### transaction で囲む
```php
    DB::transaction(function () use ($param1) {
        DB::table('comments')->where('id', 9)->update(['body' => $param1]);
        DB::table('comments')->where('id', 8)->update(['post_id' => null]);
    });
```

### transaction で囲む：try-catch - DB::transaction の戻り値で判断
```php
    try {
        $exception = DB::transaction(function () {
            DB::table('comments')->where('id', 9)->update(['body' => 'changed']);
            DB::table('comments')->where('id', 8)->update(['post_id' => null]);
        }, 5);  // トランザクションの再試行回数を指定可。試行回数を過ぎたら、例外が投げられる。

        if(is_null($exception)) {
            return true;
        } else {
            throw new Exception;
        }

    }
    catch(Exception $e) {
        return false;
    }
```

### transaction で囲む：try-catch - Exception に飛んだ内容で判断。（こっちのが楽）
```php
    try {
        $param1 = 'name01';
        $param2 = 'name02';

        DB::transaction(function () use ($param1, $param2) {
            Sample::insert(['id' => 1, 'name' => $param1]);
            Sample::insert(['id' => 1, 'name' => $param2]);

        });
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return false;
    }

```


### beginTransaction で開始宣言をする
コミット・ロールバックを手動で制御。
```php
        try{
            DB::beginTransaction();

            DB::table('comments')->where('id', 9)->update(['body' => 'changed']);
            DB::table('comments')->where('id', 8)->update(['post_id' => null]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

        }
```

__________________________________________________________________________________________________________________
# MassAssignmentエラーを回避
MassAssignment は意図しないリクエストによって悪意のあるデータが挿入されてしまう脆弱性のこと。  
Laravel ではデフォルトで有効。  

```
Add [name] to fillable property to allow mass assignment on [App\Models\Models\Item].
```

________________________________________________________________________________________________________
### 設定（ app/Models/ のファイルを編集）
```php
class Post extends Model
{
    // fillable は ホワイトリスト
    protected $fillable = ['title', 'body'];

    // guarded は ブラックリスト。
    protected $guarded = ['id', 'email','password'];

    //// マスキングするならこんな感じ？
    protected $maskedColumns = ['masked_column'];
}
```

________________________________________________________________________________________________________
## 属性キャスト
https://readouble.com/laravel/5.5/ja/eloquent-mutators.html

```php
class User extends Model
{
    // 
    protected $casts = [
        'is_admin' => 'boolean',
    ];
}

// ↓こんな感じで、取得した値を自動でキャストしてくれる
//
//   array(3) {
//     ["id"]=> int(1)
//     ["is_admin"]=> bool(false)
//   }
```
________________________________________________________________________________________________________

