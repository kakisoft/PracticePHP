【Laravel】artisan コマンドを叩く場合、.env ファイルは、OSの環境変数の影響を受けるので、知らないとハマる

laravel-env-file-referenced-by-archisan

________________________________________________________________________________________________

Laravel で artisan コマンドを打つ場合、「--env=」オプションを付ける事で、コマンドで使用する環境変数を指定できる。

以下、使用例。
```
// 「.env.local」を参照する
php artisan schedule:run --env=local

// 「.env.production」を参照する
php artisan schedule:run --env=production
```

「--env」を省略した時、「.env」を参照してくれるのかと思いきや、**OSの環境変数に依存する**。

どういう事かと言うと、、**OSの環境変数「APP_ENV」の値によって、デフォルトで読み込む .env ファイルが変わる**。

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

そして、以下のように環境変数を参照するコマンドがあったとする。
```php
public function handle()
{
    $this->info( env('ENV_PARAM_SAMPLE01') );
}
```

実行結果は以下のようになる。

 * Linux の環境変数 APP_ENV が未設定、もしくは空白の場合、出力結果は ".env"
 * Linux の環境変数 APP_ENV が local の場合、出力結果は ".env.local"
 * Linux の環境変数 APP_ENV が production の場合、出力結果は ".env.local"

ちなみに、Linux の環境変数を変えた後、キャッシュクリアのコマンドを叩かないと、変更内容は反映されません。
```
php artisan hello:class
```


## 適用範囲
この挙動はコマンドラインから実行した時のみ適用され、**普通にアプリを動かす場合は .env が適用される。**

試しに routes\api.php に以下のようなコードを書いてみたのですが、Linux の環境変数をどのように変えても、結果は常に同じでした。
```php
Route::get('env', function(){ return env('ENV_PARAM_SAMPLE01'); });
```


## 開発時に決めておいた方が良さそうな点
ローカル環境にて、環境変数「APP_ENV=local」等に設定する場合、「.env.local」をプロジェクトに含めない方が良さそう。

そうしないと、アプリは .env を参照し、コマンドラインは .env.local を参照するといった、混乱を招きやすい挙動になってしまう。

ちなみに、環境変数が「APP_ENV=local」と設定されていて、「.env.local」が存在しなかった場合、「.env」を参照します。


## Laravel 的に正しい挙動なの？
ソースを読無限り、意図通りの動作だと思われます。





GitHub リポジトリ内のソースの該当箇所はこちら。
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Bootstrap/LoadEnvironmentVariables.php#L51



