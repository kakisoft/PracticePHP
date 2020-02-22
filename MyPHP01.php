<?php

// コメント
# コメント
/*
コメント
*/

echo "hello from the TOP!";

const CANONICAL_TAG_TEMPLATE = "<link rel=\"canonical\" href=\"%s\">";

// private $canonicalContents = "";
// private $canonicalFullContents = "";

// $this->canonicalContents = "canonicalllllllll";
// $this->canonicalFullContents = sprintf(self::CANONICAL_TAG_TEMPLATE, $this->canonicalContents);



//==========================
//     外部ファイル読み込み
// require: エラー時に fatal errorが発生して処理が終了。
// require_once：once：PHPが読み込まれているかをチェックする。読まれていればスキップする。
//
// include: warning：エラー時に warningが発生し、処理は継続。
// include_once：
//
// autoload：クラスのみ使用可能
//==========================

require "resources/Team.class.php";
// include "resources/Team.class.php";

// spl_autoload_register(function($class) {
//   require "resources/". $class . ".class.php";
// });


//===========================
//  use - 名前空間のインポート
//===========================
use Kakisoft\Lib as Lib;
# use Kakisoft\Lib;

$TokkouyarouA = new Lib\Team("TokkouyarouA");
$TokkouyarouA->sayHi();

# use Kakisoft\Lib;
# $TokkouyarouA = new Lib\Team("TokkouyarouA");


?>
<!DOCTYPE html>
<html lang="ja">
<body>
  <p>Hello World <?php echo " from PHP"; ?></p>
<?php



//=============================
//       ヒアドキュメント
//=============================
$string_01 = <<<HTML
変数を解釈する
HTML;


$this_alias = 'alias_01';
$html_01 = <<<HTML
変数を解釈する
<form name="admin_login" id="admin_login" method="POST" action="{$this_alias}">
HTML;


$html_02 = <<<'HTML'
そのまま表示する
<form name="admin_login" id="admin_login" method="POST" action="{$this_alias}">
HTML;


//==========================
// データ型:
// - 文字列 string
// - 数値 integer float
// - 論理値 boolean / true false
// - 配列
// - オブジェクト
// - null
//==========================
$msg = "hello from the TOP!";
echo $msg;
echo "<br>";
var_dump($msg); //変数の型をトレース


//==========================
//          定数
//==========================
define("MY_EMAIL", "kakinohana@kakisoft.com");
echo MY_EMAIL;
echo "<br>";


//=============================
//  特殊用途の定数（自動的に定義）
//=============================
var_dump(__LINE__); // 現在の行数
var_dump(__FILE__); // ファイル名
var_dump(__DIR__);  // ディレクトリ
var_dump($_SERVER['SERVER_NAME']);
echo "<br>";


//-------------------
//      
//-------------------
if (PHP_SAPI === 'cli'){
    echo "CLI!";
}
else{
    echo "CLI じゃない";
}

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) == 'cgi') {
    echo "CGI 版の PHP を使用しています\n";
}
else {
    echo "CGI 版の PHP を使用していません\n";
}

echo PHP_BINARY;  // C:\tools\php73\php.exe   //  /usr/bin/phppckaki301:PracticePHP


//==========================
//      数値型の演算
//==========================
//  +   -   *    /    %    **(PHP5.6-)
$x1 = 10 % 3; // 1
$y1 = 30.2 / 4; // 7.55
var_dump($x1);
var_dump($y1);

// 単項演算子 ++ --
$z1 = 5;
$z1++; // 6
var_dump($z1);
$z1--; // 5
var_dump($z1);

// 代入を伴う演算子
$x2 = 5;
$x2 = $x2 * 2;
$x2 *= 2;
var_dump($x2);


echo "<br>";
//======================================
// 文字列
// "" 特殊文字(\n, \t) 、変数が展開される
// '' そのまま出力する
//======================================
$name = "kaki";
$s1 = "hello $name!\nhello again!";
$s2 = "hello {$name}!\nhello again!";  // 変数を{}で囲う事もできる
$s3 = "hello ${name}!\nhello again!";  // $を外に出せる
$s4 = 'hello $name!\nhello again!';
var_dump($s1);
var_dump($s2);
var_dump($s3);
var_dump($s4);

// 連結 .
$s5 = "hello " . "world";
var_dump($s5);

echo "<br>";


//-------------------
//     置換
//-------------------
$targetText = "AABBAA";

// "A" という文字列を "×" に置換する
$replaceText = str_replace("A", "×", $targetText);

// 小文字に変更
$str = "Mary Had A Little Lamb and She LOVED It So";
$str = mb_strtolower($str);

// 大文字に変更
$str = "Mary Had A Little Lamb and She LOVED It So";
$str = strtoupper($str);

//----------( 正規表現による置換 )----------
//連続したスペースを、スペース１個分に置換
$string = "a  b  c       ddd";
$pattern = '/\s+/';
$replacement = ' ';
echo preg_replace($pattern, $replacement, $string);  #=> 「a b c ddd」
$pieces = explode(" ", $a);

// 改行コード(\nまたは\rまたは\r\n)を''(空文字)に置き換える
$text = "";
$text = preg_replace('/\r\n|\r|\n/', '', $text);


//-------------------
//    文字列の検索
//-------------------
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// 見つからなかったら falseを返す
if ($pos === false) {
    echo "文字列 '$findme' は、文字列 '$mystring' の中で見つかりませんでした";
} else {
    echo "文字列 '$findme' が文字列 '$mystring' の中で見つかりました";
    echo " 見つかった位置は $pos です";
}

