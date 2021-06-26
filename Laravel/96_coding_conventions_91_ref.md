# PHPのコーディング規約まとめ。PSR-2, CakePHP, Symfony, WordPress, FuelPHPなどの5つの規約の概要と特徴的なルール
https://siderlabs.com/blog/ja/php-codingstyles/


## PSR-2 Coding Style Guide
PSR とは  
PSRとは、PHP-FIG（PHP Framework Interop Group）が定めた規約です。  
PHPには、Zend FarmeworkやSymfonyなど様々なフレームワークやライブラリがありますが、それぞれコーディング規約が微妙に異なっています。  
そこで、各フレームワークの関係者が集まったグループPHP-FIGが、PHP共通でえるようなコーディング規約を決めたのがPSRです。  

PSRにはPSR-0,PSR-1,PSR-2,PSR-4などの規約があります。  
PSR-0とPSR-4はPHPのオートローダーのためのコーディング規約、PSR-1とPSR-2は標準コーディング規約になっています。  
PSR-2はPHPの最もスタンダードなコーディング規約となりつつあります。  

## PSR-0とPSR-4
PSR-0とPSR-4はともに名前空間・クラス名とファイルパスの関係に関する規約です。  
PSR-0は2014年10月以降非推奨となっており、新しいプロジェクトではPSR-4の規約を使うことが推奨されています。  

PSR-0: Autoloading Standard – PHP-FIG  
https://www.php-fig.org/psr/psr-0/  

PHPにはオートローダーという仕組みがあるため、名前空間つきのクラス名1つに対して1つのファイルパスが対応している必要があります。  

## PSR-0
PSR-0では、名前空間つきクラス名とファイルパスの対応について以下のように決められています。  

 * 名前空間の\をディレクトリセパレーター/に置き換える  
 * クラス名の_をディレクトリセパレータ/に置き換える  
 * 最後に.phpを付ける  

例えば、クラス名とファイルパスの対応は以下のようになります  

|  名前空間付きクラス名                           |  対応するファイルパス                                   |  備考                 |
|:--------------------------------------|:----------------------------------------------|:--------------------|
|  \vendorname \namespace \ClassName    |  /project /path /namespace /ClassName.php     |  \が/に置き変わる          |
|  \vendorname \name_space \ClassName   |  /project /path /name_space /ClassName.php    |  名前空間の_は特別な意味を持たない  |
|  \vendorname \name_space \Class_Name  |  /project /path /name_space /Class /Name.php  |  クラス名の_は/に置き換わる     |


## PSR-4
PSR-4はPSR-0に変わる新しい規約です。主な変更点は以下の点です。  

クラス名の_は特別な意味を持たない  
つまり \vendorname\name_space\Class_Name に対応するファイルパスは  

PSR-0: /project/path/name_space/Class/Name.php  
PSR-4: /project/path/name_space/Class_Name.php  
となります。


## PSR-0とPSR-4がある理由
PHPの名前空間はPHP5から実装されました。それ以前のPHPには名前空間というものがありませんでした。  
名前空間がない場合、クラス名が衝突しやすいという問題点がありました。  

例えば、Mysqlというクラスを定義したくても、導入しているライブラリなどですでにMysqlというクラスが定義されていた場合、そのクラス名は使えませんでした。  
そこで、Zend_Mysqlのようにクラス名にはプロジェクトのプレフィックスを付けるのが慣習となっていました。  
このようなプレフィックス付きのクラス名を名前空間のように扱えるようにしたのがPSR-0です。  

PSR-0はこのような少し昔のコードのために用意されている規約であり、古いPHPでは、PSR-0を使うことも考える必要があるかもしれません。しかし現在は非推奨となっており、新しいプロジェクトではPSR-4の規約を使うことが推奨されています。  


## PSR-1 Basic Coding Standard
PSR-1はPHPのコーディング規約の中でも基本的な部分が定めてあります。例えば以下のようなことが定められています。  

 * PHPタグは <?php または <?= のみ使えます。
 * ファイルはBOM(Byte Order Mark)無しUTF-8でなければなりません。
 * 名前空間とクラス名はPSR-0またはPSR-4に従わなければなりません。
 * クラス名 はUpperCamelCaseのような アッパーキャメルケース で定義しなければなりません。
 * クラス定数 は UPPER_SNAKE_CASE のような アッパースネークケース で定義しなければなりません。
 * メソッド名 はcamelCaseのような キャメルケース で定義しなければなりません。

PHPの標準関数はスネークケースで定義されていますが、PSR-1においてメソッド名はキャメルケースで定義しなければなりません。  
変数名やプロパティ名に関しては得に決まりは無いため、キャメルケース、アッパーキャメルケース、スネークケースのどれを利用しても良いですが、ある程度一貫性があった方が良いということが書かれています。  
例えば、通常のプロパティはキャメルケース、staticプロパティはアッパーキャメルケースにするなどが考えられます。  

