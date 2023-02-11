## ziggy
https://github.com/tighten/ziggy


"tightenco/ziggy": "^1.5"


vue.js や React から Laravel のルーティングを使用する。


### 使用例
```js
        methods: {
            lang,
            filterGroups,
            errorText,
            sendRequest() {
                axios.post(this.route('approvals.create', ['estimate', this.id]), {
```


## jsルーティング生成コマンド　☆超重要☆ デプロイにも組み込んでおく！
```
php artisan ziggy:generate
```

src\resources\js\ziggy.js に、ファイルが生成される。
resources 配下なので、リポジトリの管理対象となる（事も多い）。

そのため、本番環境に適用する時には、上記コマンドを入れておかないと、ルーティングエラーが発生する事がある。

Chrome developer tools の、Network タブにて history を選択し、Header タブを見てルーティングを確認。

また、ベースとなる URL は、.env の APP_URL の影響を受ける。

#### .env
```conf
APP_NAME=MY_Laravel_APP_01
APP_ENV=local
APP_KEY=abcde
APP_DEBUG=true
APP_URL=http://localhost:44300  # ← これ
```



### ファイル生成例

#### src\resources\js\ziggy.js
```js
const Ziggy = {"url":"https:\/\/localhost","port":44300,"defaults":{},"routes":{"approvals.latest":{"uri":"approvals\/{mode}\/{id}\/latest","methods":["GET","HEAD"]},"approvals.create":{"uri":"approvals\/{mode}\/{id}\/create","methods":["POST"]},"approvals.history":{"uri":"approvals\/{mode}\/{id}\/history","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
```

_________________________________________________________________________________________

副作用として、ルーティングが安定しなくなる？
デプロイ時、ルーティングエラーが原因の 500エラーが起こりまくって吐血しながら対応した。

composer dump-autoload, php artisan clear-compiled, php artisan optimize 等、composer や laravel cache をクリア・再設定するコマンドを何度か繰り返して、ようやく解決した。