//==========================
//      文字列を丸める
//==========================
echo mb_strimwidth("Hello World", 0, 10, "...");  // "Hello W..." と出力します



//==========================
// フォーマットされた文字列を返す
//==========================
sprintf('%02d', 1); // 01
sprintf('%03d', 1); // 001
sprintf('あなたのIDは%04dです', 1); // あなたのIDは0001です



//==========================
//         trim
//==========================
// 末尾の「/」を削除
$value = rtrim($value, '/');




//==========================================================
// if 条件分岐
//   比較演算子 >   <   >=   <=   ==   ===   !=   !==
//   論理演算子 and && , or || , !
//==========================================================
$score = 40;

if ($score > 80) {
  echo "great!";
} elseif ($score > 60) {
  echo "good!";
} else {
  echo "so so ...";
}

echo "<br>";
//==========================
//        真偽値
// falseになる場合
// 　文字列: 空、"0"
// 　数値: 0、0.0
// 　論理値: false
// 　配列: 要素の数が0
// 　null
//==========================

$x09 = 5;
// if ($x) {
if ($x09 == true) {
  echo "great";
}


//==========================
//        三項演算子
//==========================
$a09 = 10;
$b09 = 20;
$max09 = ($a09 > $b09) ? $a09 : $b09; // () の条件が真だったら $a09 をmax09 に代入。偽だったら $b09 を max09 に代入

if ($a09 > $b09) {
  $max09 = $a09;
} else {
  $max09 = $b09;
}


// if($cond===true){ func1(); }else{ func2(); }
// $cond===true ? func1() : func2();


//==========================
//    エルビス演算子  5.3～
//==========================
// 左辺が真と判断できる値であればその値が返却される
$param_e1 = 'exists';
$param_e2 = null;
// $param_e3 = '定義しない';
$param_e4 = 0;

$getted_param_e1 = $param_e1 ?: 'not_exists';
$getted_param_e2 = $param_e2 ?: 'not_exists';
$getted_param_e3 = $param_e3 ?: 'not_exists';  // PHP Notice:  Undefined variable:
$getted_param_e4 = $param_e4 ?: 'not_exists';

echo($getted_param_e1 . PHP_EOL);  //=> 'exists'
echo($getted_param_e2 . PHP_EOL);  //=> 'not_exists'
echo($getted_param_e3 . PHP_EOL);  //=> 'not_exists'
echo($getted_param_e4 . PHP_EOL);  //=> 'not_exists'

// リクエストパラメータに使ったりとか
$user_name = $_POST['user_name'] ?: 'default_user';


//==========================
//     NULL合体演算子  7～
//==========================
// 未定義でもNULLでもなければ左オペランドの値を採用
// 未定義またはNULLのとき右オペランドの値を採用
// (内部でisset相当のチェックを行っているのでエラーが発生しない)
//
// エルビス演算子と似てるけど、こっち使った方がベターなケースが多そう。

$param_n1 = 'exists';
$param_n2 = null;
// $param_n3 = '定義しない';
$param_n4 = 0;

$getted_param_n1 = $param_n1 ?? 'not_exists';
$getted_param_n2 = $param_n2 ?? 'not_exists';
$getted_param_n3 = $param_n3 ?? 'not_exists';  // PHP Notice が発生しない
$getted_param_n4 = $param_n4 ?? 'not_exists';

echo($getted_param_n1 . PHP_EOL);  //=> 'exists'
echo($getted_param_n2 . PHP_EOL);  //=> 'not_exists'
echo($getted_param_n3 . PHP_EOL);  //=> 'not_exists'
echo($getted_param_n4 . PHP_EOL);  //=> '0'

// リクエストパラメータに使ったりとか
$user_name = $_POST['user_name'] ?? 'default_user';


//==========================
//    switch 条件分岐
//==========================
$signal10 = "green";

switch ($signal10) {
  case "red":
    echo "stop!";
    break;
  case "blue":
  case "green":
    echo "go!";
    break;
  case "yellow":
    echo "caution!";
    break;
  default:
    echo "wrong signal";
    break;
}

echo "<br>";
//==========================
//       while
//==========================
$i11 = 0;
while ($i11 < 10) {
  echo $i11;
  $i11++;
}

$i11 = 99;
do {
  echo $i11;
  $i11++;
} while ($i11 < 10);

echo "<br>";
//==========================
//       for
//==========================
for ($i12 = 0; $i12 < 10; $i12++) {
  if ($i12 === 5) {
    continue;
  }
  if ($i12 === 8) {
    break;
  }
  echo $i12;
}

// // ２重ループのブレイク
// break 2;


//==========================
//       配列
//==========================
// key value
$sales13A = array(
  "kaki" => 200,
  "ogawa" => 800,
  "shin" => 600,
);

// PHP5.4～
$sales13B = [
  "kaki" => 200,
  "ogawa" => 800,
  "shin" => 600,
];

var_dump($sales13B["ogawa"]); // 800
$sales13B["ogawa"] = 900;
var_dump($sales13B["ogawa"]); // 900

$colors13 = ["red", "blue", "pink"];
var_dump($colors13[1]); // blue

echo "<br>";

//-----< 末尾に要素を追加 >-----
$array2 = [];
array_push($array2, "a");
array_push($array2, "bb");


//-----< 末尾に要素を追加（ [] を使うパターン） >-----
// array_push は、入れ子になってると上手く動かないケースがある？
// array_push() expects parameter 1 to be array, string given in XXX

