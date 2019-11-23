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
＜ プロジェクトのルート階層にて実行 ＞

（ Model作成。以下は「Post」という名称 ）
// バージョン管理するためのマイグレーションファイルも作る場合、  --migration オプションを付与。
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


## Models 階層に作成
php artisan make:model Models/Post                   # app/Models  に、ファイルが生成される。
php artisan make:migration create_posts_table        # database/migrations/yyyy_mm_dd_hhmmss_create_posts_table.php に、ファイルが生成される。
php artisan migrate                                  # DBにその内容が反映される。


------------------------------------------
（作成したテーブルを確認）
sqlite3 database/database.sqlite
.schema posts

.quit
```

_________________________________________________________
## 巻き戻し
```
php artisan migrate:rollback


php artisan migrate:rollback --step=1
```

_________________________________________________________
## リセット（手動）
 * Modelを削除（app/Post.php 等）
 * migrationsファイルを削除（database\migrations/2019_11_20_101202_create_posts_table.php 等）
 * DBを削除（database/database.sqlite 等）


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





