## モデルをインタラクティブに操作

### コンソールから入力
php artisan tinker

```
php artisan tinker

namespace App\Models;
Post::all();
```

```php
//※デフォルトで名前空間が App になっている。

$post = new App\Models\Post();
$post->title = 'title 1';
$post->body = 'body 1';
$post->save();

 -> true

//（内容確認）
App\Models\Post::all();
App\Models\Post::all()->toArray();
```

________________________________________________________________________
# MassAssignmentエラーを回避

### まとめて入力（ MassAssignment 設定を変更）
設定（ app/Models/ のファイルを編集）
```php
class Post extends Model
{
    // MassAssignmentエラーを回避。（意図しないリクエストによって悪意のあるデータが挿入されてしまう脆弱性を緩和）
    // デフォルトでは有効。
    protected $fillable = ['title', 'body'];

    // fillable は ホワイトリスト、guarded は ブラックリスト。
    protected $guarded = ['id', 'email','password'];
}
```

```
App\Post::create(['title'=>'title 2', 'body'=>'body 2']);
```

$post = new App\Models\Post::where('id', '>', 1);
### CRUD
```php
$post = new App\Models\Post();

// id が 3 のデータを参照
App\Models\Post::find(1)->toArray();

// id が 1 より大きいデータを取得
App\Models\Post::where('id', '>', 1)->get();
App\Models\Post::where('id', '>', 1)->get()->toArray();

// 並び替え
App\Models\Post::where('id', '>', 1)->orderBy('created_at', 'desc')->get()->toArray();

// limit
App\Models\Post::where('id', '>', 1)->take(1)->get()->toArray();

// 更新
$post = App\Models\Post::find(1);
$post->title = 'title 3 updated';
$post->save();
App\Models\Post::all()->toArray();

// 削除
$post->delete();
App\Models\Post::all()->toArray();

```

## _
```php
App\Models\Post::where('id', 2)->update(['title' => 'after']);
```


_________________________________________________________
## SQLiteで確認
```
sqlite3 database/database.sqlite
select * from posts;
.quit
```