//配列を設定する
$fruits = ['apple', 'orange', 'melon'];
//値を追加する
$fruits[] = 'banana';
$fruits[] = 'pineapple';


//-----< 先頭に要素を追加 >-----
// array_unshift


//-----< 末尾に要素を取り出す（破壊的に） >----
//array_pop() は配列 array の最後の要素の値を取り出して返します。 配列 array は、要素一つ分短くなります。

$stack = array("orange", "banana", "apple", "raspberry");
$fruit = array_pop($stack);

print_r($fruit);  //-> "raspberry"
print_r($stack);
// Array
// (
//     [0] => orange
//     [1] => banana
//     [2] => apple
// )




//-----< 連結(join) >-----
echo( join('<br>', $array2) );


//-----< キーを指定して追加（連想配列） >-----
$array3 = [];
$array3['a'] = "a";
$array3['b'] = "bb";
$array3['c'] = "ccc";
echo "<br>==============<br>";
var_dump($array3);
echo "<br>==============<br>";


//-----< 入れ子 >-----
/*
Smarty_Variable Object (3)
->value = Array (16)
  user_id => null
  password => ""
  company_name => ""
  errMessageArray => Array (6)
    email => "Eメールが入力されていません"
    password => "パスワードが入力されていません"
    company_name => "会社名が入力されていません"
*/
/*
echo "$userParameters['errMessageArray']['email']";
*/


// split
$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
$pieces = explode(" ", $pizza);

// join
$array = array('lastname', 'email', 'phone');
$comma_separated = implode(",", $array);

//////  配列の結合 /////
$pager["chunk"] = array_merge($pager["chunk"], $dynamicContentArray);
$pager["chunk"] = array_merge_recursive($pager["chunk"], $dynamicContentArray);

// $newArray01 = array_merge($arrayFirst, $arraySecond)
// $newArray02 = array_merge_recursive($arrayFirst, $arraySecond)


//文字列⇒配列化
$piecesUserId = explode(" ", preg_replace('/\s+/', ' ', trim($_GET['user_id'])));

//配列⇒文字列
$separatedArray = implode(",", $pieces);


//-----( map )-----
$a1 = array_map(function($value) { return mb_strtolower($value); }, $pathArray);
$a2 = array_map(function($value) { return strtoupper($value); }, $pathArray);

$array_01 = ["1", "2", "", "3", "4", null, "5"];
$manipulated_array_01 = array_map(function($v) { return intval($v); }, $array_01 );  //=> [1, 2, 0, 3, 4, 0, 5]
$manipulated_array_02 = array_map('intval', $array_01);                              //=> [1, 2, 0, 3, 4, 0, 5]  （↑と同じ）



//-----( filter )-----
// フィルタリング（先頭が '?' で開始する文字を対象外とする）
$stringQueryExcludedRequestUri = array_filter($requestUri, function($v){ return strpos($v, '?') === 0 ? false : true; } );

$array_11 = [1, 2, null, 3, 4, 0, 5];
$filterd_array_01 = array_filter($array_11);  // コールバック関数省略時、FALSE と等しいもの (boolean への変換 を参照ください) がすべて削除されます。
//// インデックスは変わらない？
// Array
// (
//     [0] => 1
//     [1] => 2
//     [3] => 3
//     [4] => 4
//     [6] => 5
// )


//「無視リストにあるドメインは false を返す」みたいな感じの。
return array_filter($domains, function ($d) use ($ignoreDomainList) {
  return !in_array($d, $ignoreDomainList);
});


// 自前で作ったメソッドをコールするパターン
$filterd_array_02 = array_filter($array_11, "odd");   //=> [1, 3, 5]
$filterd_array_03 = array_filter($array_11, "even");  //=> [2,  , 4,  0]

//-----------------------
function odd($var)
{
    // returns whether the input integer is odd
    return($var & 1);
}

function even($var)
{
    // returns whether the input integer is even
    return(!($var & 1));
}
//-----------------------


//-----( 便利関数 )-----
$string_a01 = 
<<<STRING
a
bb
ccc
STRING;
// My favourite use of this function is converting a string to an array, trimming each line and removing empty lines:
$array_a01 = array_filter(array_map('trim', explode("\n", $string_a01)), 'strlen');

// Array
// (
//     [0] => a
//     [1] => bb
//     [2] => ccc
// )



//-----( キーの存在チェック )-----
// array_key_exists — 指定したキーまたは添字が配列にあるかどうかを調べる

$search_array = array('first' => 1, 'second' => 4);
if (array_key_exists('first', $search_array)) {
    echo "この配列には 'first' という要素が存在します";
}



//-----( 要素が含まれているか確認 )-----
$os = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os, true)) {
    echo "Got Irix";
}
if (in_array("mac", $os, true)) {
    echo "Got mac";
}


//-----( 特定の要素をカウント )-----
//array_count_values()

$array = array(1, "hello", 1, "world", "hello");
print_r(array_count_values($array));

// Array
// (
//     [1] => 2
//     [hello] => 2
//     [world] => 1
// )


//-----( キーのみを取得 )-----
array_keys($a);


//-----( 値のみを取得 )-----
array_values($a);


//-----( 重複を削除 )-----
array_unique($template_list);


//-----( 配列をソート )-----
$fruits = array("lemon", "orange", "banana", "apple");
sort($fruits);

// fruits[0] = apple
// fruits[1] = banana
// fruits[2] = lemon
// fruits[3] = orange


//-----( 配列を逆順にソート )-----
$fruits = array("lemon", "orange", "banana", "apple");
rsort($fruits);

