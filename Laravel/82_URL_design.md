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

___________________________________________________________________________________________________
## LaravelでRest Full APIのルーティング（案）
↑の形からは、ちょっと変えてる。

|  役割      |  HTTPメソッド  |  URI                     |  アクション    |
|:----------|:---------------|:-------------------------|:--------------|
|  一覧表示  |  GET           |  /コントローラ名/index    |  index        |
|  １件表示  |  GET           |  /コントローラ名/show     |  show         |
|  新規作成  |  POST          |  /コントローラ名/store    |  store        |
|  更新      |  PUT           |  /コントローラ名/update   |  update       |
|  削除      |  DELETE        |  /コントローラ名/destroy  |  destroy      |


#### 親子関係がある場合
※アクション名において、コントローラ以下の階層を想定した連結は「 \_ 」を使用してください。（メソッド名は通常、キャメルケースで記述しますが、この場合のみ例外とします）  

|  役割      |  HTTPメソッド  |  URI                          |  アクション         |
|:----------|:---------------|:------------------------------|:-------------------|
|  一覧表示  |  GET           |  /company/department/index    |  department_index  |
|  １件表示  |  GET           |  /company/department/show     |  department_show   |



#### オブジェクトを起点に、下の階層のモデルを操作

|  役割      |  HTTPメソッド  |  URI                                |  アクション               |
|:----------|:---------------|:------------------------------------|:-------------------------|
|  一覧表示  |  GET           |  /company/staff/index               |  staff_index             |
|  １件表示  |  GET           |  /company/department/staff/show     |  department_staff_show   |


company/staff
company/department/staff


## API 例
コントローラ名は「単数形 + "Controller"」とし、パスカルケース（先頭大文字）とする。（Good：ArticleController　　Bad： ArticlesController ）  
また、コントローラ以下の階層の操作対象となるモデル名は、単数形とする。（コントローラ名に合わせる）  
```php
Route::get('company/index', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'index']);
Route::get('company/show', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'show']);
Route::post('company/store', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'store']);
Route::put('company/update', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'update']);
Route::delete('company/destroy', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'destroy']);
Route::get('company/downloadCsv', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'downloadCsv']);
Route::put('company/bulkUpdateFromCsv', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'bulkUpdateFromCsv']);

Route::get('company/department/index', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'department_index']);
Route::get('company/department/show', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'department_show']);

Route::get('company/staff/index', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'staff_index']);
Route::get('company/department/staff/show', [\App\Http\Controllers\Api\Internal\CompanyController::class, 'department_staff_show']);
```



