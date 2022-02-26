==================================================================================
各種テーブルのcreated_by、updated_by、deleted_byに関してですが、現状値が設定されていないという問題があり、
それらの項目を開発者があまり意識せずに登録される仕組みを作りました。
feature/shareに入れようと思うのですが、その前にどの様な作りとしたかご説明させて頂いた方が良いかなと思いますので、お時間いただけますでしょうか？
昨日こちらの内容についてお話ししたときに挙がっていた、参考にした文献です。
https://qiita.com/maimai-swap/items/6597c04721adbc48fec2
https://qiita.com/APPLE_PIE/items/e17be805443a84441329
（他にもいくつか参考にしたのですが、結局これに落ち着きました）
==================================================================================




## app\Observers\AuthorObserver.php
```php
namespace App\Observers;

use App\Facades\BackendSession;
use Illuminate\Database\Eloquent\Model;

class AuthorObserver
{
    public function creating(Model $model)
    {
        $model->created_by = BackendSession::getAuthorId();
    }

    public function updating(Model $model)
    {
        $model->updated_by = BackendSession::getAuthorId();
    }

    public function saving(Model $model)
    {
        $model->updated_by = BackendSession::getAuthorId();
    }

    public function deleting(Model $model)
    {
        $model->deleted_by = BackendSession::getAuthorId();
    }

    public function restoring(Model $model)
    {
        $model->deleted_by = null;
    }
}
```



## app\Models\SetItem.php
```php
class SetItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuthorObservable;
```