// 0 = orange
// 1 = lemon
// 2 = banana
// 3 = apple


//-----( 連想配列のソート )-----
//// arsort() - 連想キーと要素との関係を維持しつつ配列を逆順にソートする
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
arsort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}

// a = orange
// d = lemon
// b = banana
// c = apple


//// krsort() - 配列をキーで逆順にソートする
$fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
krsort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}

// d = lemon
// c = apple
// b = banana
// a = orange


//==========================
//     最大値・最小値
//==========================
echo max(2, 3, 1, 6, 7);   //=> 7
echo max(array(2, 4, 5));  //=> 5


echo min(2, 3, 1, 6, 7);   //=> 1
echo min(array(2, 4, 5));  //=> 2


$array = array(2,6,3,10,4);
echo max($array);  //=> 10
echo min($array);  //=> 2



//==========================
//         平均
//==========================
$params = [1, 2, 3, 4, 5];
$total = array_sum($params);
$average = round( $total / count($params), 0);

echo $average;  //=> 3


// 小数点第２位以下は切り捨て
$tmp_params = [1,2];
$tmp_avg_val_1 = round( array_sum($tmp_params) / count($tmp_params), 2, PHP_ROUND_HALF_DOWN);

// 小数点第１位以下は切り捨て
$tmp_avg_val_2 = floor( array_sum($tmp_params) / count($tmp_params) );


echo $tmp_avg_val_1;  //=> 1.5
echo $tmp_avg_val_2;  //=> 1


//==============================================================
//                       array_column
//==============================================================
$rows = [
  0 => [ 'id' => 40, 'title' => 'dave',    'comment' => 'Hello, world!'],
  1 => [ 'id' => 10, 'title' => 'alice',   'comment' => '你好，世界！'],
  2 => [ 'id' => 30, 'title' => 'charlie', 'comment' => 'こんにちは、世界！' ],
  3 => [ 'id' => 20, 'title' => 'bob',     'comment' => 'Salve , per omnia saecula !' ],
];

//------------------------------------------------
var_export(array_column($rows, 'id'));
// =>
// array (
//   0 => 40,
//   1 => 10,
//   2 => 30,
//   3 => 20,
// )

//------------------------------------------------
var_export(array_column($rows, 'title', 'id'));
// =>
// array (
//   40 => 'dave',
//   10 => 'alice',
//   30 => 'charlie',
//   20 => 'bob',
// )


//==========================
//      filter_var
//      filter_var_array
//==========================
//----------( filter_var )----------
// 指定したフィルタでデータをフィルタリングする

var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));  //=> 'bob@example.com'
var_dump(filter_var('aaabbccccdddddd', FILTER_VALIDATE_EMAIL));  //=> false

var_dump(filter_var('http://example.com',  FILTER_VALIDATE_URL));  //=> 'http://example.com'
var_dump(filter_var('http://example.com',  FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));  //=> false
var_dump(filter_var('http://example.com/', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));  //=> 'http://example.com/'
var_dump(filter_var('http://example.com/', FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED));       //=> false
var_dump(filter_var('http://example.com/?a=1', FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED));   //=> 'http://example.com/?a=1'


//// 検証フィルタ
// https://www.php.net/manual/ja/filter.filters.validate.php
//
//    FILTER_VALIDATE_BOOLEAN
//    FILTER_VALIDATE_EMAIL
//    FILTER_VALIDATE_FLOAT
//    FILTER_VALIDATE_INT
//    FILTER_VALIDATE_IP
//    FILTER_VALIDATE_MAC
//    FILTER_VALIDATE_REGEXP
//    FILTER_VALIDATE_URL     値が URL 形式である - ( http://www.faqs.org/rfcs/rfc2396 に準拠している) かどうか、
//        FILTER_FLAG_SCHEME_REQUIRED
//        FILTER_FLAG_HOST_REQUIRED
//        FILTER_FLAG_PATH_REQUIRED     末尾に「/」が必要か
//        FILTER_FLAG_QUERY_REQUIRED    クエリ文字必須
//


//----------( filter_var_array )----------
error_reporting(E_ALL | E_STRICT);
$data = array(
    'product_id'  => 'libgd<script>',
    'component'   => '10',
    'versions'    => '2.0.33',
    'testscalar'  => array('2', '23', '10', '12'),
    'testarray'   => '2',
);

$args = array(
    'product_id'  => FILTER_SANITIZE_ENCODED,
    'component'   => array('filter'  => FILTER_VALIDATE_INT,
                            'flags'   => FILTER_FORCE_ARRAY, 
                            'options' => array('min_range' => 1, 'max_range' => 10)
                           ),
    'versions'      => FILTER_SANITIZE_ENCODED,
    'doesnotexist'  => FILTER_VALIDATE_INT,
    'testscalar'    => array(
                              'filter' => FILTER_VALIDATE_INT,
                              'flags'  => FILTER_REQUIRE_SCALAR
                            ),
    'testarray'     => array(
                            'filter' => FILTER_VALIDATE_INT,
                            'flags'  => FILTER_FORCE_ARRAY,
                           )

);

$myinputs = filter_var_array($data, $args);

print_r($myinputs);
// Array
// (
//     [product_id] => libgd%3Cscript%3E
//     [component] => Array
//         (
//             [0] => 10
//         )
//
//     [versions] => 2.0.33
//     [doesnotexist] =>
//     [testscalar] =>
//     [testarray] => Array
//         (
//             [0] => 2
//         )
//
// )




