【Laravel】.env を直接読み込ませるのは、アンチパターンなだけでなく、挙動でもおかしい部分が出てくるので、絶対に避けよう！

laravel-env-read-trap

________________________________________________________________________________________________________
**【 環境 】**
**Laravel のバージョン： 8.16.1**
**PHP のバージョン： 7.4.7**

Laravel において、
「 .env の値を参照する時、直接読み込ませず、config を経由する」
というのは、Laravel ベストプラクティスにおける「[.envファイルのデータを直接参照しない](https://github.com/alexeymezenin/laravel-best-practices/blob/master/japanese.md#env%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%81%AE%E3%83%87%E3%83%BC%E3%82%BF%E3%82%92%E7%9B%B4%E6%8E%A5%E5%8F%82%E7%85%A7%E3%81%97%E3%81%AA%E3%81%84)」にも記載されているので、基本はそれに準拠しておけばよいかと思います。

また、 .env を直接読み込ませると、単にメンテナンス性を悪化させるだけでなく、挙動にも怪しい部分がありました。

以下、検証した内容およびソースと設定です。

## 検証内容
local と production に「ENV_PARAM_SAMPLE01」というパラメータを設定。

#### .env.local
```
ENV_PARAM_SAMPLE01=.env.local
```

#### .env.production
```
ENV_PARAM_SAMPLE01=.env.production
```

config から env の内容を読み込む値を設定
#### config\myconfig01.php
```php
return [
    'env_param_sample01' => env('ENV_PARAM_SAMPLE01'),
];
```

「env を直接参照する処理」と
「config から env を経由して参照する処理」の２つを記述。
出力結果は、どちらも全く同じ結果になるはず。
#### routes\api.php
```php
Route::get('env', function(){
    echo "ENV_PARAM_SAMPLE01 from .env  : " . env('ENV_PARAM_SAMPLE01') . PHP_EOL;
    echo "ENV_PARAM_SAMPLE01 from .conf : " . config('myconfig01.env_param_sample01') . PHP_EOL;
    return;
});
```

#### OSの環境変数設定
local → production に変更
```
export APP_ENV="production"
```

#### キャッシュをクリア
設定を変更したので、キャッシュをクリア
```
php artisan config:clear
php artisan config:cache
```

#### 実行結果
```
$  curl -s http://localhost:8000/api/env
ENV_PARAM_SAMPLE01 from .env  :
ENV_PARAM_SAMPLE01 from .conf : .env.production
```
・・・と、こんな感じで、全く値を参照しているにもかかわらず、異なる結果が出てしまいました。

ちなみに、思いつく限りのキャッシュクリアコマンドを叩いたが、結果は変わらず。

何か色々試してみたら何とか同じ値を出力するようになったんだけど、そんな余計な事に労力をかけるより、素直に config を経由した方がいい。


## 結論
Laravel を使う時、.env を直接参照すると、メンテナンス性を悪化させるだけでなく、挙動にも怪しい部分があるので、**絶対に** config を経由するようにしよう！

「こんな感じで動くか、ちょっと試してみよう」というレベルの内容を書く時でも、config を経由した方が良さそうです。
自分はそれで余計な時間を溶かしました。


