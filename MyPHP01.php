<?php

// コメント
# コメント
/*
コメント
*/

echo "hello from the TOP!";

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
$max09 = ($a09 > $b09) ? $a09 : $b09; // () の条件が真だったら $a09 を、偽だったら $b09 を max09 に代入

if ($a09 > $b09) {
  $max09 = $a09;
} else {
  $max09 = $b09;
}

echo "<br>";
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
?>

</body>
</html>