//==========================
//       foreach
//==========================
$sales14 = [
  "kaki" => 200,
  "ogawa" => 800,
  "shin" => 600,
];

foreach ($sales14 as $key => $value) {
  echo "($key) $value ";
}

$colors14 = ["red", "blue", "pink"];

foreach ($colors14 as $value) {
  echo "$value ";
}

// foreach if while for コロン構文
foreach ($colors14 as $value) :
  echo "$value ";
endforeach;
?>
<ul>
  <?php foreach ($colors14 as $value) : ?>
  <li><?php echo "$value "; ?></li>
  <?php endforeach; ?>
</ul>


<?php

//===================================
//    current() / next() / prev()
//===================================
// current : 配列の現在の内部ポインタの要素の値を取得
$array = array('Apple', 'Banana', 'Pineapple', 'Strawberry');
echo $mode = current($array)."<br/>\n";   // Apple
echo $mode = next($array)."<br/>\n";      // Banana
echo $mode = current($array)."<br/>\n";   // Banana
echo $mode = prev($array)."<br/>\n";      // Apple
echo $mode = end($array)."<br/>\n";       // Strawberry
echo $mode = current($array)."<br/>\n";   // Strawberry



//===================================
//        reset() / end()
//===================================
// ポインタをリセットし、再度ステップ１開始します
$array = array('step one', 'step two', 'step three', 'step four');
next($array);
reset($array);
echo current($array) . "<br />\n"; // "step one"


// end - 配列の内部ポインタを最終要素にセットする
$fruits = array('リンゴ', 'バナナ', 'クランベリー');
echo end($fruits); // クランベリー

// array_key_last ((PHP 7 >= 7.3.0))



//==========================
//         関数
//==========================
function sayHi14($name) {
  echo "hi! $name";
}
sayHi14("John");

function sayHi15($name = "kaki") { //引数のデフォルト値を設定
  $lang = "php";
  echo "hi! $name from $lang";
  return "hi! " . $name;
}

sayHi15("Tom");
sayHi15("Bob");
sayHi15();

$s15 = sayHi15();
var_dump($s15);



//==========================
//       組み込み関数
//==========================
$x17 = 5.6;
echo ceil($x17);  // 6  小数切り上げ
echo floor($x17); // 5  少数切り捨て
echo round($x17); // 6  四捨五入
echo rand(1, 10); // 1～10 の範囲でランダム

$s17A = "hello";
$s17B = "ねこ";
echo strlen($s17A); // 5  文字数
echo mb_strlen($s17B); // 2  日本語はマルチバイトなので、mb_ 開始の関数を使用する
printf("%s - %s - %.3f", $s17A, $s17B, $x17); //書式を指定して出力。stringはs、floatはf。

$colors17 = ["red", "blue", "pink"];
echo count($colors17);
echo implode("@", $colors17);



//==========================
//       class
//==========================
class User {
  // property
  public $name;
  # private $name;
  # protected $name;
  public static $count = 0;

  // constructor
  public function __construct($name) {
    $this->name = $name;
    self::$count++;
  }

  // method
  public function sayHi() {
    echo "hi, i am $this->name!";
  }

  // finalを付けると、オーバーライド不可。
  final public function sayYes() {
    echo "Yes. I am $this->name!";
  }

  // staticメソッド
  public static function getMessage() {
    echo "hello from User class!";
  }
}

$tom = new User("Tom");
$bob = new User("Bob");

echo $tom->name; // Tom
$bob->sayHi(); // hi, i am Bob!


//==========================
//         継承
//==========================
class AdminUser extends User {
  public function sayHello() {
    echo "hello from Admin!";
  }
  // override
  public function sayHi() {
    echo "[admin] hi, i am $this->name!";
  }
}

//==========================
//        static
//==========================
User::getMessage();

$Yamada = new User("Yamada");
$Koga = new User("Koga");

echo User::$count; // 2



//==========================
//       抽象クラス
//==========================
abstract class BaseStaff {
  public $name;
  abstract public function sayHi();
}

class Staff extends BaseStaff {
  public function sayHi() {
    echo "hello from User";
  }
}

$Sawai = new Staff("Sawai");
$Sawai->sayHi();



//==========================
//     インターフェース
//==========================
interface sayHi {
  public function sayHi();
}

interface sayHello {
  public function sayHello();
}

class Player implements sayHi, sayHello {
  public function sayHi() {
    echo "impl hi!";
  }
  public function sayHello() {
    echo "impl hello!";
  }
}

$Hatano = new Player("Hatano");
$Hatano->sayHi();
$Hatano->sayHello();


//===========================
//      ポリモーフィズム
//===========================
// class_exists
// method_exists


if (class_exists($class)) {
    $controller =& new $class;
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
        exit;
    }
}


//===========================
//         トレイト
//===========================
// コードを再利用するための仕組み。多重継承みたいな事をさせたい時に。
// 基底クラスのメソッドを trait に持たせた方がよさそう？
// 基底クラスから継承したメンバーよりも、トレイトで追加したメンバーのほうが優先されます。
class Base {
    public function sayHello() {
        echo 'Hello ';
    }
}

trait SayWorld {
    public function sayHello() {
        echo 'Hey! ';
        parent::sayHello();
        echo 'World!';
    }
}

class MyHelloWorld extends Base {
    use SayWorld;
}

$o = new MyHelloWorld();
$o->sayHello();  //=> Hey! Hello World!


//----------------------------
//  トレイトの優先順位について
//----------------------------
trait HelloWorld {
    public function sayHello() {
        echo 'Hello World!';
    }
}

