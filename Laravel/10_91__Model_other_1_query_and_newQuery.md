【Laravel】eloquent Model の「query()」と「newQuery()」の違いとは？

____________________________________________________________________________________
Laravel の eloquent Model には、「query()」と「newQuery()」といった、名前も役割も非常によく似たメソッドがあります。  

#### query() public static method
https://hotexamples.com/jp/examples/illuminate.database.eloquent/Model/query/php-model-query-method-examples.html
```
Begin querying the model.
public static query ( ) : Builder
return
```

#### newQuery() public method
https://hotexamples.com/jp/examples/illuminate.database.eloquent/Model/newQuery/php-model-newquery-method-examples.html
```
Get a new query builder for the model's table.
public newQuery ( ) : Builder
return
```

正直、何が違うのか良く分からないし、ググってもちゃんと答えを見つけ切れなかったので、Laravel のソースを読んでみました。  

以下、該当箇所です。  

## framework\src\Illuminate\Database\Eloquent\Model.php
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Database/Eloquent/Model.php#L1232
```php
    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        return (new static)->newQuery();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes());
    }
```

**一緒やんけー！**  

でも、もしかしたら自分の読み間違いかもしれないので、こんなコードを書いて実験してみた。  


```php
$query = Item::query();
$query->select('id', 'code','name');
```
Model.php は、以下のようにログを仕込む。  

プロジェクトから探す場合、以下のパスです。  
vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php  

以下、ログに出力された内容です。  

### storage\logs\laravel.log
```log
[2021-07-21 14:59:04] local.INFO: Illuminate\Database\Eloquent\Model::query  
[2021-07-21 14:59:04] local.INFO: Illuminate\Database\Eloquent\Model::newQuery  
```

という事で、
**「query()」と「newQuery()」は、全く同じ**  
と断言できそうです。  

違いを挙げるとしたら使い方とか。  

query() は static なので静的に使える（クラスから直接コールできる）けど、newQuery() はそれができないので、「self::newQuery() 」といった使い方ができない。  
なので、こんな感じとか。  
```php
// case 1
$item = new Item();
$query1 = $item->newQuery();
$query1->select('id', 'code','name');

// case 2
$query2 = app()->make(Item::class)->newQuery();
$query2->select('id', 'code','name');
```

その時のログ。
```log
[2021-07-21 15:33:20] local.INFO: Illuminate\Database\Eloquent\Model::newQuery  
[2021-07-21 15:33:21] local.INFO: Illuminate\Database\Eloquent\Model::newQuery  
```

でも、こういう使い方もできる。
```php
// case 1
$item = new Item();
$query1 = $item->query();
$query1->select('id', 'code','name');

// case 2
$query2 = app()->make(Item::class)->query();
$query2->select('id', 'code','name');
```

その時のログ
```log
[2021-07-21 15:34:16] local.INFO: Illuminate\Database\Eloquent\Model::query  
[2021-07-21 15:34:16] local.INFO: Illuminate\Database\Eloquent\Model::newQuery  
[2021-07-21 15:34:16] local.INFO: Illuminate\Database\Eloquent\Model::query  
[2021-07-21 15:34:16] local.INFO: Illuminate\Database\Eloquent\Model::newQuery  
```

とはいえ、インスタンスから static メソッドをコールするというのが気持ち悪いといえば気持ち悪いんで、オブジェクト指向的に正しく使いたいなら、以下のように使い分けをした方が良さそう。  

 * クラスからコールする場合、query()
 * インスタンスからコールする場合、newQuery()

一応、差を並べてはみたものの、違いを意識して使い分けるよりも、全部 query() で良いのでは？  
というルールにしてもアリなんじゃないかと思っている。  

ここは天下の適当言語 PHPの恩恵を受ける意味でも、「query()」に寄せる意見が出たとしても、特に反対はしない。  

ちなみに PHP の言語仕様は、結構いい加減だと思ってるし、世間でもよくディスられてるけど、時にはそれが柔軟性と拡張性の高いコードに繋がるケースも多々あるので、使い方次第なんじゃないかと思ってる。  
個人的には、言語仕様のいい加減さは魅力。  

オブジェクト指向的に「正しく」作るよりも、実用性に寄せるという考え方は、むしろ好き。  


## 「new static」について
(new static) という表現があまり見かけなかったので調べてみた。  

 * self は 定義時 のクラスを指す
 * static は 実行時 のクラスを指す

という事らしい。  

#### 参考サイト
https://blog.sarabande.jp/post/10539365200  
https://gotohayato.com/content/488/  


実験したところ、こんな感じ。  
```php
class ParentClass {
    // 「self」は、定義されたクラスを指す。
    // この場合、どこからコールされても、クラス「ParentClass」を指す
    public static function getNewSelfName() {
        return get_class(new self());
    }

    // 「static」は、呼び出された時のクラスを指す。
    // このクラスを継承した ChildClass からコールされる場合、「ChildClass」を指す
    public static function getNewStaticName() {
        return get_class(new static());
    }
}

class ChildClass extends ParentClass {
}

// 「self」は、定義されたクラスを指す
echo ParentClass::getNewSelfName() . PHP_EOL;    //=> ParentClass
echo ChildClass::getNewSelfName()  . PHP_EOL;    //=> ParentClass

// 「static」は、呼び出されたクラスを指す
echo ParentClass::getNewStaticName() . PHP_EOL;  //=> ParentClass
echo ChildClass::getNewStaticName()  . PHP_EOL;  //=> ChildClass
```


