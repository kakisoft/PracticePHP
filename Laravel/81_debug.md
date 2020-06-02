# laravel-debugbar
https://github.com/barryvdh/laravel-debugbar

```
composer require barryvdh/laravel-debugbar --dev

// 本番環境でも使う場合は、--dev を取る。ただし、個人情報が丸見えになる事もあるので、注意が必要。
composer require barryvdh/laravel-debugbar
```

## .env
```
APP_DEBUG=true


## laravel-debugbar　固有のコンフィグで設定する場合
DEBUGBAR_ENABLED=null   # デフォルト。APP_DEBUGに応じて決まる
DEBUGBAR_ENABLED=true   # 必ず有効
DEBUGBAR_ENABLED=false  # 必ず無効
```

5.5 以前は Providerやらファサードやらに設定が必要だったみたいだけど、今は Package Auto Discovery という機能のおかげで、特に不要らしい。


## トレース
```php
debug('debug-bar に表示されるメッセージ');        // debug-bar に表示させるダンプ 

// SQL のトレース（こんなの書かなくても、勝手に出てくる）
$posts = Post::latest()->get();
\Debugbar::info($posts);
```