```php
class Something
{
    public $normalPropterty;
    public static $StaticProperty;
}
```

## PSR-2 Coding Style Guide
PSR-2は、PSR-1を拡張したコーディング規約です。一例として以下のようなことが決められています。  

 * PSR-1のコーディング規約には従わなければなりません。
 * インデントには4つのスペースを利用しなければなりません。タブは使用してはいけません。
 * 1行の長さに制限はありませんが、120文字以下が望ましいです。できれば80文字以下にして下さい。
 * クラス・メソッドの波括弧の前には改行を入れなければなりません。
 * メソッドやプロパティの定義は最初にabstract/final、次にpublic/protected/private、最後にstaticを書かなければなりません。
 * 制御構文開始の波括弧の前には改行を入れません。
 * 制御構文の(の後、)の前にはスペースを入れません。
 * 後に紹介するCakePHPやSymfonyもこのPSR-2に準拠しています。


## クラスの定義
クラス定義の{の前には改行を挟まなければいけません。また、extends と implements はクラス名と同じ行に書きます。  

```php
class ClassName extends ParentClassName implements Interface1, Interface2
{
    // クラスの定義
}
```

インターフェースが多くて行が長くなる場合は、implementsの後で改行し、1行に1つのインタフェースを書きます。

```php
class ClassName extends ParentClassName implements
Interface1,
Interface2,
Interface3,
Interface4
{
    // クラスの定義
}
```

class ClassName {のように、同じ行に{を書く規約も少なくないため、こういった書き方を初めて見る方もいらっしゃるかもしれません。


## プロパティの定義
PSR-2ではpublic/protected/privateを省略することは出来ません。
PHPではこれらを省略するとpublicになりますが、意図して省略したのか書くのを忘れたのか区別できないため、publicでも必ず書くべきです。
staticキーワードはこの後に書きます。プロパティの定義に var を使ってはいけません。varにはpublicなどの修飾子を付けることができないためです。

```php
class ClassName
{
    public $property1;
    private $property2;
    public static $staticProperty;
}
```

また、1つのステートメントで2つ以上のプロパティを定義しては行けません。
以下のようなプロパティ定義は可能ですが、PSR-2では禁止されています。

```php
class ClassName
{
    private $property1, $property2;
}
```

## メソッド
プロパティ同様、public/protected/privateは必ず付けなければならず、abstract/finalを付ける場合はその前に付けます。
staticは修飾子の中では一番最後です。丸括弧の前後にはスペースを入れず、波括弧の前には改行を入れます。
また、引数のカンマの前にはスペースを入れず、後ろには1つのスペースを入れます。

```php
class ClassName
{
    abstract protected function abstractDoSomething();
    final public static function doSomething($arg1, $arg2, $arg3)
    {
        // ...
    }
}
```

メソッドの引数が多い場合は、(の後で改行し、1行に1つの引数を書くことが出来ます。  
この場合1行に複数の引数を書くことはできません。  
また、)と{は1つのスペースを挟んで同じ行に書きます。  

```php
class ClassName
{
    public function doSomething(
    TypeHint $arg1,
    $arg2,
    $arg3,
    $arg4
    ) {
        // ...
    }
}
```

注意点として、クロージャーの場合は{の前に改行をいれてはいけません。

```php
$closure = function ($a, $b) use ($c) {
    // 本体
};
```

## 制御構文
制御構文は、

 * (の前に1スペースを入れます。
 * (の後にスペースは入れません。
 * )の前にスペースは入れません。
 * )の後には1スペースを入れます。

また、 else if ではなく elseif を使うべきです。

```php
if ($condition1) {
    // ...
} elseif ($condition2) {
    // ...
} else {
    // ...
}
```

else ifとelseifは全く同じものではないことに注意してください。elseifはこれで1つの構文であるのに対し、else ifは最初のifのelse節の中にifを入れている事になります。

```php
if ($condition1) {
    // ...
} else if ($condition2) {
    // ...
} else {
    // ...
}
```

この構文は、以下のように解釈されます。

```php
if ($condition1) {
        // ...

    } else {
    if ($condition2) {
        // ...
    } else {
        // ...
    }
}
```

switch文は、caseのインデントがswitchよりも1段深く、caseの中身はさらに1段深くなります。  
caseの中で何か処理をした後、breakしない時はコメントを書かなければなりません。  

```php
switch ($condition) {
    case 0:
        echo 'First case, with a break';
        break;
    case 1:
        echo 'Second case, which falls through';
        // no break
    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;
        default:
        echo 'Default case';
    break;
}
```

## CakePHPコーディング規約
以下略
