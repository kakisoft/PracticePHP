# _
whereDoesntHave
```php
$query = $this->model
    ->whereDoesntHave('books', function ($query) {
        $query->where('title', 'like', '%猫%');
    })
    ->where('gender', '=', 1)
    ;
```

```sql
select
    *
from
    `authors`
where not exists (
                    select
                        *
                    from
                        `books`
                    where  `authors`.`id` = `books`.`author_id`
                      and  `title` like '%猫%'
                 ) 
  and `gender` = 1
```


## 「１対多」の、「１」の方
```php
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    // hasMany なので、メソッドは複数名
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
```

## 「１対多」の、「多」の方
```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    // 1対多なので、メソッドは単数形。（多対多なら、こっちも複数形）
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
```

```php
    /**
     * 【 概要 】
     * PHP の where メソッド等で設定したパラメータをセットした SQL文を返す
     *
     * 呼び出し方法：
     *     \App\Utils\DebugUtil::getEloquentSqlWithBindings($query);
     *
     * 使い方の例：
     *     -----【 PHP コード 】--------------------------------------------------------
     *     $query = $this->model->where('gender_type', '=', 1);
     *     $paramFilledSql = \App\Utils\DebugUtil::getEloquentSqlWithBindings($query);
     *     \Log::info($paramFilledSql);
     *
     *     -----【 戻り値 】-------------------------------------------------------------
     *     select * from `authors` where `gender_type` = 1
     *
     *     ※「`gender_type` = ?」でなく、PHPコードの where メソッドで指定した値がセットされた SQL が出力される
     *     -----------------------------------------------------------------------------
     */



    /**
     * Dump Query
     *
     * getEloquentSqlWithBindings の名前が長かったので、エイリアスとして設定。
     */
```


_______________________________________________________________________________________________________________________________________
# _

```php
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

_______________________________________________________________________________________________________________________________________

Artist
albums(): HasMany
songs(): HasManyThrough


Album
artist(): BelongsTo
songs(): HasMany


Playlist
songs(): BelongsToMany


Song
artist(): BelongsTo
album(): BelongsTo



親（BelongsTo）は単数形、
子（HasMany）は複数形

ただ、
belongsToMany だと話は変わるので、単に単数形か複数形かを意識。
　
メソッドはキャメルケースで。
playlists()
activityTypeCategories()
