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
App\Models\Post::all()->toJson();

```

_________________________________________________________
## SQLiteで確認
```
sqlite3 database/database.sqlite
select * from posts;
.quit
```


