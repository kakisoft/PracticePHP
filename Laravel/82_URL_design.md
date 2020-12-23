## LaravelでRest Full APIのルーティング
https://webty.jp/staffblog/production/post-2190/

|  HTTPメソッド   |  URI                       |  アクション    |  役割           |
|:---------------|:---------------------------|:--------------|:----------------|
|  GET           |  /コントローラ名            |  index         |  一覧表示       |
|  GET           |  /コントローラ名/create     |  create        |  新規作成ページ  |
|  POST          |  /コントローラ名            |  store         |  新規作成       |
|  GET           |  /コントローラ名/{id}       |  show          |  読み込み       |
|  GET           |  /コントローラ名/{id}/edit  |  edit          |  編集ページ     |
|  PUT/PATCH     |  /コントローラ名/{id}       |  update        |  更新          |
|  DELETE        |  /コントローラ名/{id}       |  destroy       |  削除          |


## API 例
↑の形からは、ちょっと変えてる。
```php
Route::get('product/index', [\App\Http\Controllers\Api\Internal\ProductController::class, 'index']);
Route::get('product/show', [\App\Http\Controllers\Api\Internal\ProductController::class, 'show']);
Route::post('product/store', [\App\Http\Controllers\Api\Internal\ProductController::class, 'store']);
Route::put('product/update', [\App\Http\Controllers\Api\Internal\ProductController::class, 'update']);
Route::delete('product/destory', [\App\Http\Controllers\Api\Internal\ProductController::class, 'destory']);
Route::put('product/downloadCsv', [\App\Http\Controllers\Api\Internal\ProductController::class, 'downloadCsv']);
Route::put('product/bulkUpdateFromCsv', [\App\Http\Controllers\Api\Internal\ProductController::class, 'bulkUpdateFromCsv']);
```


