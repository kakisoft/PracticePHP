【Laravel】カオス化するルーティング情報の整理に、「Laravel Router」はどうでしょう。

________________________________________________________________________
## Laravel のルーティングについて

通常通り書いていくと、画面との疎通なら routes\web.php、  
API との疎通なら routes\api.php を使いますが、  
機能が増えていくと、どんどんカオス化して手が付けられなくなってきます。  

そこで、ルーティング情報の整理に、Laravel Router はどうでしょう。  


## Laravel Router って？
これ。  
https://github.com/sebastiaanluca/laravel-router  

用は、ルーティング情報を api.php １つだけでなく、分割して記述する事ができるようになる。  

APIのバージョン切り分けをしたい時に特に有効。  


## 使い方

composer を使ってインストール。
### インストール
```
composer require sebastiaanluca/laravel-router

composer install
```

app\Http\Kernel.php にて Laravel Router を参照
## app\Http\Kernel.php
```php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use SebastiaanLuca\Router\Kernel\RegistersRouters;  //これを追加

class Kernel extends HttpKernel
{
    use RegistersRouters;    //これを追加
```

app\Http\Kernel.php に、追加したいルーティング情報を記述。  
（今回の例では、V1SamplesRouters と V2SamplesRouters）  

新しく、protected $routers = [ ... の部分を追加します。  
## app\Http\Kernel.php
```php
    /**
     * The application routers to automatically boot.
     *
     * @var array
     */
    protected $routers = [
        \App\Http\Routers\Api\V1SamplesRouters::class,
        \App\Http\Routers\Api\V2SamplesRouters::class,
    ];
```

ルーティング内容を記述したファイル１。  
prefix を「 api/V1 」としています。  

app\Http 以下の階層に、「Routers\Api」というフォルダを作り、そこに格納しています。  
## app\Http\Routers\Api\V1SamplesRouters.php
```php
namespace App\Http\Routers\Api;

use App\Http\Controllers\SampleController;
use SebastiaanLuca\Router\Routers\Router;

class V1SamplesRouters extends Router
{
    /**
     * Samples Controller Routers
     */
    public function map(): void
    {
        $this->router->group(['middleware' => ['api'], 'prefix' => 'api/V1', 'as' => 'api.v1.'], function() {
            $this->router->get('samples/index',      [SampleController::class, 'index'])->name('index');
            $this->router->get('samples/show',       [SampleController::class, 'show'])->name('show');
            $this->router->post('samples/store',     [SampleController::class, 'store'])->name('store');
            $this->router->put('samples/update',     [SampleController::class, 'update'])->name('update');
            $this->router->delete('samples/delete',  [SampleController::class, 'delete'])->name('delete');
        });
    }
}
```

ルーティング内容を記述したファイル２。  
上記との差分は、prefix を「 api/V2 」としている点のみです。（ファイル名とクラス名以外を除く）  
## app\Http\Routers\Api\V2SamplesRouters.php
```php
namespace App\Http\Routers\Api;

use App\Http\Controllers\SampleController;
use SebastiaanLuca\Router\Routers\Router;

class V2SamplesRouters extends Router
{
    /**
     * Samples Controller Routers
     */
    public function map(): void
    {
        $this->router->group(['middleware' => ['api'], 'prefix' => 'api/V2', 'as' => 'api.V2.'], function() {
            $this->router->get('samples/index',      [SampleController::class, 'index'])->name('index');
            $this->router->get('samples/show',       [SampleController::class, 'show'])->name('show');
            $this->router->post('samples/store',     [SampleController::class, 'store'])->name('store');
            $this->router->put('samples/update',     [SampleController::class, 'update'])->name('update');
            $this->router->delete('samples/delete',  [SampleController::class, 'delete'])->name('delete');
        });
    }
}
```

## ルーティング内容
ルーティングキャッシュし、ルーティング情報を表示。  

```
$ php artisan route:list
+--------+----------+-----------------------+-----------------------------+----------------------------------------------+--------------------------------------+
| Domain | Method   | URI                   | Name                        | Action                                       | Middleware                           |
+--------+----------+-----------------------+-----------------------------+----------------------------------------------+--------------------------------------+
|        | DELETE   | api/V1/samples/delete | api.v1.delete               | App\Http\Controllers\SampleController@delete | api                                  |
|        | GET|HEAD | api/V1/samples/index  | api.v1.index                | App\Http\Controllers\SampleController@index  | api                                  |
|        | GET|HEAD | api/V1/samples/show   | api.v1.show                 | App\Http\Controllers\SampleController@show   | api                                  |
|        | POST     | api/V1/samples/store  | api.v1.store                | App\Http\Controllers\SampleController@store  | api                                  |
|        | PUT      | api/V1/samples/update | api.v1.update               | App\Http\Controllers\SampleController@update | api                                  |
|        | DELETE   | api/V2/samples/delete | api.V2.delete               | App\Http\Controllers\SampleController@delete | api                                  |
|        | GET|HEAD | api/V2/samples/index  | api.V2.index                | App\Http\Controllers\SampleController@index  | api                                  |
|        | GET|HEAD | api/V2/samples/show   | api.V2.show                 | App\Http\Controllers\SampleController@show   | api                                  |
|        | POST     | api/V2/samples/store  | api.V2.store                | App\Http\Controllers\SampleController@store  | api                                  |
|        | PUT      | api/V2/samples/update | api.V2.update               | App\Http\Controllers\SampleController@update | api                                  |
|        | GET|HEAD | api/user              | generated::twH9X166r9bVY9EG | Closure                                      | api                                  |
|        |          |                       |                             |                                              | App\Http\Middleware\Authenticate:api |
+--------+----------+-----------------------+-----------------------------+----------------------------------------------+--------------------------------------+
```

こんな感じで、API のバージョンごとにファイルを切り分ける事が出来ました。  

