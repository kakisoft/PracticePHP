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
define("MY_EMAIL", "taguchi@dotinstall.com");
echo MY_EMAIL;
echo "<br>";

//=============================
// 特殊用途の定数（自動的に定義）
//=============================
var_dump(__LINE__); // 現在の行数 
var_dump(__FILE__); // ファイル名
var_dump(__DIR__);  // ディレクトリ 
echo "<br>";

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

//==========================
// 文字列
// "" 特殊文字(\n, \t) 、変数が展開される
// '' そのまま出力する
//==========================
$name = "taguchi";
$s1 = "hello $name!\nhello again!";
$s2 = "hello {$name}!\nhello again!"; // 変数を{}で囲う事もできる
$s3 = "hello ${name}!\nhello again!"; // $を外に出せる
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

// 改行コード(\nまたは\rまたは\r\n)を''(空文字)に置き換える
$text = "";
$text = preg_replace('/\r\n|\r|\n/', '', $text);


//-------------------
//   文字列の検索
//-------------------
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// 見つからなかったら falseを返す
if ($pos === false) {
    echo "文字列 '$findme' は、文字列 '$mystring' の中で見つかりませんでした";
} else {
    echo "文字列 '$findme' が文字列 '$mystring' の中で見つかりました";
    echo " 見つかった位置は $pos です";
}

//==========================
// if 条件分岐
//   比較演算子 >   <   >=   <=   ==   ===   !=   !==
//   論理演算子 and && , or || , !
//==========================
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

// 三項演算子
$a09 = 10;
$b09 = 20;
$max09 = ($a09 > $b09) ? $a09 : $b09; // () の条件が真だったら $a09 をmax09 に代入。偽だったら $b09 を max09 に代入

if ($a09 > $b09) {
  $max09 = $a09;
} else {
  $max09 = $b09;
}

echo "<br>";


// if($cond===true){ func1(); }else{ func2(); }
// $cond===true ? func1() : func2();



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

echo "<br>";
//==========================
//       配列
//==========================
// key value
$sales13A = array(
  "taguchi" => 200,
  "fkoji" => 800,
  "dotinstall" => 600,
);

// PHP5.4～
$sales13B = [
  "taguchi" => 200,
  "fkoji" => 800,
  "dotinstall" => 600,
];

var_dump($sales13B["fkoji"]); // 800
$sales13B["fkoji"] = 900;
var_dump($sales13B["fkoji"]); // 900

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

//-----( map )-----
$a1 = array_map(function($value) { return mb_strtolower($value); }, $pathArray);
$a2 = array_map(function($value) { return strtoupper($value); }, $pathArray);


//-----( filter )-----
// フィルタリング（先頭が '?' で開始する文字を対象外とする）
$stringQueryExcludedRequestUri = array_filter($requestUri, function($v){ return strpos($v, '?') === 0 ? false : true; } );


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
echo max(2, 3, 1, 6, 7);   //=> 7
echo max(array(2, 4, 5));  //=> 5


echo min(2, 3, 1, 6, 7);   //=> 1
echo min(array(2, 4, 5));  //=> 2


$array = array(2,6,3,10,4);
echo max($array);  //=> 10
echo min($array);  //=> 2



//==========================
//         平均
//==========================
$params = [1, 2, 3, 4, 5];
$total = array_sum($params);
$average = round( $total / count($params), 0);

echo $average;  //=> 3


// 小数点第２位以下は切り捨て
$tmp_params = [1,2];
$tmp_avg_val_1 = round( array_sum($tmp_params) / count($tmp_params), 2, PHP_ROUND_HALF_DOWN);

// 小数点第１位以下は切り捨て
$tmp_avg_val_2 = floor( array_sum($tmp_params) / count($tmp_params) );


echo $tmp_avg_val_1;  //=> 1.5
echo $tmp_avg_val_2;  //=> 1



