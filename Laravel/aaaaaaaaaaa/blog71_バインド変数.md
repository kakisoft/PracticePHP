【Laravel】DBファサードにて、where in 句を使用する方法

____________________________________________________________


Laravel にて DBファサードを使用すると、生SQL を書くような感覚でクエリを発行できます。  
変数は、以下のようにバインド変数化できます。  

## 例
```php
$sql = <<<SQL
    select
         id
        ,name
        ,content
        ,foo_id
        ,owner_id
        ,payload
    from
        samples
    where  1=1
      and  owner_id = :owner_id
      and  name like  :name
SQL;

$params['owner_id'] = '0';
$params['name']     = '%John%';

$result = DB::select($sql, $params);
```

実は、この方法だと「where foo_id in (1,3,5)」といった方法での検索ができなかったりする。  

Laravel では PDO ライブラリを使用しており、PDO ライブラリは where in 句に対応していないのが原因らしい。  

**参考**  
<https://stackoverflow.com/questions/19977291/laravel-4-where-in-condition-with-dbselect-query>  

> So the question is how to place instead of "?" array of ids?  

> Laravel is using PDO library. Sadly, binding with PDO doesn't work with WHERE IN. You can read about it here.  

<https://stackoverflow.com/questions/920353/can-i-bind-an-array-to-an-in-condition>  


という事で、別の方法を考えてみる。  


## 別案１：where in の内容を文字列の中で展開
こんな感じで、バインド変数の外に出してしまう。  
インジェクション対策から外れてしまうので、ユーザ入力のデータには使えないのが欠点。  
使えたとしても、なるべくは使いたくない。  

```php
$fooIds = [1,3,5];

$sql = '';
$sql .= 'select                                               ' . PHP_EOL;
$sql .= '    id                                               ' . PHP_EOL;
$sql .= '   ,name                                             ' . PHP_EOL;
$sql .= '   ,content                                          ' . PHP_EOL;
$sql .= '   ,foo_id                                           ' . PHP_EOL;
$sql .= '   ,owner_id                                         ' . PHP_EOL;
$sql .= '   ,payload                                          ' . PHP_EOL;
$sql .= 'from                                                 ' . PHP_EOL;
$sql .= '    samples                                          ' . PHP_EOL;
$sql .= 'where  1=1                                           ' . PHP_EOL;
$sql .= '  and  owner_id = :owner_id                          ' . PHP_EOL;
$sql .= '  and  name like  :name                              ' . PHP_EOL;
$sql .= '  and  foo_id in  ("' . implode('","', $fooIds) . '")' . PHP_EOL;

$params['owner_id'] = '0';
$params['name']     = '%John%';

$result = DB::select($sql, $params);
```

## 別案２：バインド変数を「?」に変え、変動制を持たせる
こんな感じ。  

where in の入る部分に、文字列 '?' を配列の要素分だけ含めた内容をセットする。  
あとは、バインド変数を設定する部分で展開。  

変数名を設定できないという欠点はあるものの、安全面を考えると「別案１」よりも良策。  

```php
$owner_id = '0';
$name     = "%John%";

$fooIds = [1,3,5];
$fooIdsPlaceHolders = implode(',', array_fill(0, count($fooIds), '?'));

$sql = <<<SQL
    select
        id
        ,name
        ,content
        ,foo_id
        ,owner_id
        ,payload
    from
        samples
    where  1=1
      and  owner_id = ?
      and  name like  ?
      and  foo_id in ($fooIdsPlaceHolders)
SQL;

$params = [$owner_id, $name, ...$fooIds];

$result = DB::select($sql, $params);
```

