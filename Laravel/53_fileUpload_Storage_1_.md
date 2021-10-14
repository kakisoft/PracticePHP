
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


## _
https://placehold.jp/

https://placehold.jp/250x150.png

```php
        $this->storeRequestArray = [
            'title' => 'テスト',
            'description' => 'テスト',
            'photos' => [
                'photo' => [
                    'data:image/png;base64,'.base64_encode(file_get_contents('https://placehold.jp/250x150.png')),
                    'data:image/png;base64,'.base64_encode(file_get_contents('https://placehold.jp/250x150.png')),
                ],
                'id' => [],
            ],
        ];
```

______________________________________________________________________________
## ファイルのURL
```php
use Illuminate\Support\Facades\Storage;

$url = Storage::url('file.jpg');
```

______________________________________________________________________________

https://tektektech.com/laravel-storage-app-public/


"storage/app/public"

## オープンスペース有効化コマンド
```
php artisan storage:link
```

## config\filesystems.php
```php
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
```

ポート番号注意
## .env
APP_URL=http://localhost
APP_URL=http://localhost:8000




