
【Laravel】Laravel アプリケーションが参照する .env ファイルは、OSの環境変数の影響を受けるので、知らないとハマる

laravel-env-file-referenced

________________________________________________________________________________________________
**【 環境 】**
**Laravel のバージョン： 8.16.1**
**PHP のバージョン： 7.4.7**

Laravel で artisan コマンドを打つ場合、「--env=」オプションを付ける事で、コマンドで使用する環境変数を指定できる。

以下、使用例。
```
// 「.env.local」を参照する
php artisan schedule:run --env=local

// 「.env.production」を参照する
php artisan schedule:run --env=production
```

「--env」を省略した時、「.env」を参照してくれるのかと思いきや、**OSの環境変数に依存する**。

どういう事かと言うと、**OSの環境変数「APP_ENV」の値によって、デフォルトで読み込む .env ファイルが変わる**。

環境変数についての具体的なコマンドは以下。
ちなみに、Linux を想定しています。

#### 環境変数を確認
```
printenv
```

#### 環境変数を確認（特定の変数のみ）
「APP_ENV」のみを確認したい場合は以下。
```
printenv APP_ENV
```
実行して何も出てこなかった場合、環境変数「APP_ENV」は定義されていない。


#### 環境変数をセット
以下、APP_ENV に "production" を設定する場合
```
export APP_ENV="production"
```

#### 環境変数を削除
以下、環境変数「APP_ENV」を削除する場合
```
unset APP_ENV
```

## 動作例
例えば、各 .env ファイルに、以下の設定があったとする。
#### .env
```
ENV_PARAM_SAMPLE01=.env
```
#### .local
```
ENV_PARAM_SAMPLE01=.env.local
```

#### .production
```
ENV_PARAM_SAMPLE01=.env.production
```

env ファイルを読み込ませる config を追加
#### config\myconfig01.php
```php
return [
    'env_param_sample01' => env('ENV_PARAM_SAMPLE01'),
];
```

そして、以下のように環境変数を参照するコマンドがあったとする。
```php
public function handle()
{
    $this->info( config('myconfig01.env_param_sample01') );
}
```

実行結果は以下のようになる。

 * Linux の環境変数 APP_ENV が未設定、もしくは空白の場合、出力結果は ".env"
 * Linux の環境変数 APP_ENV が local の場合、出力結果は ".env.local"
 * Linux の環境変数 APP_ENV が production の場合、出力結果は ".env.local"

ちなみに、Linux の環境変数を変えた後、キャッシュクリアのコマンドを叩かないと、変更内容は反映されません。

コンフィグファイルのキャッシュクリアコマンドは以下。
```
php artisan config:clear
```


## 適用範囲
この挙動は、コマンドラインから参照した時のみでなく、**普通にアプリを動かす場合にも適用**される。
（2021年 7/18訂正。当初、アプリ側は常に .env を参照するものと思っておりました。詳細は）

試しに以下のようなコードを書いて検証してみたところ、コマンドラインから実行した時と全く同じ結果になりました。
```php
Route::get('env', function(){
    return config('myconfig01.env_param_sample01');
});
```


## 開発時に決めておいた方が良さそうな点
色々と開発者が混乱を招く原因となるので、以下のようなルールを決めておいた方がよさそう。

#### 案１．OS の APP_ENV を設定しない
ローカルの開発環境構築時、特に理由がない限り、OS の環境変数を「APP_ENV=local」に設定しない。
そうしないと、上記のような事象に遭遇し、余計な事でハマる。

#### 案２．.env.local を編集するようにする
（OS の環境変数を「APP_ENV=local」が設定されている）
開発時、.env は編集せず、.env.local を編集するようにする。
この場合、.env は削除した方が良さそうです。
ただ、それだと気持ち悪さを感じる人が一定数居そうだし、Laravel に慣れた人は気を利かして自分で .env を用意するので、
その時「あれ？ちゃんと動かない？」と余計なハマりポイントが出来てしまうので、Readme へ注意書きは必須。

#### 案３．.env.local をリポジトリ管理しない。
（OS の環境変数を「APP_ENV=local」が設定されている）
「.env.local」をリポジトリ管理しない。（.env.local　ファイルを作成しない）

ちなみに、OSの環境変数が設定されていた場合、**.env を参照する方法はありません**　。
指定しなければデフォルト設定の .env.local が参照され、「--env=""」といったように空白を指定しても、デフォルト設定が参照されます。

唯一、「.env.local」が存在しなかった場合、「.env」を参照します。
が、そんなややこしい事、誰もやりたくないと思うので、最初からリポジトリ管理対象外にしてしまっては？
という考え。

### OSの環境変数設定内容 : docker-compose を使っている場合
ちなみに、docker-compose を使っている場合、OSの環境変数は「environment:」に記述されています。
```yaml
services:
  app:
    build: ./docker/php
    depends_on:
    - mysql
    volumes:
      - .:/var/www/html
    container_name: myapp
    user: www-data
    environment:
      - APP_ENV=local
```


## その他の考察
サーバ環境においては、
「APP_ENV=staging」
「APP_ENV=production」
という設定が入るのは、ごく普通かと思います。

また、CI/CD なんかを組んでいると、コンテナ構築時に
「.env.production の内容を、.env にコピー」
といった処理をが含まれている事もあるかと思いますが、**実は無意味**でした。

OSの環境変数が設定されていれば、アプリ・コマンドライン共に .env が参照される事はありません。


## Laravel 的に正しい挙動なの？
ソースを読無限り、意図通りの動作だと思われます。

![laravel-env-file-referenced-by-archisan](https://kaki-engine.com/wp-content/uploads/2021/07/laravel-env-file-referenced-by-archisan.png)

GitHub リポジトリ内のソースの該当箇所はこちら。<https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Bootstrap/LoadEnvironmentVariables.php#L51>
