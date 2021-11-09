## レスポンス
[30_1_Controlloer.md](30_1_Controlloer.md)


## Illuminate\Http\Response
```php
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class SampleAPI01Controller extends Controller
{
    public function index() {
        return response('message01', Response::HTTP_OK);
    }
}
```

