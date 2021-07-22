## コントローラにおける、コンストラクタの引数
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\Item;

class ItemsController extends Controller
{
    //// 【 コントロールにおける、コンストラクタの引数 】
    // 特に特別は工夫は不要みたい。Laravel の DIがいい感じにやってくれるっぽい。
    public function __construct(Item $item)
    {
        $a1 = $item->find(1);
dump($a1);

dump("__construct");
    }
```