class TheWorldIsNotEnough {
    use HelloWorld;
    public function sayHello() {
        echo 'Hello Universe!';  // この場合、こっちが優先される。
    }
}

$o = new TheWorldIsNotEnough();
$o->sayHello();  //=> Hello Universe!



//-------------------------------------------------------------------------------------------------------
// 同一クラス内での複数のトレイト間の名前の衝突を解決するには、 insteadof 演算子を使って そのうちのひとつを選ぶ。
//-------------------------------------------------------------------------------------------------------
trait A {
    public function smallTalk() {
        echo 'trant A - smallTalk'. PHP_EOL;
    }
    public function bigTalk() {
        echo 'trant A - bigTalk' . PHP_EOL;
    }
}

trait B {
    public function smallTalk() {
        echo 'trant B - smallTalk'. PHP_EOL;
    }
    public function bigTalk() {
        echo 'trant B - bigTalk' . PHP_EOL;
    }
}

class Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
    }
}

class Aliased_Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;  // as 演算子を使って B の bigTalk の実装に talk というエイリアスを指定して使います
    }
}


$talker = new Talker();
$talker->smallTalk();   //=> trant B - smallTalk
$talker->bigTalk();     //=> trant A - bigTalk

$aliased_talker = new Aliased_Talker();
$aliased_talker->smallTalk();   //=> trant B - smallTalk
$aliased_talker->bigTalk();     //=> trant A - bigTalk
$aliased_talker->talk();        //=> trant B - bigTalk


//=================================
//   インスタンスメソッドのアレな仕様
//=================================
class SpecialUser {
	public $id;
	public $name;

    public function instanceMethod() {
        echo "instance Method";
    }

    public static function staticMethod() {
        echo "static method";
    }
}

SpecialUser::instanceMethod();  //なんとコールできてしまう。（ 7 からは警告が出て、将来的にサポートされなくなる。）


//==========================
//           例外
//==========================
function div27($a, $b) {
    try {
        if ($b === 0) {
            throw new Exception("cannot divide by 0!");
        }
        echo $a / $b;

    } catch (Exception $e) {
        echo $e->getMessage();

        // Exception::getLine        
        // 例外が作られた行を取得する        
        echo "The exception was created on line: " . $e->getLine();  //=> 例外が発生した行数を表示
    }
}

div27(7, 2);
div27(5, 0);



//==========================
//           改行
//==========================
//改行コード
echo PHP_EOL;


$message = "Melon\r\nBanana\r\nApple";

// string に含まれるすべての改行文字 (\r\n、 \n\r、\n および \r) の前に <br /> あるいは <br> を挿入して返します。 
echo nl2br($message);

// Melon<br />
// Banana<br />
// Apple


echo nl2br($message, false);
// Melon<br>
// Banana<br>
// Apple


//-----( <br>を改行に置換・・・するメソッドは無いんかな。 )-----
$str_02 = "line1<br>line2<br>line3";
$replaceText = str_replace("<br>", PHP_EOL, $str_02);


//==========================
//        文字コード
//==========================
mb_convert_encoding( $ex->getMessage(), 'utf-8', 'shift_jis' );


//==========================
//        to_string
//==========================
var_dump($select->__toString());


//==========================
//       int キャスト
//==========================
// 切り捨て
echo intval(1.1);  echo PHP_EOL;  //=> 1
echo intval(1.9);  echo PHP_EOL;  //=> 1
echo intval(2.9);  echo PHP_EOL;  //=> 2


//==========================
//       string キャスト
//==========================
echo strval("3");  echo PHP_EOL;  //=> 3


//==========================
//       () キャスト
//==========================
(int)$value;
(bool)$value;
(float)$value;
(string)$value;
(array)$value;
(object)$value;

// (array) の挙動について
//   ・NULL → 空の配列
//   ・その他のスカラー値 → 1個だけ入った配列
//   ・配列 → そのまま
//   ・オブジェクト → プロパティ値をキーにした連想配列

//==========================
//      array キャスト
//==========================
// クラス（インスタンス）を arrayにキャストできる。（プロパティを、配列の要素として取り出せる）

$userInstanceArray = (array)$userInstance;

//-----------------------------------------------

// ※array型なので、取り出す時は「->」ではない。
$userInstanceArray['company_name'];


//====================================
//  jsonもどきのよくわからんデータ形式
//====================================
// 正式名称なんて言うの？　これ。
$a1 = 'a:9:{s:13:"template_type";s:1:"1";s:13:"template_name";s:19: .........';

$a2 = unserialize($a1);

var_dump($a2);  #=> array(9) { ["template_type"]=> string(1) "1" 



//====================================
//  number_format   数値フォーマット
//====================================

$number_01 = 1234.56;

// 英語での表記 (デフォルト)
$english_format_number_01 = number_format($number_01);  //=> 1,235

// フランスの表記
$nombre_format_francais = number_format($number_01, 2, ',', ' ');  //=> 1 234,56


// 千位毎の区切りがない英語での表記
$number_02 = 1234.5678;
$english_format_number_02 = number_format($number_02, 2, '.', ''); //=> 1234.57


//=============================
//        日付の差分
//=============================
$time = '2001/7/24';

echo date_create($time)->diff(date_create())->format('%y');
echo date_create($time)->diff(date_create())->format('%y歳 %mヶ月 %d日 %h時間 %i分 %s秒');



//=====================================
//  list を使用した、疑似的な複数戻り値
//=====================================
list($array_01, $array_02, $array_03) = getListData();