//==========================
//       foreach
//==========================
$sales14 = [
  "taguchi" => 200,
  "fkoji" => 800,
  "dotinstall" => 600,
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
echo $mode = current($array)."<br/>\n"; // Apple
echo $mode = next($array)."<br/>\n"; // Banana
echo $mode = current($array)."<br/>\n"; // Banana
echo $mode = prev($array)."<br/>\n"; // Apple
echo $mode = end($array)."<br/>\n"; // Strawberry
echo $mode = current($array)."<br/>\n"; // Strawberry



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



echo "<br>";
//==========================
//         関数
//==========================
function sayHi14($name) {
  echo "hi! $name";
}
sayHi14("John");

function sayHi15($name = "taguchi") { //引数のデフォルト値を設定
  $lang = "php";
  echo "hi! $name from $lang";  
  return "hi! " . $name;
}

sayHi15("Tom");
sayHi15("Bob");
sayHi15();

$s15 = sayHi15();
var_dump($s15);


echo "<br>";
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


echo "<br>";
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


echo "<br>";
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

echo "<br>";
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

echo "<br>";
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
 
echo nl2br($message);
// Melon<br />
// Banana<br />
// Apple


echo nl2br($message, false);
// Melon<br>
// Banana<br>
// Apple



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
echo intval(1.1);  echo PHP_EOL;  //=> 1
echo intval(1.9);  echo PHP_EOL;  //=> 1
echo intval(2.9);  echo PHP_EOL;  //=> 2


//==========================
//       string キャスト
//==========================
echo strval("3");  echo PHP_EOL;  //=> 3


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



//=============================
//        日付の差分
//=============================
$time = '2001/7/24';

echo date_create($time)->diff(date_create())->format('%y');
echo date_create($time)->diff(date_create())->format('%y歳 %mヶ月 %d日 %h時間 %i分 %s秒');




//====================================
//        メソッドの存在チェック
//====================================
if (method_exists($this->_account, $name) || preg_match('/^find/', $name)) {
  return call_user_func_array(array($this->_account, $name), $args);
}



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
    const DIRECTION_ID_EAST  = 1;
    const DIRECTION_ID_SOUTH = 2;
    const DIRECTION_ID_WEST  = 3;
    const DIRECTION_ID_NORTH = 4;

    const CONST_ARRAY_01 = [1,2,3];  // PHP7 なら使用可

    public static $PUBLIC_STATIC_ARRAY_01 = array(1, 3, 5);  // ↑の記述ができない古いPHPバージョンでの苦し紛れの策
}

$array_01 = TmpClass01::CONST_ARRAY_01;
$array_02 = TmpClass01::$PUBLIC_STATIC_ARRAY_01;


var_dump($array_01);
var_dump($array_02);



    /**
     *  第１引数にて指定した連想配列から、「第２引数のキー、第３引数の値」に対応する、第４引数のキーの値を取得する。
     *  
     *＜例＞
     *第１引数（$target_array） : 
     * Array
     * (
     *     [0] => Array
     *         (
     *             [detail_id] => 1
     *             [category_id] => 10
     *             [category_name] => '缶'
     *         )
     *     [1] => Array
     *         (
     *             [detail_id] => 2
     *             [category_id] => 11
     *             [category_name] => 'ビン'
     *         )
     * )
     * 
     *  第２引数（$target_keys_name） : "detail_id"
     *  第３引数（$target_keys_val）    : 2 
     *  第３引数（$value_of_you_want_keys_name） : "category_name"
     * 
     * 
     *  戻り値：'ビン'
     * 
     * */
     private function getRelativeValueFromTargetList($target_array, $target_keys_name, $target_keys_val, $value_of_you_want_keys_name) {

    foreach($target_array as $value){
              if($value[$target_keys_name] === $target_keys_val) {
                  return $value[$value_of_you_want_keys_name];
              }
          }
  
          return null;
      }
  

?>

</body>
</html>