【Laravel】（Alpine）Redis を使う時のライブラリ、Predis と PhpRedis を試してみる

______________________________________________________
**【 環境 】**  
**Laravel のバージョン： 8.16.1**  
**PHP のバージョン： 7.4.7**  

## Laravel で Redis を使う時のライブラリ
Laravel で Redis を使う時、PHP のライブラリに以下の２つの候補が出てくる。  

 * [Predis](https://github.com/predis/predis)
 * [PhpRedis](https://github.com/phpredis/phpredis)

デフォルトだと、composer.lock に「predis」が記述されている。

#### composer.lock
```php
    "packages": [
        {
            "require-dev": {
                "predis/predis": "^1.1.2",
                "symfony/cache": "^5.1.4"
            },
```

しかし、config\database.php には「phpredis」が記述されている。

#### config\database.php
```php
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
```

何なんだこの中途半端な状態は。  

と思って調べたら、predis はデフォルトから外される予定だったけど、やっぱ外すのやめたーって事になり、とはいっても phpredis を推奨したいし・・・  
といった感じで、どっちつかずの状態になっているみたい。  


## どちらを採用するべき？
どちらを使えばいいのかについては議論が活発なようで、こんなのがありました。  

[PHP向けRedisクライアントのpredisを使うのは止めた方がいいです](https://yoshinorin.net/2019/08/28/predis-not-maintain/)  

> predisはPHP向けのRedisクライアントです。
> リポジトリを見て察しのいい方は気づいたと思うのですが、2年ぐらいメンテ（コミットすら）されていません。
> すでにPHP7.3周りで問題が出てます。これが「どういった事情でメンテされていないのか？」「されないのではなく、できないのか？」などは誰もわからないと思いますし、もしかしたら将来的に再度メンテされる可能性はありえます。

（2021年7月現在、無事開発は再開されているようです。）

> Laravelのドキュメントにも書いてありますが、phpredis使えばいいと思います。こちらはcomposerでインストールできない（PHP拡張モジュールなので）のでpeclでインストールします。

いやああああ！！！  
マジなの？　令和にもなって、PHPライブラリを composer でインストールできないとか正気なの？？  

さすがに今では改善されているんじゃ・・・と思って公式サイトを除いてみたが、PhpRedis 公式のインストールガイドを見てみた。  
が、pecl を使えという夢も希望も無いメッセージが。  
(https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown)[https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown]  

こんなのもあった。  
[How to install phpredis using composer? ](How to install phpredis using composer? )  

> I need to install phpredis using composer on windows server running IIS. What is the package name for this?

> You cannot.
> Composer is for pure-PHP library not for C extension (pickle will do it later)

>  You need to compile it! See more information here: 

どうやら composer でインストールするのは絶望的で、今後もできるようになる可能性は限りなくゼロに近そう。  

念のため、他の記事も参考にしてみた。  
[Laravel 8のRedisクライアントのパフォーマンスの比較](https://tdomy.com/2020/11/redis-client-comparison/)  

性能比較をして、PhpRedis の方が上だった模様。  

> 上記のコマンドをそれぞれ50回実行し、平均（±標準偏差）を算出しました。
>
> * PhpRedis … 1.317 ± 0.03 (秒)
> * Predis … 1.509 ± 0.026 (秒)
>
> Predisを使用した場合の処理時間はPhpRedisの場合の約1割増しと、明らかに差がでました
> 
> Laravel 8 でPhpRedisとPredisを比較しました。PhpRedisの方が普通に速いので、導入できる環境であれば、Laravelの推奨に従ってPhpRedisで良さそうです。

でも composer で管理できないのは嫌だ。  

[PhpRedis vs Predis: Comparison on real production data](https://akalongman.medium.com/phpredis-vs-predis-comparison-on-real-production-data-a819b48cbadb)

> PhpRedis is faster about x6 times. Using igbinary serializer reduces stored data size about 3x times.
> If Redis installed on separate machines, reducing network traffic is a very significant speedup.

ここでも PhpRedis を絶賛。  

以下、Laravel公式の見解。  
[Redis 8.x Laravel](https://readouble.com/laravel/8.x/ja/redis.html)

> LaravelでRedisを使い始める前に、PECLにより phpredis HP拡張機能をインストールして使用することを推奨します。

これはもう phpredis で確定か。  

## Alpine について
そうなると、docker コンテナを弄らないといけない・・・  
今使っているコンテナ、Alpine なんだよな。。  

Alpine は、超軽量な Linux ディストリビューション。  
Docker コンテナのイメージのベースに使われる事も多くなってきた。  

ちなみに当方、Alpine は、あまり積極的に採用したくない派です。  

理由は以下。  
[Dockerイメージのベースディストリは、Alpine がいい感じなの？](https://kaki-note-02.netlify.app/2020/06/13/#q-docker%E3%82%A4%E3%83%A1%E3%83%BC%E3%82%B8%E3%81%AE%E3%83%99%E3%83%BC%E3%82%B9%E3%83%87%E3%82%A3%E3%82%B9%E3%83%88%E3%83%AA%E3%81%AF%E3%80%81alpine-%E3%81%8C%E3%81%84%E3%81%84%E6%84%9F%E3%81%98%E3%81%AA%E3%81%AE%EF%BC%9F)

ざっくり言うと、Alpine の嫌な所、こんな感じ。  

 * apk というマイナーなパッケージマネージャーを採用している
 * パッケージのバージョンがそれほど新鮮でない
 * なので、最新パッケージはソース持ってきてコンパイルする必要がある
 * ash というマイナーなシェルが採用されている
 * Dockerfile作りが職人芸になりがち
 * Debian や RedHat と比べるとマイナーなので、ハマった時のググラビリティが低い
 * というか「apk」も「ash」もググラビリティが低い（同一単語で、もっとメジャーなものがある）
 * マイナーディストリは色々とトラウマ
 * 他のディストリと比較して、パフォーマンスは出ないことがあるらしい（個人では未計測です）
 * Docker公式の『Dockerfile 記述のベスト・プラクティス』にて、Debian イメージをお勧めしている
 * Alpine 使うのに、「軽量化」以外のメリットあるんか。デメリットの方が大きく上回っとりゃせんか？
 * ビルド時間を 5分縮めるために、エンジニアの時間を 100時間ぐらい溶かしてない？　それって本当に費用対効果いいの？

何てこった！ 自分がこんなに Alpine に悪い印象持ってたなんて！  

ちなみに Alpine に否定的な意見を持ってるのは、自分だけじゃないぞ。（道連れ）  
[軽量Dockerイメージに安易にAlpineを使うのはやめたほうがいいという話](https://blog.inductor.me/entry/alpine-not-recommended)  

とはいえ、文句たれてても仕方ないんで、試しにインストールしてみよう。  


## PhpRedis を Alpine で使う
という事で、公式のインストールガイドに沿ってみる。  
[https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown](https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown)  

コンテナビルドの前に、まずはコンテナログインしてインストールできるかを確認してみる。  

以下、インストールコマンド。
```
pecl install redis
```

実行結果。  
```
/application # pecl install redis
downloading redis-5.3.4.tgz ...
Starting to download redis-5.3.4.tgz (268,154 bytes)
........................................................done: 268,154 bytes
29 source files, building
running: phpize
Configuring for:
PHP Api Version:         20190902
Zend Module Api No:      20190902
Zend Extension Api No:   320190902
Cannot find autoconf. Please check your autoconf installation and the
$PHP_AUTOCONF environment variable. Then, rerun this script.

ERROR: `phpize' failed
```

予想通り、上手く行かない。  

これで行けるのか？
[https://github.com/docker-library/php/issues/412](https://github.com/docker-library/php/issues/412)

コマンド
```
apk add --no-cache \
        $PHPIZE_DEPS \
        openssl-dev
```

実行結果
```
/application # apk add --no-cache \
>         $PHPIZE_DEPS \
>         openssl-dev
fetch https://dl-cdn.alpinelinux.org/alpine/v3.13/main/x86_64/APKINDEX.tar.gz
fetch https://dl-cdn.alpinelinux.org/alpine/v3.13/community/x86_64/APKINDEX.tar.gz
(1/22) Upgrading musl (1.2.2-r0 -> 1.2.2-r1)

中略

(22/22) Installing re2c (1.3-r1)
Executing busybox-1.32.1-r0.trigger
Executing ca-certificates-20191127-r5.trigger
OK: 357 MiB in 81 packages
```
行けたっぽい。  

という事で、気を取り直して、「pecl install redis」を再実行。  
```
/application # pecl install redis
downloading redis-5.3.4.tgz ...
Starting to download redis-5.3.4.tgz (268,154 bytes)
........................................................done: 268,154 bytes
29 source files, building
running: phpize
Configuring for:
PHP Api Version:         20190902
Zend Module Api No:      20190902
Zend Extension Api No:   320190902
enable igbinary serializer support? [no] : 

（中略）

Build complete.
Don't forget to run 'make test'.

（中略）

Build process completed successfully
Installing '/usr/local/lib/php/extensions/no-debug-non-zts-20190902/redis.so'
install ok: channel://pecl.php.net/redis-5.3.4
configuration option "php_ini" is not set to php.ini location
You should add "extension=redis.so" to php.ini
```

どうやら上手く行ったみたい。  


あとは、Laravel の設定を変更。

### .env
```
CACHE_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### config\database.php
```php
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),
```

あとはキャッシュをクリア
```
php artisan config:clear
php artisan config:cache
```

無事、Redis を動かす事が出来ました。  

ちなみに、web.php に以下のような超適当なコードを書いて実験してみました。  

### routes\web.php
```php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

//============================================================================================
//                                       Cache
//============================================================================================
// http://localhost/cache/put
Route::get('/cache/put', function () {
    echo "put";
    Cache::put('key01', 'value01');
});

Route::get('/cache/remember', function () {
    echo "remember";

    $cache = \Cache::remember('key02', 10, function(){
        return "value02_remember";
    });

    dump($cache);
});

Route::get('/cache/get', function () {
    echo "get";

    $cache01 = Cache::get('key01');
    $cache02 = Cache::get('key02');

    dump($cache01);
    dump($cache02);
});


Route::get('/cache/forget', function () {
    echo "forget";

    Cache::forget('key01');
    Cache::forget('key02');
});
```


## Predis を Alpine で使う
こちらも試してみました。  

composer でインストールができるので、PhpRedis よりも遥かに楽です。  

詳細は公式サイトを。  
[https://readouble.com/laravel/8.x/ja/redis.html](https://readouble.com/laravel/8.x/ja/redis.html)

後は、アプリ動かそうとしたら  
「Predis Client not found」  
というメッセージが出てきたので、ググって解決したという感じでしょうか。  

.env や config を正しく設定できていれば、すんなり行くのではないかと思います。  



## 終わりに
という事で、時代の流れに沿って PhpRedis を使う事にしたんだけど、コンテナイメージ作り直すの面倒くせええええ！！！  

PHP ライブラリは composer で管理したい。  


