# デバッグ

## dd
dump & die。  
結果を出力してその場で処理を終了させてくれる。  
```php
    dd($posts->toArray());
```

## dump
データをトレース。処理は続行。
```php
  dump($data->toArray());
```

________________________________________________________________________
________________________________________________________________________
________________________________________________________________________
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

## 発行した SQL のトレース
[13_Model_use.md](13_Model_use.md)

________________________________________________________________________
________________________________________________________________________
________________________________________________________________________
# 発行したSQL のトレース

## パラメータを入れた状態にする（メソッド）
```php
    public static function getEloquentSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            $binding = addslashes($binding);
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
```

↑のメソッドを、何やってるのか解析するために、少し分解。
```php
    public static function getEloquentSqlWithBindings($query)
    {
        $replaced_sql = str_replace('?', '%s', $query->toSql());

        $ret = vsprintf(

            $replaced_sql, collect($query->getBindings())->map(
                                                                    function ($binding) {
                                                                                            $binding = addslashes($binding);
                                                                                            return is_numeric($binding) ? $binding : "'{$binding}'";
                                                                                        }
                                                               )->toArray()
                        );

        return $ret;
    }

```


## パラメータを入れた状態にする（親クラス）
```php
class MyModel extends Eloquent {

  public function getSql()
  {
    $builder = $this->getBuilder();
    $sql = $builder->toSql();
    foreach($builder->getBindings() as $binding)
    {
      $value = is_numeric($binding) ? $binding : "'".$binding."'";
      $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
  }

}
```

________________________________________________________________________
________________________________________________________________________
________________________________________________________________________
## Laravel SQLの実行クエリログを出力する
https://qiita.com/ucan-lab/items/753cb9d3e4ceeb245341





