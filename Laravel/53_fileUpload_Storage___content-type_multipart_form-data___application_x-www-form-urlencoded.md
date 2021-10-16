
https://readouble.com/laravel/8.x/ja/filesystem.html

# Strage
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


_____________________________________________________________________________________________________________________
# ファイルアップロード  File Upload

## フォームから

「 enctype="multipart/form-data" 」が無いとエラーとなる。
### enctype="multipart/form-data"
```php
<form method="POST" action="uploadImagePublic" enctype="multipart/form-data">
```

### enctype なし
```php
<form method="POST" action="uploadImagePublic">
```
Base 64 に変換して保存、等の方法がある。  

content-type は、こうなる。  
デフォルトだと、「 application/x-www-form-urlencoded 」となる模様。
```log
[2021-10-16 16:24:32] local.INFO: array (
  'content-type' => 
  array (
    0 => 'application/x-www-form-urlencoded',
  ),
```


＜参考＞  
https://zenn.dev/mimikaki/articles/f129e9b4d30760  
https://stackoverflow.com/questions/4007969/application-x-www-form-urlencoded-or-multipart-form-data  


## _
https://www.tagindex.com/html_tag/form/form_enctype.html
```
multipart/form-data
データをマルチパートデータとして送信します。フォーム内にファイルの送信欄を配置する場合は、この形式を指定しておく必要があります。
````

