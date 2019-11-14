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