function getListData(){
    $array_01 = [1, 3, 5];
    $array_02 = ['A', 'C', 'D'];
    $array_03 = ['n', 'm', 'k'];

    return array($array_01, $array_02, $array_03);
}


//// 公式マニュアル、こんな感じ。（初見、これ見た時「要るのかこれ？」と思った。）
$info = array('コーヒー', '茶色', 'カフェイン');
list($drink, $color, $power) = $info;



//==========================
//        空チェック
//==========================
if( is_null($val) ){
  echo "null";
}


if( empty($val) ){
  echo "empty";
}


//==========================
//     ユニークID作成
//==========================
$uniq_id = uniqid();

echo $uniq_id;  //=> 5e4fa68e7973f,  5e4fa696543c9,  5e4fa69d27492



//==========================
//         ハッシュ
//==========================
// パスワードのハッシュとか。
$password = '1234';
$hashed_password =  password_hash($password, PASSWORD_DEFAULT);

var_dump($hashed_password );
var_dump(password_verify ( $password , $hashed_password ) );



//==========================
//      フォルダ作成
//==========================
$target_dir = 'tmp';
if ( !file_exists( $target_dir ) ) {

    mkdir( $target_dir, 0777 );
    chmod( $target_dir, 0777 );
}


//==========================
//      フォルダ作成
//==========================
$log_file = 'log_20200221_5e4fa68e7973f';
if (false === file_exists($log_file) ) {
    touch($log_file);
}



//=======================================
//  ファイル存在チェック / ファイルサイズ
//=======================================
$target_file_full_path = __FILE__;

// ファイルシステム関数の中には 2GB より大きなファイルについては期待とは違う値を返すものがあります。
$size = filesize($target_file_full_path);  // 単位は多分 byte

$exists = file_exists($target_file_full_path); // true / false



//=============================
//   ファイル読み込み  readfile
//=============================

$file_name = __FILE__;  // フルパスが入ってる
readfile(__FILE__);     // 標準出力（コンソールに、このファイルの内容が出てくる）

////
$file = 'monkey.gif';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}


//==========================
//     ファイル書き込み
//==========================
$file = 'people.txt';
// ファイルをオープンして既存のコンテンツを取得します
$current = file_get_contents($file);
// 新しい人物をファイルに追加します
$current .= "John Smith\n";
// 結果をファイルに書き出します
file_put_contents($file, $current);


//==========================
//     ファイル削除
//==========================
// ファイル削除
unlink($file_name);


// ディレクトリ削除
if (!is_dir('examples')) {
    mkdir('examples');
}

rmdir('examples');



//================================================================================
//  ob_start / ob_get_contents / ob_end_flush  （出力内容を buffer に貯めておく）
//================================================================================
ob_start();               // start output buffer 1
echo "a";                 // fill ob1

    ob_start();               // start output buffer 2
    echo "b";                 // fill ob2
    $s1 = ob_get_contents();  // read ob2 ("b")
    ob_end_flush();           // flush ob2 to ob1

echo "c";                 // continue filling ob1
$s2 = ob_get_contents();  // read ob1 ("a" . "b" . "c")
ob_end_flush();           // flush ob1 to browser

// echoes "b" followed by "abc", as supposed to:
echo "<HR>$s1<HR>$s2<HR>";  // この時点で初めて標準出力として出てくる。（上記の echo の時は出力されない）


//====================================
//        メソッドの存在チェック
//====================================
if (method_exists($this->_account, $name) || preg_match('/^find/', $name)) {
  return call_user_func_array(array($this->_account, $name), $args);
}



//===========================
//  json エンコード/デコード
//===========================
$original_json_data = '{"id":1, "product_name":"K001-X299022A"}';
$decoded_data = json_decode($original_json_data, true);  // true の場合、返されるオブジェクトは連想配列形式になります。
$decoded_data['check_user']     = "5656";
$decoded_data['check_datetime'] = date("Y/m/d H:i");
$encoded_data = json_encode($decoded_data);


var_dump($encoded_data);  //=> string(97) "{"id":1,"product_name":"K001-X299022A","check_user":"5656","check_datetime":"2020\/02\/04 12:28"}"



//==========================
//      URLエンコード
//==========================
//URLとして使用できない文字や記号を、使用できる文字の特殊な組み合わせで表すように変換する。

// urlencode
$a1 = urlencode('abc_defああああ');

echo $a1;  #=> abc_def%E3%81%82%E3%81%82%E3%81%82%E3%81%82
echo "<br>";

// rawurlencode
//awurlencode関数は、インターネットに関する様々な仕様をまとめたRFC3986に沿った変換をしているため、urlencode関数よりrawurlencode関数を使ったほうが安全
$a2 = rawurlencode('abc_defああああ');

echo $a2;

// UTF-8の文字列をSJISに変換
$sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');



//====================================
//  特殊文字を HTML エンティティに変換
//====================================
$a1 = array("1","2","3","&","'","<",">",'"');
$r1 = htmlspecialchars_recursive($a1);
print_r($r1);
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => &amp;
//     [4] => '
//     [5] => &lt;
//     [6] => &gt;
//     [7] => &quot;
// )

function htmlspecialchars_recursive( $arg ) {

    $callback = function(&$value) {
        $value = htmlspecialchars($value);
    };

    array_walk_recursive( $arg, $callback );

    return $arg;
}

//====================================
//  HTML および PHP タグを取り除く
//====================================
$a2 = array("aa<br>bb","<?php  aaa<div>bbb</div>ccc");
$r2 = strip_tags_recursive($a2);
print_r($r2);
// Array
// (
//     [0] => aabb
//     [1] =>
// )

