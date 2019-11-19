## モデル
Eloquent モデル（エルクェントモデル？）と呼ばれていて SQL を意識しなくても直感的にデータが操作できるようになっている。

_________________________________________________________
## 準備
「.env」の設定  
「database/migrations/」内のファイル削除  
「database/database.sqlite」仮作成  
等  


_________________________________________________________
## マイグレーションの設定
```
（プロジェクトのルート階層にて）
php artisan make:model Post --migration

　↓

ファイルが作成される。
「database\migrations\2019_11_19_101723_create_posts_table.php」
など

　↓

作成された migrations ファイルを編集

　↓

php artisan migrate

------------------

（ Model作成（以下は「Post」という名称） 今回の例では、myblog の階層で実行。）
// その後にバージョン管理するためのマイグレーションファイルも作りたいので、 php artisan make:model Post --migration のようなオプションを付けてあげましょう。

（こんな感じのファイルが作成される）
database/migrations/2019_06_28_145931_create_posts_table.php
// up() がこのマイグレーションで行いたい処理
// down() はそれを巻き戻すための処理



------------------------------------------
（作成したテーブルを確認）
sqlite3 database/database.sqlite
.schema posts

.quit
```

_________________________________________________________
## モデルをインタラクティブに操作

### コンソールから入力
php artisan tinker

```php
//※デフォルトで名前空間が App になっている。

$post = new App\Post();
$post->title = 'title 1';
$post->body = 'body 1';
$post->save();

 -> true

//（内容確認）
APP\Post::all();
App\Post::all()->toArray();

```


### まとめて入力
設定
```php
class Post extends Model
{
    // MassAssignmentエラーを回避。（意図しないリクエストによって悪意のあるデータが挿入されてしまう脆弱性を緩和）
    // デフォルトでは有効。
    protected $fillable = ['title', 'body'];
}
```

```
App\Post::create(['title'=>'title 2', 'body'=>'body 2']);
```


### CRUD
```php
$post = new App\Post();

// id が 3 のデータを参照
APP\Post::find(3)->toArray();

// id が 1 より大きいデータを取得
APP\Post::where('id', '>', 1)->get()->toArray();

// 並び替え
APP\Post::where('id', '>', 1)->orderBy('created_at', 'desc')->get()->toArray();

// limit
APP\Post::where('id', '>', 1)->take(1)->get()->toArray();

// 更新
$post = APP\Post::find(3);
$post->title = 'title 3 updated';
$post->save();
APP\Post::all()->toArray();

// 削除
>>>$post
>>>$post->delete();
>>>APP\Post::all()->toArray();

```

________________________________________________________________
## SQLiteで確認
```
sqlite3 database/database.sqlite
select * from posts;
.quit
```





