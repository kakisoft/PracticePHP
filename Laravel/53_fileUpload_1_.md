
https://readouble.com/laravel/8.x/ja/filesystem.html


```php
use Illuminate\Support\Facades\Storage;
```


## _
```php
imageName1=imageName1=request->file('image_1')->getClientOriginalName(). '.' . $request->file('image_1')->getClientOriginalExtension();

/*

$request->file('image_1')->getClientOriginalName()・・・ファイル名取得
getClientOriginalExtension()・・・ファイル拡張子取得

*/

```


## strage.php
```php
/**
 * ファイル保存に関する環境変数
 */

return [
    /**
     * 対象の保存先
     */
    'target_disc' => env('TARGET_DISC', 'local'),

];
```