function strip_tags_recursive( $arg ) {

    $callback = function(&$value) {
        $value = strip_tags($value);
    };

    array_walk_recursive( $arg, $callback );

    return $arg;
}



//===========================
//      HTTP header
//===========================

// PDFを出力します
header('Content-Type: application/pdf');

// downloaded.pdf という名前で保存させます
header('Content-Disposition: attachment; filename="downloaded.pdf"');

// もとの PDF ソースは original.pdf です
readfile('original.pdf');

////
$path = urlencode($file);
header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename*=utf-8'ja'{$path}");
header('Content-Transfer-Encoding: binary');



//==========================
//   null 合体演算子 (??)
//==========================
//https://www.php.net/manual/ja/migration70.new-features.php

// $_GET['user'] を取得します。もし存在しない場合は
// 'nobody' を用います。
$username = $_GET['user'] ?? 'nobody';
// 上のコードは、次のコードと同じ意味です。
$username = isset($_GET['user']) ? $_GET['user'] : 'nobody';

// 合体演算子を連結することもできます。次のように書くと、
// $_GET['user']、$_POST['user'] そして 'nobody'
// の順に調べて、非 &null; が定義されている最初の値を返します。
$username = $_GET['user'] ?? $_POST['user'] ?? 'nobody';



//==========================
//      宇宙船演算子
//==========================

// 二つの式を比較するために使う。
// $a が $b より大きい場合は 1、 $a と $b が等しい場合は 0、 $a が $b より小さい場合は -1 をそれぞれ返します。

// 整数値
echo 1 <=> 1; // 0
echo 1 <=> 2; // -1
echo 2 <=> 1; // 1



//==========================
//    クラスに設定する定数
//==========================
class TmpClass01
{
    const DIRECTION_ID_EAST  = 1;
    const DIRECTION_ID_SOUTH = 2;
    const DIRECTION_ID_WEST  = 3;
    const DIRECTION_ID_NORTH = 4;

    const CONST_ARRAY_01 = [1,2,3];   // PHP7 なら使用可

    public static $PUBLIC_STATIC_ARRAY_01 = array(1, 3, 5);  // ↑の記述ができない古いPHPバージョンでの苦し紛れの策
}

$array_01 = TmpClass01::CONST_ARRAY_01;
$array_02 = TmpClass01::$PUBLIC_STATIC_ARRAY_01;


var_dump($array_01);
var_dump($array_02);


////////////////////////////////////////////////////////////////////////////////////////////////

//==================================================
//   http_build_query（リクエストパラメータを生成）
//==================================================
$request_params_01 = array(
  'foo' => 'bar',
  'baz' => 'boom',
  'cow' => 'milk',
  'php' => 'hypertext processor'
);

echo http_build_query($request_params_01);                //=> foo=bar&baz=boom&cow=milk&php=hypertext+processor
echo http_build_query($request_params_01, '', '&amp;');   //=> foo=bar&amp;baz=boom&amp;cow=milk&amp;php=hypertext+processor

//==================================================
//      parse_str（リクエストパラメータを分解）
//==================================================
$str = "first=value&arr[]=foo+bar&arr[]=baz";

parse_str($str, $output);
echo $output['first'];    // value
echo $output['arr'][0];   // foo bar
echo $output['arr'][1];   // baz

parse_str(http_build_query($request_params_01), $output2);
print_r($output2);
// Array
// (
//     [foo] => bar
//     [baz] => boom
//     [cow] => milk
//     [php] => hypertext processor
// )


//====================================
//             get_headers
//====================================
// HTTP リクエストに対するレスポンス内で サーバーによって送出された全てのヘッダを取得する
$target_url = "http://www.example.com";

$headers_01 = get_headers($target_url);

// print_r($headers_01);
// Array
// (
//     [0] => HTTP/1.0 200 OK
//     [1] => Age: 552408
//     [2] => Cache-Control: max-age=604800
//     [3] => Content-Type: text/html; charset=UTF-8
//     [4] => Date: Thu, 13 Feb 2020 00:34:23 GMT
//     [5] => Etag: "3147526947+ident"
//     [6] => Expires: Thu, 20 Feb 2020 00:34:23 GMT
//     [7] => Last-Modified: Thu, 17 Oct 2019 07:18:26 GMT
//     [8] => Server: ECS (sjc/4FB8)
//     [9] => Vary: Accept-Encoding
//     [10] => X-Cache: HIT
//     [11] => Content-Length: 1256
//     [12] => Connection: close
// )



//====================================
//      apache_request_headers
//====================================
// 現在のリクエストにおけるすべての HTTP ヘッダの連想配列、 あるいは失敗時は FALSE を返します。

$headers = apache_request_headers();  // PHP Fatal error:  Uncaught Error: Call to undefined function apache_request_headers() 

foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}



//====================================
//          配列渡し・エスケープ
//====================================
/*
//=====< HTML >=====//
<input type='hidden' name='prefectureSet[]' value="01">
<input type='hidden' name='prefectureSet[]' value="02">
<input type='hidden' name='prefectureSet[]' value="03">
*/

//=====< PHP >=====//
$this->prefectureSet = [];
$prefectureSet = $this->parameters['prefecture'];

foreach ($prefectureSet as $value) {
	array_push($this->prefectureSet, MY_UTIL::sharpen($value));
}

// 単純に、
// $this->prefectureSet = MY_UTIL::sharpen($value);
// みたいにすると、nullになってしまう。



?>

</body>
</html>