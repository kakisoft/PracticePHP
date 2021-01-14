  <?php

// コメント
# コメント
/*
コメント
*/


/**
 * @property array  $preferences
 * @property int    $id
 * @property bool   $is_admin
 * @property string $lastfm_session_key
 * @property string $email
 * @property string $password
 *
 * @method static self create(array $params)
 * @method static int count()
 * @method static Collection where(string $key, $val)
 */
class User extends Authenticatable
{




    /**
     * Update current user's profile
     *
     * @bodyParam name string required New name. Example: Johny Doe
     * @bodyParam email string required New email. Example: johny@doe.com
     * @bodyParam password string New password (null/blank for no change)
     *
     * @response []
     *
     * @throws RuntimeException
     *
     * @return JsonResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        if (config('koel.misc.demo')) {
            return response()->json();
        }

        $data = $request->only('name', 'email');

        if ($request->password) {
            $data['password'] = $this->hash->make($request->password);
        }

        return response()->json($request->user()->update($data));
    }



    /**
     * XXXXX状況問い合わせAPI
     *
     * @param Request $request
     * @param integer $receipt_no 受付番号
     * @return JsonResponse
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
//         名前空間
//===========================
//----------( file_01.php )--------------
namespace Foo\Bar\Baz\Lib3;

class FooSampleClass01 {
    public function getSomeName() {
        $ret = "[" . __NAMESPACE__ . "]-[" . __CLASS__ . "]-[" . __METHOD__ . "]";
        return $ret;
    }
}
//----------( file_02.php )--------------
use Foo\Bar\Baz\Lib3 as Lib3;  // Foo\Bar\Baz\Lib1を、Lib1で参照できるようにエイリアスを作成。

//---------------------------------------


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



//=================================
//          オートロード
//=================================
// 使用されているクラスが require や use などで宣言されていなかった時、自動で読み込む仕組み。
// require の代わりに、こんな感じのコードを冒頭に持ってくるだけでOK。
spl_autoload_register(function ($class) {
  require($class . '.php');  //拡張子「.php」というファイル
});


//=================================
//      コマンドライン引数
//=================================

/*

php .\81_console.php 10 20 

*/

echo $argv[0]; //=> .\81_console.php（ $argv[0] は常に、スクリプトの実行に使う名前となります。 ）
$num1 = $argv[1] ?? 0;
$num2 = $argv[2] ?? 0;
echo $num1 + $num2; //=> 30


//=============================
//       ヒアドキュメント
//=============================
$string_01 = <<<HTML
変数を解釈する
HTML;

// heredoc
$this_alias = 'alias_01';
$html_01 = <<<HTML
変数を解釈する
<form name="admin_login" id="admin_login" method="POST" action="{$this_alias}">
HTML;


// nowdoc
$html_02 = <<<'HTML'
そのまま表示する
<form name="admin_login" id="admin_login" method="POST" action="{$this_alias}">
HTML;


$html_03 = <<<'HTML'
  段上げされる
  HTML;


//-----------------------------
// フォーマットされた文字列を返す
//-----------------------------
// printf() は出力を行い、sprintf() は結果を文字列として返す。
// vsprintf - sprintf() と動作は同じですが、 可変長の引数ではなく配列を引数とします。

//----------( 文字列を生成 )----------
// 文字列 %s 、整数 %d 、浮動小数点数 %f 
$result1 = sprintf('%02d', 1); // 01
$result2 = sprintf('%03d', 1); // 001
$result3 = sprintf('あなたのIDは%04dです', 1); // あなたのIDは0001です


//----------( 出力 )----------
$param1 = "Hello";
$param2 = 1;
$param3 = 5.6;

printf("%s - %d - %.3f ", $param1, $param2, $param3);  //=> Hello - 1 - 5.600 
// 書式を指定して出力。stringはs、floatはf。


$n =  43951789;
$u = -43951789;
$c = 65; // ASCII の 65番目は 'A'
printf("%%b = '%b'\n", $n); // バイナリ表現
printf("%%c = '%c'\n", $c); // ASCII 文字を出力。chr() 関数と同じ
printf("%%d = '%d'\n", $n); // 標準的な整数表現
printf("%%e = '%e'\n", $n); // 科学的記法
printf("%%u = '%u'\n", $n); // 正の整数の符号なし整数表現
printf("%%u = '%u'\n", $u); // 負の整数の符号なし整数表現
printf("%%f = '%f'\n", $n); // 浮動小数点表現
printf("%%o = '%o'\n", $n); // 8進数表現
printf("%%s = '%s'\n", $n); // 文字列表現
printf("%%x = '%x'\n", $n); // 16進数の表現(小文字)
printf("%%X = '%X'\n", $n); // 16進数の表現(大文字)

printf("%%+d = '%+d'\n", $n); // 正の整数値の符号
printf("%%+d = '%+d'\n", $u); // 負の整数値の符号


print vsprintf("%04d-%02d-%02d", explode('-', '1988-8-1'));


//----------( vsprintf )----------
print vsprintf("%04d-%02d-%02d", explode('-', '1988-8-1'));
//=> 1988-08-01


//=============================
//       文字列をスラッシュでクォート
//=============================
// エスケープすべき文字の前にバックスラッシュを付けて返します。 エスケープすべき文字とは、以下のとおりです。
// ・シングルクォート (')
// ・ダブルクォート (")
// ・バックスラッシュ (\)
// ・NUL (NULL バイト)


// addslashes
$str = "Is your name O'Reilly?";

echo addslashes($str);  //=> Is your name O\'Reilly?


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


//==========================
//      グローバル変数
//==========================
$rate = 1.1; // グローバルスコープ

function sum($a, $b)
{
  global $rate;
  return ($a + $b) * $rate;
}


//=============================
//  特殊用途の定数（自動的に定義）
//=============================
var_dump(__LINE__); // 現在の行数
var_dump(__FILE__); // ファイル名
var_dump(__DIR__);  // ディレクトリ
var_dump($_SERVER['SERVER_NAME']);
var_dump(M_PI); // π


//====================================
//    CLIで実行されているかをチェック
//====================================
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


$sapi_name = php_sapi_name();
echo $sapi_name;
//=> "cli"
//=> "cgi-fcgi"
// 等


//====================================
//      エラーメッセージの表示制御
//====================================
// 全てのエラー出力をオフにする
error_reporting(0);

// 単純な実行時エラーを表示する
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// E_NOTICE を表示させるのもおすすめ（初期化されていない
// 変数、変数名のスペルミスなど…）
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// E_NOTICE 以外の全てのエラーを表示する
error_reporting(E_ALL & ~E_NOTICE);

// 全ての PHP エラーを表示する (Changelog を参照ください)
error_reporting(E_ALL);

// 全ての PHP エラーを表示する
error_reporting(-1);

// error_reporting(E_ALL); と同じ
ini_set('error_reporting', E_ALL);


//=================================
//       ランダムな値を取得
//=================================

//----------( rand )----------
// rand — 乱数を生成する
echo rand() . PHP_EOL;  //=> 1979097812
echo rand() . PHP_EOL;  //=> 1539890697
echo rand(1, 10) . PHP_EOL;  // 1～10 の範囲でランダム


//----------( mt_rand )----------
// mt_rand — メルセンヌ・ツイスター乱数生成器を介して乱数値を生成する（randより精度が高い？）
// この関数が生成する値は、暗号学的に安全ではありません。そのため、これを暗号として使ってはいけません。
// 暗号学的に安全な値が必要な場合は、random_int() か random_bytes() あるいは openssl_random_pseudo_bytes() を使いましょう。

echo mt_rand() . PHP_EOL;  //=> 766624948
echo mt_rand() . PHP_EOL;  //=> 945915221
echo mt_rand(5, 15);  // 1 ～ 15 の範囲でランダム


// mt_getrandmax — 乱数値の最大値を表示する
// mt_srand — メルセンヌ・ツイスター乱数生成器にシードを指定する
// random_int — 暗号論的に安全な疑似乱数を生成する
// random_bytes — 暗号論的に安全な、疑似ランダムなバイト列を生成する


//----------( srand )----------
// srand — 乱数生成器を初期化する
// 
// srand ([ int $seed ] ) : void
// シード seed で乱数生成器を初期化します。 seed を省略した場合はランダムな値が設定されます。

function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return $sec + $usec * 1000000;
}
srand(make_seed());
$randval = rand();


//====================================
//         is_XXX 型チェック
//====================================

//----------( is_numeric )----------
// 変数が数字または数値形式の文字列であるかを調べる
var_dump( is_numeric(42)  );              //=> bool(true)
var_dump( is_numeric("42")  );            //=> bool(true)
var_dump( is_numeric(4.2) );              //=> bool(true)
var_dump( is_numeric("4.2") );            //=> bool(true)
var_dump( is_numeric(".2") );             //=> bool(true)   !!??
var_dump( is_numeric("4") );              //=> bool(true)
var_dump( is_numeric("4.") );             //=> bool(true)   !!??
var_dump( is_numeric("4..2") );           //=> bool(false)
var_dump( is_numeric("") );               //=> bool(false)
var_dump( is_numeric("e") );              //=> bool(false)
var_dump( is_numeric(02471) );            //=> bool(true)
var_dump( is_numeric("02471") );          //=> bool(true)
var_dump( is_numeric(0x539) );            //=> bool(true)
var_dump( is_numeric("0x539") );          //=> bool(false)  !!??
var_dump( is_numeric(0b10100111001) );    //=> bool(true)   !!??
var_dump( is_numeric("0b10100111001") );  //=> bool(false)
var_dump( is_numeric(1337e0) );           //=> bool(true)   !!??
var_dump( is_numeric(array()) );          //=> bool(false)
var_dump( is_numeric(null ));             //=> bool(false)


 //----------( is_float )----------
var_dump( is_float(27.25) );    //=> bool(true)
var_dump( is_float("27.25") );  //=> bool(false)   is_numeric と違う。当然か float じゃないし。
var_dump( is_float(23) );       //=> bool(false)  ちょっと判定厳しくない？
var_dump( is_float(23.0) );     //=> bool(true)
var_dump( is_float(1e7) );      //=> bool(true)    !!??
var_dump( is_float(true) );     //=> bool(false)
var_dump( is_float(".1") );     //=> bool(false)
var_dump( is_float("5.") );     //=> bool(false)
var_dump( is_float(".5.") );    //=> bool(false)
var_dump( is_float("5..2") );   //=> bool(false)
var_dump( is_float('abc') );    //=> bool(false)


//----------( is_int )----------
var_dump( is_int(23) );       //=> bool(true)
var_dump( is_int("23") );     //=> bool(false)   is_numeric と違う。当然か int じゃないし。
var_dump( is_int(27.25) );    //=> bool(false)
var_dump( is_int("27.25") );  //=> bool(false)
var_dump( is_int(1e7) );      //=> bool(false)
var_dump( is_int(true) );     //=> bool(false)
var_dump( is_int(".1") );     //=> bool(false)
var_dump( is_int("5.") );     //=> bool(false)
var_dump( is_int(".5.") );    //=> bool(false)
var_dump( is_int("5..2") );   //=> bool(false)
var_dump( is_int('abc') );    //=> bool(false)


//----------( is_bool )----------
var_dump( is_bool(0) );       //=> bool(false)
var_dump( is_bool("0") );     //=> bool(false)
var_dump( is_bool(true) );    //=> bool(true)
var_dump( is_bool(false) );   //=> bool(true)


//----------( is_string )----------
var_dump( is_string(false) );   //=> bool(false)
var_dump( is_string(true) );    //=> bool(false)
var_dump( is_string(null) );    //=> bool(false)
var_dump( is_string('abc') );   //=> bool(true)
var_dump( is_string('23') );    //=> bool(true)
var_dump( is_string(23) );      //=> bool(false)
var_dump( is_string('23.5') );  //=> bool(true)
var_dump( is_string(23.5) );    //=> bool(false)
var_dump( is_string('') );      //=> bool(true)
var_dump( is_string(' ') );     //=> bool(true)
var_dump( is_string('0') );     //=> bool(true)
var_dump( is_string(0) );       //=> bool(false)


 //----------( is_array )----------
 $yes = array('this', 'is', 'an array');
 $no = 'this is a string';
 var_dump( is_array($yes) );  //=> bool(true)
 var_dump( is_array($no) );   //=> bool(false)


//----------( is_object )----------
var_dump( is_object(new stdClass()) );  //=> bool(true)
var_dump( is_object(array('Kalle')) );  //=> bool(false)


//----------( is_resource )----------
// is_resource — 変数がリソースかどうかを調べる
// is_resource() は、厳格な型チェックを行うわけではありません。 var がすでに閉じられたリソース変数である場合は、FALSE を返します。

$fp = fopen(__FILE__, "r");

if ( is_resource($fp) ){
    echo "This is resorce!";
}
else{
    throw new \RuntimeException("unable open self");
}


//====================================
//         空チェック( empty )
//====================================
// 0 や "0" を true と判定するのをOKとしない場合は注意を。
var_dump( empty("")  );       //=> bool(true)
var_dump( empty(0)  );        //=> bool(true)
var_dump( empty(0.0)  );      //=> bool(true)
var_dump( empty("0")  );      //=> bool(true)
var_dump( empty(NULL)  );     //=> bool(true)
var_dump( empty(FALSE)  );    //=> bool(true)
var_dump( empty(array())  );  //=> bool(true)
var_dump( empty("a")  );      //=> bool(false)


//----------( 他にこんな方法とか )----------
var_dump( strlen("") <= 0  );       //=> bool(true)
var_dump( strlen(0) <= 0  );        //=> bool(false)
var_dump( strlen(0.0) <= 0  );      //=> bool(false)
var_dump( strlen("0") <= 0  );      //=> bool(false)
var_dump( strlen(NULL) <= 0  );     //=> bool(true)
var_dump( strlen(FALSE) <= 0  );    //=> bool(true)
var_dump( strlen(array()) <= 0  );  //=> bool(true)  ※Warningが出る
var_dump( strlen("a") <= 0  );      //=> bool(false)


//====================================
//     変数がセットさているかチェック
//====================================
$param1 = '';
$param2 = null;
$param3 = false;
$param4 = 0;
$param5 = array();
var_dump( isset($param1) );  //=> bool(true)
var_dump( isset($param2) );  //=> bool(false)
var_dump( isset($param3) );  //=> bool(true)
var_dump( isset($param4) );  //=> bool(true)
var_dump( isset($param5) );  //=> bool(true)
var_dump( isset($paramX) );  //=> bool(false)  未定義の変数

unset($param1);
var_dump( isset($param1) );  //=> bool(false)



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


//=================================
//         代入演算子
//=================================

/*

$a &= $b は、$a = $a & $b 
を短くした書き方になります。

*/


//=================================
//  四捨五入・切り上げ・切り捨て
//=================================

$x17 = 5.6;
echo ceil($x17);   // 6  小数切り上げ
echo floor($x17);  // 5  少数切り捨て
echo round($x17);  // 6  四捨五入



//===========================
//    定義済み変数を取得
//===========================
$a1 = get_defined_constants();

print_r(array_keys($a1));


// 実際は1000個ぐらいある
// Array
// (
//     [PHP_VERSION] => 7.3.11
//     [PHP_MAJOR_VERSION] => 7
//     [PHP_MINOR_VERSION] => 3
//     [PHP_RELEASE_VERSION] => 11
//     [PHP_ZTS] => 0
//     [PHP_DEBUG] => 0
//     [PHP_SAPI] => cli
//     [DEFAULT_INCLUDE_PATH] => .;C:\php\pear
//     [PHP_PREFIX] => C:\php
//     [PHP_BINDIR] => C:\php
//     [PHP_LIBDIR] => C:\php
//     [PHP_DATADIR] => C:\php
//     [PHP_BINARY] => C:\tools\php73\php.exe
// )


// get_defined_vars() - 全ての定義済の変数を配列で返す
// get_defined_constants() - すべての定数の名前とその値を連想配列として返す
// get_declared_classes() - 定義済のクラスの名前を配列として返す


//===========================
//      ウェイト(wait)
//===========================

//----------(  実行を遅延させる。単位は秒。 )----------
// 現在の時刻
echo date('h:i:s') . "\n";

// 10 秒間遅延させる
sleep(10);

// 再開!
echo date('h:i:s') . "\n";



//----------( マイクロ秒（百万分の一秒）単位で実行を遅延させる )----------

// 現在の時刻
echo date('h:i:s') . "\n";

// 2 秒待つ
usleep(2000000);

// 復帰!
echo date('h:i:s') . "\n";


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

//-----------------------------
//        文字列の置換
//-----------------------------

// 大文字小文字を区別しない「 str_ireplace() 」というのもある。

// "A" という文字列を "×" に置換する
$replaceText = str_replace("A", "×", $targetText);

//----------( 小文字に変更 )----------
$str = "Mary Had A Little Lamb and She LOVED It So";
$str = mb_strtolower($str);
$str = strtolower($str);


//----------( 大文字に変更 )----------
$str = "Mary Had A Little Lamb and She LOVED It So";
$str = strtoupper($str);


//----------( １対１の置換 )----------
//          You should eat pizza,  beer,       and ice   every day となります
$phrase  = "You should eat fruits, vegetables, and fiber every day.";
$healthy = array("fruits", "vegetables", "fiber");
$yummy   = array("pizza" , "beer"      , "ice");

$newphrase = str_replace($healthy, $yummy, $phrase);


//----------( 置換した回数をカウント )----------
$str = str_replace("ll", "", "good golly miss molly!", $count);
echo $count;  //=> 2



//---------------------------
//     全角⇔半角　の置換
//---------------------------
// 全角カタカナに変換
$str = "ｺﾝﾅｶﾝｼﾞ";
$converted_str = mb_convert_kana($str, "KVC");
echo $converted_str;  //=> "コンナカンジ"

// 「半角カタカナ」を「全角カタカナ」に変換し、「全角」英数字を「半角」に変換
$str = "ｺﾝﾅｶﾝｼﾞ１Ａ";
$converted_str = mb_convert_kana($str, "KVa");
echo $converted_str;  //=> "コンナカンジ1A"

//// オプション
// r	「全角」英字を「半角」に変換します。
// R	「半角」英字を「全角」に変換します。
// n	「全角」数字を「半角」に変換します。
// N	「半角」数字を「全角」に変換します。
// a	「全角」英数字を「半角」に変換します。
// A	「半角」英数字を「全角」に変換します （"a", "A" オプションに含まれる文字は、U+0022, U+0027, U+005C, U+007Eを除く U+0021 - U+007E の範囲です）。
// s	「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
// S	「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
// k	「全角カタカナ」を「半角カタカナ」に変換します。
// K	「半角カタカナ」を「全角カタカナ」に変換します。
// h	「全角ひらがな」を「半角カタカナ」に変換します。
// H	「半角カタカナ」を「全角ひらがな」に変換します。
// c	「全角カタカナ」を「全角ひらがな」に変換します。
// C	「全角ひらがな」を「全角カタカナ」に変換します。
// V	濁点付きの文字を一文字に変換します。"K", "H" と共に使用します。



//-----------------------------
//     文字列の長さをチェック
//-----------------------------
$s17A = "hello";
$s17B = "ねこ";
echo strlen($s17A);     // 5  文字数
echo mb_strlen($s17B);  // 2  日本語はマルチバイトなので、mb_ 開始の関数を使用する


//-----------------------------
//   文字列の一部を指定して置換
//-----------------------------
$var = 'ABCDEFGH:/MNRPQR/';
echo substr_replace($var, 'bob', 10, -1) . PHP_EOL;  //=> ABCDEFGH:/bob/
echo substr_replace($var, 'bob', 1,   7) . PHP_EOL;  //=> Abob:/MNRPQR/


//----------( 正規表現による置換 )----------
//連続したスペースを、スペース１個分に置換
$string = "a  b   c       ddd";
$pattern = '/\s+/';
$replacement = ' ';
echo preg_replace($pattern, $replacement, $string);  #=> 「a b c ddd」
$pieces = explode(" ", $a);
// 置換する回数を指定できる
echo preg_replace($pattern, $replacement, $string, 1);  #=> 「a b  c ddd」

// 改行コード(\nまたは\rまたは\r\n)を''(空文字)に置き換える
$text = "";
$text = preg_replace('/\r\n|\r|\n/', '', $text);

// 正規表現にパターン修飾子の u を付けて、パターンと対象文字列を UTF-8 として処理するのが必要なケースも。（文字コードが UTF-8 であるのが前提）。
$str = preg_replace('/^[ 　]+/u', '', $str);


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

// stripos   — 大文字小文字を区別せずに文字列が最初に現れる位置を探す
// mb_strpos — 文字列の中に指定した文字列が最初に現れる位置を見つける


//-------------------
//    文字列の検索２
//-------------------
// strstr — 文字列が最初に現れる位置を見つける

// 説明
// string strstr ( string $haystack , mixed $needle [, bool $before_needle = false ] )

//もし特定の haystack に needle があるかどうかを調べるだけの場合、 より高速でメモリ消費も少ない strpos() を代わりに使用してください。

$email  = 'name@example.com';
$domain = strstr($email, '@');        //=> @example.com
$user   = strstr($email, '@', true);  //=> name



//-------------------
//  正規表現による文字列の検索（preg_match。ただし、今では strpos 推奨）
//-------------------
$is_matched = preg_match('/^find/', 'findUser', $matches, PREG_OFFSET_CAPTURE);
print_r($is_matched);  //=> 1
// マッチした場合 1 を返し、マッチしなかった場合 0 を返す。エラー発生時 False を返す。
print_r($matches);  //=> 1
// Array
// (
//     [0] => Array
//         (
//             [0] => find
//             [1] => 0
//         )
// )
//
// $matches[0] にはパターン全体にマッチしたテキストが代入され、 
// $matches[1] には 1 番目のキャプチャ用サブパターンにマッチした 文字列が代入され、といったようになります。


preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
print_r($matches);
// Array
// (
//     [0] => Array
//         (
//             [0] => foobarbaz
//             [1] => 0
//         )
//     [1] => Array
//         (
//             [0] => foo
//             [1] => 0
//         )
//     [2] => Array
//         (
//             [0] => bar
//             [1] => 3
//         )
//     [3] => Array
//         (
//             [0] => baz
//             [1] => 6
//         )
// )


// パターンのデリミタの後の "i" は、大小文字を区別しない検索を示す
if (preg_match("/php/i", "PHP is the web scripting language of choice.")) {
    echo "A match was found.";
} else {
    echo "A match was not found.";
}


// ある文字列が他の文字列内に含まれているかどうかを調べるためだけに preg_match() を使うのは避けた方が良いでしょう。 
// strpos() 関数を使うほうが速くなります。


//-------------------
//  正規表現による文字列の検索（ preg_match_all ）
//-------------------
$pattern = "/{[^}]*}/";
$subject = "{token1} foo {token2} bar";
preg_match_all($pattern, $subject, $matches);
print_r($matches);
// Array
// (
//     [0] => Array
//         (
//             [0] => {token1}
//             [1] => {token2}
//         )
// )


//---------------------------
//      文字列を丸める
//---------------------------
echo mb_strimwidth("Hello World", 0, 10, "...");  // "Hello W..." と出力します


//---------------------------
//         trim
//---------------------------
// 末尾の「/」を削除
$value = rtrim($value, '/');


//---------------------------
//  文字列の切り出し/切り取り
//---------------------------
//----------( substr )----------
var_dump( substr("abcdef",  0, 3 ) );    //=> string(3) "abc"
var_dump( substr("abcdef",  1    ) );    //=> string(5) "bcdef"
var_dump( substr("abcdef",  2    ) );    //=> string(4) "cdef"
var_dump( substr("abcdef",  1, 2 ) );    //=> string(2) "bc"
var_dump( substr("abcdef", -1    ) );    //=> string(1) "f"
var_dump( substr("abcdef", -2    ) );    //=> string(2) "ef"
var_dump( substr("abcdef", -3, 1 ) );    //=> string(1) "d"
var_dump( substr("abcdef", -3    ) );    //=> string(3) "def"


//----------( こんな方法も )----------
$expected_array_got_string = 'somestring';
var_dump($expected_array_got_string[0]);  //=> string(1) "s"
var_dump($expected_array_got_string[1]);  //=> string(1) "o"


//----------( 全角 )----------
// mb_substr - マルチバイト対応


//-----------------------------
//  特定の文字の出現回数を数える
//-----------------------------
$text = 'This is a test';

echo substr_count($text, 'is')    . PHP_EOL;     //=> 2（「is」が 2回出現）
echo substr_count($text, 'is', 3) . PHP_EOL;     //=> 1  （開始時のオフセットを第三引数に指定）
echo substr_count($text, 'is', 3, 2) . PHP_EOL;  //=> 0 （開始時オフセットから終端までの文字数を第四引数に指定）

$text2 = 'gcdgcdgcd';
echo substr_count($text2, 'gcdgcd') . PHP_EOL;  //=> 1 （重なっている副文字列はカウントされない）


//--------------------------------------
//   特定の文字で埋める（先頭 0埋めとか）
//--------------------------------------
$input = "5";
echo "【" . str_pad($input, 10                     ) . "】" . PHP_EOL;  //=> 【5         】
echo "【" . str_pad($input, 10, "0", STR_PAD_LEFT  ) . "】" . PHP_EOL;  //=> 【0000000005】
echo "【" . str_pad($input, 10, "0", STR_PAD_RIGHT ) . "】" . PHP_EOL;  //=> 【5000000000】
echo "【" . str_pad($input, 10, "_", STR_PAD_BOTH  ) . "】" . PHP_EOL;  //=> 【____5_____】
echo "【" . str_pad($input,  6, "*"                ) . "】" . PHP_EOL;  //=> 【5*****】


//---------------------------
//     文字列を繰り返し
//---------------------------
echo str_repeat("1",  5);  //=> 11111
echo str_repeat("34", 5);  //=> 3434343434


//--------------------------------------
//  指定した長さ、指定した値で配列を埋める
//--------------------------------------
$input = array(12, 10, 9);

$result = array_pad($input, 10, 0);  //=> [12, 10, 9, 0, 0, 0, 0, 0, 0, 0]


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

```
(expr1) ? (expr2) : (expr3)

式1 が TRUE の場合に 式2 を、 式1 が FALSE の場合に 式3 を値とします。
PHP 5.3 以降では、三項演算子のまんなかの部分をなくすこともできるようになりました。 
式 expr1 ?: expr3 の結果は、expr1 が TRUE と同等の場合は expr1、 それ以外の場合は expr3 となります。
```


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

//----------(  )----------
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

//---------------------------
//      末尾に要素を追加
//---------------------------
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


//---------------------------
//      先頭に要素を追加
//---------------------------
$fruits = ['apple', 'orange', 'melon'];

array_unshift($fruits, 'banana');
print_r($fruits);
// Array
// (
//     [0] => banana
//     [1] => apple
//     [2] => orange
//     [3] => melon
// )

array_unshift($fruits, 'grape', 'kiwi','watermelon');
print_r($fruits);


//------------------------------
//  末尾から要素を取り出す（破壊的に）
//------------------------------
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


//------------------------------
//  先頭から要素を取り出す（破壊的に）
//------------------------------
// array_shift — 配列の先頭から要素を一つ取り出す
$stack = array("orange", "banana", "apple", "raspberry");
$fruit = array_shift($stack);
print_r($stack);
// Array
// (
//     [0] => banana
//     [1] => apple
//     [2] => raspberry
// )



//---------------------------
//         連結(join)
//---------------------------
echo( join('<br>', $array2) );


//----------------------------
//  キーを指定して追加（連想配列）
//----------------------------
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


//---------------------------
//          split
//---------------------------
$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
$pieces = explode(" ", $pizza);
print_r($pieces);
// Array
// (
//     [0] => piece1
//     [1] => piece2
//     [2] => piece3
//     [3] => piece4
//     [4] => piece5
//     [5] => piece6
// )


//---------------------------
//           join
//---------------------------
$array = array('lastname', 'email', 'phone');
$comma_separated = implode(",", $array);
var_dump($comma_separated);  //=> lastname,email,phone



//---------------------------
//    配列の要素数をカウント
//---------------------------
$colors17 = ["red", "blue", "pink"];
echo count($colors17);  //=> 3


//------------------------------------------
//  配列の要素を痴漢・インデックスを指定して削除
//------------------------------------------

// array_splice — 配列の一部を削除し、他の要素で置換する
$scores_1 = [30, 40, 50, 60, 70, 80];
$scores_2 = [30, 40, 50, 60, 70, 80];
$scores_3 = [30, 40, 50, 60, 70, 80];
$scores_4 = [30, 40, 50, 60, 70, 80];
$scores_5 = [30, 40, 50, 60, 70, 80];

// index 2 以降を削除
array_splice($scores_1, 2);                 //=> Array( 30, 40)

// index 2～3 を削除
array_splice($scores_2, 2, 3);              //=> Array( 30, 40, 80)

// index 2～3 を削除し、間に100を挿入
array_splice($scores_3, 2, 3, 100);         //=> Array( 30, 40, 100, 80)

// index 2 の位置に、100, 101 を挿入
array_splice($scores_4, 2, 0, [100, 101]);  //=> Array( 30, 40, 100, 101, 50, 60, 70, 80)

// 前後切り出し
array_splice($scores_5, 2, -2);             //=> Array( 30, 40, 70, 80)


//---------------------------
//        配列の結合
//---------------------------
$pager["chunk"] = array_merge($pager["chunk"], $dynamicContentArray);
$pager["chunk"] = array_merge_recursive($pager["chunk"], $dynamicContentArray);

// $newArray01 = array_merge($arrayFirst, $arraySecond)
// $newArray02 = array_merge_recursive($arrayFirst, $arraySecond)


$a = [3, 4, 8];
$b = [4, 8, 12];
$merged = array_merge($a, $b);
$merged = [...$a, ...$b];


//---------------------------
//    文字列 ⇒ 配列（正規表現を使うパターン）
//---------------------------
// カンマまたは " ", \r, \t, \n , \f などの空白文字で句を分割する。
$keywords = preg_split("/[\s,]+/", "hypertext language, programming");
print_r($keywords);
// Array
// (
//     [0] => hypertext
//     [1] => language
//     [2] => programming
// )

//---------------------------
//       文字列 ⇒ 配列（explode）
//---------------------------
$piecesUserId = explode(" ", preg_replace('/\s+/', ' ', trim($_GET['user_id'])));

$getted_user_id = " 119210    425023         583472";
$formatted_user_id_list = preg_replace('/\s+/', ' ', trim($getted_user_id));
//=> "119210 425023 583472"

$pieces_user_id_list = explode(" ", preg_replace('/\s+/', ' ', trim($getted_user_id)));
print_r($formatted_user_id_list);
// Array
// (
//     [0] => 119210
//     [1] => 425023
//     [2] => 583472
// )


$pattern = '/\d{2}-\d{4}-\d{4}/';
$input = preg_replace($pattern, '**-****-****', $input);


//---------------------------
//       配列 ⇒ 文字列
//---------------------------
$pieces = array('lastname', 'email', 'phone');
$separatedArray = implode(",", $array);
print_r($separatedArray);  //=> lastname,email,phone


//---------------------------
//           map
//---------------------------
$a1 = array_map(function($value) { return mb_strtolower($value); }, $pathArray);
$a2 = array_map(function($value) { return strtoupper($value); }, $pathArray);

$array_01 = ["1", "2", "", "3", "4", null, "5"];
$manipulated_array_01 = array_map(function($v) { return intval($v); }, $array_01 );  //=> [1, 2, 0, 3, 4, 0, 5]
$manipulated_array_02 = array_map('intval', $array_01);                              //=> [1, 2, 0, 3, 4, 0, 5]  （↑と同じ）


//-----( アロー関数を使用する場合 )-----
$prices = [100, 200, 300];

$newPrices = array_map(
  fn($n) => $n * 1.1,
  $prices
);

print_r($newPrices);
// Array
// (
//     [0] => 110
//     [1] => 220
//     [2] => 330
// )



//---------------------------
//         filter
//---------------------------
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


//-----( アロー関数を使う場合 )-----
$numbers = range(1, 10);

$evenNumbers = array_filter(
  $numbers,
  fn($n) => $n % 2 === 0
);

print_r($evenNumbers);


//---------------------------
//      キーの存在チェック
//---------------------------
// array_key_exists — 指定したキーまたは添字が配列にあるかどうかを調べる

$search_array = array('first' => 1, 'second' => 4);
if (array_key_exists('first', $search_array)) {
    echo "この配列には 'first' という要素が存在します";
}


//---------------------------
//   要素が含まれているか確認
//---------------------------
$os = array("Mac", "NT", "Irix", "Linux");
if (in_array("Irix", $os, true)) {
    echo "Got Irix";
}
if (in_array("mac", $os, true)) {
    echo "Got mac";
}


//---------------------------
//  配列の要素（value）を検索
//---------------------------
$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

$key = array_search('green', $array);  // $key = 2;
$key = array_search('red', $array);    // $key = 1;



//---------------------------
//     特定の要素をカウント
//---------------------------
//array_count_values()

$array = array(1, "hello", 1, "world", "hello");
print_r(array_count_values($array));

// Array
// (
//     [1] => 2
//     [hello] => 2
//     [world] => 1
// )


//---------------------------
//       キーのみを取得
//---------------------------
array_keys($a);


//---------------------------
//       値のみを取得
//---------------------------
array_values($a);


//---------------------------
//       重複を削除
//---------------------------
array_unique($template_list);


//---------------------------
//       配列をソート（キーを再構成する）
//---------------------------
$fruits = array("lemon", "orange", "banana", "apple");
sort($fruits);

// fruits[0] = apple
// fruits[1] = banana
// fruits[2] = lemon
// fruits[3] = orange


//---------------------------
//     配列を逆順にソート（キーを再構成する）
//---------------------------
$fruits = array("lemon", "orange", "banana", "apple");
rsort($fruits);

// 0 = orange
// 1 = lemon
// 2 = banana
// 3 = apple


//---------------------------
//     連想配列のソート
//---------------------------

//----------( ksort — 配列をキーでソートする )----------
$fruits = array(
  "d" => "lemon",
  "a" => "orange",
  "b" => "banana",
  "c" => "apple"
);
ksort($fruits);
// Array
// (
//     [a] => orange
//     [b] => banana
//     [c] => apple
//     [d] => lemon
// )


//----------( asort —　valueでソート。PHP公式マニュアルの説明は、何かややこしい )----------
// キーの値を保持する。sort はキーを連番に再構成する。
$fruits = array(
  "d" => "lemon",
  "a" => "orange",
  "b" => "banana",
  "c" => "apple"
);
asort($fruits);
// Array
// (
//     [c] => apple
//     [b] => banana
//     [d] => lemon
//     [a] => orange
// )


//---------------------------
//     連想配列を逆順にソート
//---------------------------

//----------( krsort() - 配列をキーで逆順にソートする )----------
$fruits = array(
                  "d" => "lemon",
                  "a" => "orange",
                  "b" => "banana",
                  "c" => "apple"
              );
krsort($fruits);
// Array
// (
//     [d] => lemon
//     [c] => apple
//     [b] => banana
//     [a] => orange
// )


//----------( arsort() - value でソート。<連想キーと要素との関係を維持しつつ配列を逆順にソートする> )----------
// キーの値を保持する。asort はキーを連番に再構成する。
$fruits = array(
                  "d" => "lemon",
                  "a" => "orange",
                  "b" => "banana",
                  "c" => "apple"
                );
arsort($fruits);
// Array
// (
//     [a] => orange
//     [d] => lemon
//     [b] => banana
//     [c] => apple
// )


//------------------------------
//  DBから取得した値の形式をソート
//------------------------------
// usort — ユーザー定義の比較関数を使用して、配列を値でソートする
$data = [
  ['name' => 'taguchi', 'score' => 80],
  ['name' => 'kikuchi', 'score' => 60],
  ['name' => 'hayashi', 'score' => 70],
  ['name' => 'tamachi', 'score' => 60],
];

usort(
  $data,
  function ($a, $b) {
    if ($a['score'] === $b['score']) {
      return 0;  // 同値で順番を変えたく無い場合、0 を返す。
    }
    return $a['score'] > $b['score'] ? 1 : -1;  // $a['score'] が $b['score'] より大きいという並び替えをしたかったら 1 、そうで無い場合 -1 を返す。
  }
);

print_r($data);
// Array
// (
//     [0] => ([name] => kikuchi , [score] => 60)
//     [0] => ([name] => tamachi , [score] => 60)
//     [0] => ([name] => hayashi , [score] => 70)
//     [0] => ([name] => taguchi , [score] => 80)
// )


//----------------------------------------------
//  DBから取得した値の形式をソート（複数条件でソート）
//----------------------------------------------
// array_multisort — 複数または多次元の配列をソートする

$data = [
  ['name' => 'taguchi', 'score' => 80],
  ['name' => 'kikuchi', 'score' => 60],
  ['name' => 'hayashi', 'score' => 70],
  ['name' => 'tamachi', 'score' => 60],
];

$scores = array_column($data, 'score');
$names = array_column($data, 'name');

// array_multisort(
//   $scores,
//   $names,
//   $data
// );

array_multisort(
  $scores, SORT_DESC, SORT_NUMERIC,
  $names, SORT_DESC, SORT_STRING,
  $data
);

print_r($data);
// Array
// (
//     [0] => ([name] => taguchi , [score] => 80)
//     [0] => ([name] => hayashi , [score] => 70)
//     [0] => ([name] => tamachi , [score] => 60)
//     [0] => ([name] => kikuchi , [score] => 60)
// )



//---------------------------
//     配列の一部を切り取る
//---------------------------
$input = array("a", "b", "c", "d", "e");

$output_01 = array_slice($input, 2);      // returns "c", "d", "e"
$output_02 = array_slice($input, 2, 2);   // returns "c", "d"
$output_03 = array_slice($input, -2);     // returns "d", "e"
$output_04 = array_slice($input, -3, 2);  // returns "c", "d"

// 第三引数を true にすると、index を振り直さない。
print_r(array_slice($input, 2, -1));
print_r(array_slice($input, 2, -1, true));
// $preserve_keys = FALSE(default)
// Array
// (
//     [0] => c
//     [1] => d
// )

// $preserve_keys = TRUE
// Array
// (
//     [2] => c
//     [3] => d
// )


//---------------------------
//     配列をシャッフル
//---------------------------
$numbers = range(1, 20);
shuffle($numbers);
foreach ($numbers as $number) {
    echo "$number ";
}

//=> 3 14 19 10 6 11 1 13 18 17 7 15 2 9 5 20 4 12 8 16  （例）


//---------------------------
//   配列からランダムに値を取得
//---------------------------
$input = array("ネオ", "モーフィアス", "トリニティ", "サイファー", "タンク");
// ※array_rand で取得するのは、配列の「キー」
$rand_keys = array_rand($input, 2);
echo $input[$rand_keys[0]] . PHP_EOL;
echo $input[$rand_keys[1]] . PHP_EOL;


//---------------------------
//      最大値・最小値
//--------------------------  -
echo max(2, 3, 1, 6, 7);   //=> 7
echo max(array(2, 4, 5));  //=> 5


echo min(2, 3, 1, 6, 7);   //=> 1
echo min(array(2, 4, 5));  //=> 2


$array = array(2,6,3,10,4);
echo max($array);  //=> 10
echo min($array);  //=> 2



//---------------------------
//          平均
//---------------------------
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


//---------------------------
//  範囲を指定して配列を作成
//---------------------------
// 1 ～ 10 まで
foreach (range(0, 10) as $number) {
  echo $number;
}

$numbers = range(1, 10);
print_r($numbers);
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
//     [4] => 5
//     [5] => 6
//     [6] => 7
//     [7] => 8
//     [8] => 9
//     [9] => 10
// )


$numbers = range(1, 10, 2);
print_r($numbers);
// Array
// (
//     [0] => 1
//     [1] => 3
//     [2] => 5
//     [3] => 7
//     [4] => 9
// )



//---------------------------
//  配列を指定した値で埋める
//---------------------------
$a = array_fill(5, 6, 'banana');
$b = array_fill(-2, 4, 'pear');
print_r($a);
// Array
// (
//     [5]  => banana
//     [6]  => banana
//     [7]  => banana
//     [8]  => banana
//     [9]  => banana
//     [10] => banana
// )

print_r($b);
// Array
// (
//     [-2] => pear
//     [0]  => pear
//     [1]  => pear
//     [2]  => pear
// )

//---------------------------------
//  キーを指定して、配列を値で埋める
//---------------------------------
$keys = array('foo', 5, 10, 'bar');
$a = array_fill_keys($keys, 'banana');
print_r($a);
// Array
// (
//     [foo] => banana
//     [5]   => banana
//     [10]  => banana
//     [bar] => banana
// )



//---------------------------------
//      配列のキーと値を反転
//---------------------------------
$input = array("oranges", "apples", "pears");
$flipped = array_flip($input);

print_r($flipped);
// Array
// (
//     [oranges] => 0
//     [apples] => 1
//     [pears] => 2
// )


$input = array("a" => 1, "b" => 1, "c" => 2);
$flipped = array_flip($input);

print_r($flipped);
// Array
// (
//     [1] => b
//     [2] => c
// )


//---------------------------------
//         配列の差を抽出
//---------------------------------
// array_diff — 配列の差を計算する
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");

//-----( $array1 - $array2 )-----
$result = array_diff($array1, $array2);
print_r($result);
// Array
// (
//     [1] => blue
// )


//-----( $array2 - $array1 )-----
$result = array_diff($array2, $array1);
print_r($result);
// Array
// (
//     [0] => yellow
// )


//---------------------------------
//         配列の共通項を抽出
//---------------------------------
$array1 = array("a" => "green", "red", "blue");
$array2 = array("b" => "green", "yellow", "red");
$result = array_intersect($array1, $array2);
print_r($result);
// Array
// (
//     [a] => green
//     [0] => red
// )


//-----------------------------------
//   配列の差を抽出（添字の確認を含む）
//-----------------------------------
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");
$result = array_diff_assoc($array1, $array2);
print_r($result);
// Array
// (
//     [b] => brown
//     [c] => blue
//     [0] => red
// )


//--------------------------------------
//   配列の共通項を抽出（添字の確認を含む）
//--------------------------------------
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "b" => "yellow", "blue", "red");
$result_array = array_intersect_assoc($array1, $array2);
print_r($result_array);
// Array
// (
//     [a] => green
// )


//--------------------------------------
//              配列の展開
//--------------------------------------
// PHP 7.4 あたりから？
$moreScores = [
  55,
  72,
];

$scores = [
  90,
  40,
  ...$moreScores,
  100,
];

print_r($scores);
// Array
// (
//     [0] => 90
//     [1] => 40
//     [2] => 55
//     [3] => 72
//     [4] => 100
// )



//==================================================
//   配列の要素に対し、再帰的にユーザ定義の関数を実行
//==================================================
$sweet = array('Tom' => 'apple', 'Ken' => 'banana');
$fruits = array('sweet' => $sweet, 'sour' => 'lemon');

function test_print($item, $key)
{
    echo "$key holds $item\n";
}

array_walk_recursive($fruits, 'test_print');
// Tom holds apple
// Ken holds banana
// sour holds lemon


//----------( コールバックにする事も可 )----------
$a2 = array("aa<br>bb","<?php  aaa<div>bbb</div>ccc");
$r2 = strip_tags_recursive($a2);
print_r($r2);
// Array
// (
//     [0] => aabb
//     [1] =>
// )

function strip_tags_recursive( $arg ) {

    $callback = function(&$value) {
        $value = strip_tags($value);
    };

    array_walk_recursive( $arg, $callback );

    return $arg;
}


//==============================================================
//                  array_column（単一のカラムを返す）
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


//=================================
//        配列から変数を作成
//=================================
$array_fruit = array('apple'=>'赤','melon'=>'緑','banana'=>'黄');

extract($array_fruit);

// 連想配列から、以下のような変数が作成される
print_r( $apple  );  //=> 赤
print_r( $melon  );  //=> 緑
print_r( $banana );  //=> 黄


//=================================
//        変数から配列を作成
//=================================
$id      = '123';
$name    = 'Tom';
$address = 'Fukuoka';

$user = compact('id', 'name', 'address');
print_r( $user );
// Array
// (
//     [id] => 123
//     [name] => Tom
//     [address] => Fukuoka
// )


//=====================================
//  リクエストパラメータのフィルタリング
//=====================================

$search_html = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$search_url = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_ENCODED);
echo "You have searched for $search_html.\n";            //=> You have searched for .
echo "<a href='?search=$search_url'>Search again.</a>";  //=> <a href='?search='>Search again.</a>


//// filter_input ( int $type , string $variable_name [, int $filter = FILTER_DEFAULT [, mixed $options ]] ) : mixed
//
// type
// INPUT_GET、INPUT_POST、 INPUT_COOKIE、INPUT_SERVER あるいは INPUT_ENV のいずれか。
//
// filter
// 適用するフィルタの ID。フィルタの型 に、利用できるフィルタの一覧があります。
// （フィルタの型）
// https://www.php.net/manual/ja/filter.filters.php
//


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
//----------( foreach で listを使う )----------

// foreach で list() を使って、 ネストした配列を個別の変数に展開できるようになりました。
$array = [
  [1, 2, 11, 21, 31],
  [3, 4, 12, 22, 32],
];

foreach ($array as list($a, $b, $c, $e, $f)) {
echo "A:{$a}; B:{$b} C:{$c} D:{$c} E:{$c}" . PHP_EOL;
}
//=>
// A:1; B:2 C:11 D:11 E:11
// A:3; B:4 C:12 D:12 E:12


//----------( foreach にて、配列の最初と最後の要素に処理を追加 )----------
// PHP 7.3 以上
$items = [
  'tokyo' => '東京',
  'shibuya' => '渋谷',
  'harajuku' => '原宿',
  'yoyogi' => '代々木',
];

$keyFirst = array_key_first($items);
$keyLast = array_key_last($items);

foreach ($items as $key => $value) {
    if ($key === $keyFirst) {
        echo "$value is first" . PHP_EOL;
    }
    if ($key === $keyLast) {
        echo "$value is last" . PHP_EOL;
    }
}
//=>
// tokyo: 東京 is first
// yoyogi: 代々木 is last


// 配列から最初と最後の値だけ取り出したい場合
echo "{$items[array_key_first($items)]} is first" . PHP_EOL;
echo "{$items[array_key_last($items)]} is last" . PHP_EOL;


//===================================
//    current() / next() / prev()
//===================================
// current : 配列の現在の内部ポインタの要素の値を取得
$array = array('Apple', 'Banana', 'Pineapple', 'Strawberry');
echo $mode = current($array)   . PHP_EOL;   // Apple
echo $mode = next($array)      . PHP_EOL;   // Banana
echo $mode = current($array)   . PHP_EOL;   // Banana
echo $mode = prev($array)      . PHP_EOL;   // Apple
echo $mode = end($array)       . PHP_EOL;   // Strawberry
echo $mode = current($array)   . PHP_EOL;   // Strawberry



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



//==================================
//   関数(引数の型を指定：タイプヒント)
//==================================
// コンパイル時に型の整合性を検査する言語とは違い、 実行時に例外を投げる。

declare(strict_types=1);  // 型を厳密に扱いたい場合（強い型付け。）

function showInfo(string $name, int $score): void
{
  echo $name . ': ' . $score . PHP_EOL;
}

showInfo('kaki', 40);
// declare(strict_types=1) を付けない場合、OKとなる
showInfo('kaki', '4');  // デフォルトは弱い型付け。'4' でも、int 型として扱おうとする。



//==================================
//          関数(null 許容)
//==================================
declare(strict_types=1);

// 引数、戻り値に null を許容する
function getAward(?int $score): ?string
{
  return $score >= 100 ? 'Gold Medal' : null;
}

echo getAward(150) . PHP_EOL;
echo getAward(40) . PHP_EOL;


//==================================
//          関数(可変長引数)
//==================================
// https://www.php.net/manual/ja/migration56.new-features.php
function sum(...$numbers)
{
  $total = 0;
  foreach ($numbers as $number) {
    $total += $number;
  }
  return $total;
}

echo sum(1, 3, 5)    . PHP_EOL;  //=> 9
echo sum(4, 2, 5, 1) . PHP_EOL;  //=> 12



//==========================
//        無名関数
//==========================
// 無名関数はクロージャとも呼ばれる
// 関数名を指定せずに関数を作成できるようにするもの
$sum = function ($a, $b, $c) { // 無名関数（クロージャー）
  return $a + $b + $c;
};

echo $sum(100, 300, 500) . PHP_EOL;  //=> 900


// クロージャは、変数を親のスコープから引き継ぐことができます。 
// 引き継ぐ変数は、use で渡さなければなりません。 PHP 7.1 以降は、引き継ぐ値に superglobals や $this、およびパラメータと同じ名前の変数を含めてはいけません。

$message = 'hello';
// "use" がない場合
$example = function () {
    var_dump($message);
};
$example();  //=> NULL

//----------( useはクロージャの外で使われている変数をクロージャの中で使いたいときに使用する。 )----------

// $message を引き継ぎます
$example = function () use ($message) {
    var_dump($message);
};
$example();  //=> "hello"


//==========================
//       class
//==========================
class User {
  // property
  public $name;  // アクセス修飾子を付けない場合、public
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
  private $sponsor;

  public function __construct($name, $sponsor)
  {
    parent::__construct($name);  // 親クラスのコンストラクタを使用する
    $this->sponsor = $sponsor;
  }

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


//-----------------------
// インターフェースを実装していると、interface型として扱う事ができる
//-----------------------
$new_commer = new Player("Tom");

// 引数に sayHello インターフェースを実装したクラスを許可
function processLikable(sayHello $new_commer)
{
  $new_commer->sayHello();
}

// 引数に、sayHello インターフェースを実装したクラスを渡す
processLikable($new_commer);


//===========================
//    ポリモーフィズム的なの
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


//================================
//    メソッド名でポリモーフィズム
//================================

//-------------
//  実行クラス
//-------------
Class DataConvert
{
    static function execute__CONSTANT($arg1, $arg2){
        echo "execute__CONSTANT executed! {$arg1}, {$arg2}" . PHP_EOL;
    }

    static function execute__OWN_MASTER($arg1, $arg2){
        echo "execute__OWN_MASTER executed! {$arg1}, {$arg2}" . PHP_EOL;
    }

    static function execute__PREFECTURE_CODE_TO_NAME($arg1, $arg2){
        echo "execute__PREFECTURE_CODE_TO_NAME executed! {$arg1}, {$arg2}" . PHP_EOL;
    }
}

//-------------------------------------
//  引数によって実行するメソッドを変更
//-------------------------------------
function executeConversion($conversionType, $arg1, $arg2){

    $targetMethod = "execute__" . $conversionType;

    if (!method_exists(DataConvert::class, $targetMethod)) {
        echo "method not exist!";
        return;
    }

    DataConvert::$targetMethod($arg1, $arg2);
}

//---------
//   実行
//---------
executeConversion("CONSTANT", 1, 2);
executeConversion("OWN_MASTER", 3, 4);
executeConversion("PREFECTURE_CODE_TO_NAME", 5, 6);
executeConversion("not exist method", 0, 0);



//===========================
//         トレイト
//===========================
// コードを再利用するための仕組み。多重継承みたいな事をさせたい時に。
trait LogOutput {
  public function outputLog() {
      echo 'output logs';
  }
}

class MyClass01 {
  use LogOutput;

  public function someFunctionA() {
      echo 'Hello ';
  }
}

$my_class_01 = new MyClass01();
$my_class_01->outputLog();  // 継承関係が無いメソッドを使用可。RubyのMixinみたいなもん。
//=> output logs



//-----------------------------
//  トレイトの優先順位について１
//-----------------------------
// 基底クラスから継承したメンバーよりも、トレイトで追加したメンバーのほうが優先される。
trait SayWorld {
  public function sayHello() {
      echo 'Hey! ';
      parent::sayHello();
      echo 'World!';
  }
}

class Base {
  public function sayHello() {
      echo 'Hello ';
  }
}

class MyHelloWorld extends Base {
  use SayWorld;
}

$o = new MyHelloWorld();
$o->sayHello();  // trait SayWorld sayHello() が優先される。（基底クラスのメソッド class Base sayHello() よりも優先して実行される）
//=> Hey! Hello World!


//-----------------------------
//  トレイトの優先順位について２
//-----------------------------
// 自身が保持するメソッドとトレイトが保持するメソッドがバッティングした場合、自身が保持するメソッドが優先される。
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
$o->sayHello();  // 自身の持つメソッド（class TheWorldIsNotEnough sayHello() が、トレイトで保持している sayHello() よりも優先される。）
//=> Hello Universe!


//-------------------------------------------------------------------------------------------------------
//    同一クラス内での複数のトレイト間の名前の衝突を解決するには、 insteadof 演算子を使って そのうちのひとつを選ぶ。
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


//==========================
//      stdClass
//==========================
// デフォルトのクラスで宣言することなく、いきなり new して使うことができる特殊なオブジェクト。 
$member = new stdClass();
$member->name = 'Tom';
echo $member->name;  //=> Tom



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
use Exception;

function div27($a, $b) {
  try {
      if ($b === 0) {
          throw new Exception("cannot divide by 0!");
      }
      echo $a / $b;

  } catch (Exception $e) {
      echo $e->getMessage();

      // Exception::getLine
      // 例外が作られた行を取得する
      echo "The exception was created on line: " . $e->getLine();  //=> 例外が発生した行数を表示
  } finally {
      echo "First finally.\n";
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

$str = mb_convert_encoding($str, "SJIS");

// UTF-8の文字列をSJISに変換
$sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');

// EUC-JPからUTF-7に変換
$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");

// JIS, eucjp-win, sjis-winの順番で自動検出し、UCS-2LEに変換
$str = mb_convert_encoding($str, "UCS-2LE", "JIS, eucjp-win, sjis-win");

// "auto" は、"ASCII,JIS,UTF-8,EUC-JP,SJIS" に展開される
$str = mb_convert_encoding($str, "EUC-JP", "auto");



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


//=====================================
//  list を使用した、疑似的な複数戻り値
//=====================================
list($array_01, $array_02, $array_03) = getListData();
[$array_01, $array_02, $array_03] = getListData();  // こう書いてもOK

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
// ハッシュ関数
// ・SHA-1 : 何か入れると長さが160ビットの適当な値を返してくれるハッシュ関数
//
// ・SHA-2 : SHA-1の改良版。以下の６種類。
// 　　┗・SHA-224
// 　　┗・SHA-256（長さが256ビットの適当な値を返す。）
// 　　┗・SHA-384
// 　　┗・SHA-512
// 　　┗・SHA-512/224
// 　　┗・SHA-512/256
//
// Secure Hash Algorithm

$algo = 'ripemd160';  // 選択したアルゴリズムの名前 ("md5"、"sha256"、"haval160,4" など)
$target_data = 'The quick brown fox jumped over the lazy dog.';  // ハッシュするメッセージ。
$key = 'secret';  // HMAC 方式でのメッセージダイジェストを生成するために使用する 共有の秘密鍵。
// https://github.com/kakisoft/PracticePHP/blob/master/memo/hash.md

// HMAC (Hash-based Message Authentication Code)
// 鍵(メッセージ認証符号のことです)とデータとハッシュ関数を元に計算されたハッシュ値を持つ。
// 鍵は秘密である必要があり、可能な限り高速となるように設計されている。


// hash — ハッシュ値 (メッセージダイジェスト) を生成する
$hased_param = hash('ripemd160', 'The quick brown fox jumped over the lazy dog.');
echo $hased_param;  //=> ec457d0a974c48d5685a7efa03d137dc8bbde7e3

// パスワードに、ソルト（Salt）を追加してからハッシュを行う。（パスワードを特定させにくくする）
$hashed_param_add_salt_1 = hash( 'SHA256', 'pass'.'salt' );
$hashed_param_add_salt_2 = hash( 'SHA256', 'pass'.'salt2' );
echo $hashed_param_add_salt_1 . PHP_EOL;  //  Saltが異なれば、異なるハッシュを生成する
echo $hashed_param_add_salt_2 . PHP_EOL;  //  Saltが異なれば、異なるハッシュを生成する

// hash_hmac — HMAC 方式を使用してハッシュ値を生成する
$hmac_hased_param = hash_hmac($algo, $target_data, $key);  // 第４引数を true にすると、生のバイナリデータ。false（デフォルト）だと小文字の 16進数
echo $hmac_hased_param;  //=> b8e7ae12510bdfb1812e463a7f086122cf37e4f7



//----------( アルゴリズム一覧を表示 )----------
print_r( hash_algos() );
print_r( hash_hmac_algos() );


//===========================
//       固定長ハッシュ
//===========================
$param_1 = 'sample_hash_param';

$result_fnv132     = hash('fnv132',     $param_1);  //=> 76f6cc44
$result_fnv1a64    = hash('fnv1a64',    $param_1);  //=> 0ea3de70627549f2
$result_md5        = hash('md5',        $param_1);  //=> 545c037a3d91ccc197bfc874949a4b1d
$result_sha1       = hash('sha1',       $param_1);  //=> 08400fb5ce115e0aca6ce0f5e2941c75af3bd94b
$result_tiger192_5 = hash('haval192,5', $param_1);  //=> 68c65f09739007d95b7bb21806b8e7d8ec2bbd79fbd01e0c
$result_sha224     = hash('sha224',     $param_1);  //=> d0c98df2183b41eb3ff8ba70e5947a4d195d19091669af12d2bf4c35
$result_sha256     = hash('sha256',     $param_1);  //=> 93aec7b62a6a5a26ed8792c3c68909d05d7ba38d137cd51a97e3834f032de8ef
$result_sha384     = hash('sha384',     $param_1);  //=> 5abffd418c379bce4680af89e972653009b8c9bbbb9282981ea2d9e42c627cda46692a066901c1e8ad25580ab5b6afe5
$result_sha512     = hash('sha512',     $param_1);  //=> ca122e3f7b9474fdda9a93acd0ecf40c4da0cb8aced4f480f53fc3f66a4a7b903cbefaec3c3e862a1e4b1eff3af97f1a8e45ea34d145cf60cb5b21eb69dc708d

// 渡す文字が何であれ、固定のハッシュ値を生成する
var_dump(hash('md5',''));                                           //=> d41d8cd98f00b204e9800998ecf8427e
var_dump(hash('md5','1'));                                          //=> c4ca4238a0b923820dcc509a6f75849b
var_dump(hash('md5','a quick bworn fox jumps over the lazy dog'));  //=> 26bc2fdc51f314cbd386c77b5dcead46


// https://www.php.net/manual/ja/faq.passwords.php#faq.passwords.bestpractice
// よく使われるハッシュ関数である md5() や sha1() は、なぜパスワードのハッシュに適していないのですか?
// MD5 や SHA1 そして SHA256 といったハッシュアルゴリズムは、 高速かつ効率的なハッシュ処理のために設計されたものです。
// 最近のテクノロジーやハードウェア性能をもってすれば、 これらのアルゴリズムの出力をブルートフォースで(力ずくで)調べて元の入力を得るのはたやすいことです。
//
// 最近のコンピュータではハッシュアルゴリズムを高速に「逆算」できるので、
// セキュリティ技術者の多くはこれらの関数をパスワードのハッシュに使わないよう強く推奨しています。
//
// パスワードをハッシュするときに検討すべき重要な二点は、 その計算量とソルトです。 
// ハッシュアルゴリズムの計算コストが増えれば増えるほど、 ブルートフォースによる出力の解析に時間を要するようになります。
//
// それ以外には、crypt() 関数を使う方法もあります。 この関数は PHP 5.3 以降で使えるもので、いくつかのハッシュアルゴリズムに対応しています。 
// この関数を使うときには、指定したアルゴリズムが使えるかどうかを気にする必要はありません。 
// 各アルゴリズムが PHP の内部でネイティブに実装されているので、 ご利用の OS でサポートしていないアルゴリズムでも使うことができます。
//
// パスワードをハッシュするときのおすすめのアルゴリズムは Blowfish です。 
// パスワードハッシュ API でも、このアルゴリズムをデフォルトで使っています。 
// というのも、このアルゴリズムは MD5 や SHA1 と比較して計算コストが高いにもかかわらず、スケーラブルだからです。



//==========================
//  パスワードのハッシュと確認
//==========================
// パスワードのハッシュとか。
$password = '1234';
$hashed_password =  password_hash($password, PASSWORD_DEFAULT);
// 第2引数はハッシュアルゴリズムを示す整数値です。定数 'PASSWORD_DEFAULT' を指定すると、
// PHP5.5 では Blowfish が使われます。

var_dump($hashed_password );
var_dump(password_verify ( $password , $hashed_password ) );


//===========================
//      暗号化（ crypt ）
//===========================
$password = 'mypassword';

$hash_1 = crypt($password); // ソルトを設定しないと、Notice が出る
$hash_2 = crypt($password, 'salt');

var_dump($hash_1);  //=> $1$TZmWUmm6$mUqtesTDRsYpPOfoxO1HF0
var_dump($hash_2);  //=> sayVb7E97UXnw



//==========================
//      フォルダ作成
//==========================
$target_dir = 'tmp';
if ( !file_exists( $target_dir ) ) {

    mkdir( $target_dir, 0777 );
    chmod( $target_dir, 0777 );
}


//==========================
//   ディレクトリ一覧を取得
//==========================

//----------( opendir )----------
$dp = opendir('dir_name');
while (($item = readdir($dp)) !== false) {
  if ($item === '.' || $item === '..') {
    continue;
  }
  echo $item . PHP_EOL;
}

//----------( glob )----------
// glob — パターンにマッチするパス名を探す
// glob の戻り値は配列のため、foreach が使える
foreach (glob('data/*.txt') as $item) {
  // echo $item . PHP_EOL;
  echo basename($item) . PHP_EOL;
}


//==========================
//      オーナー変更
//==========================
// 使用するファイル名とユーザー名
$file_name= "foo.php";
$path = "/home/sites/php.net/public_html/sandbox/" . $file_name ;
$user_name = "root";

// ユーザーを設定します
chown($path, $user_name);

// 結果を確認します
$stat = stat($path);
print_r(posix_getpwuid($stat['uid']));



//==========================
//      ファイル作成
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


//=======================================
//    ファイルが読み書き可能かをチェック
//=======================================

//----------( 書き込み可能かをチェック )----------
if (is_writeable('data/taro.txt') === true) {
  echo 'taro is writable!' . PHP_EOL;
}

//----------( 読み込み可能かをチェック )----------
if (is_readable('data/taro.txt') === true) {
  echo 'taro is readable!' . PHP_EOL;
}


//================================
//  ファイルパスに関する情報を返す
//  （拡張子のみ、ファイル名のみ、等）
//================================
$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
echo $path_parts['dirname']  , "\n";  //=> /www/htdocs/inc
echo $path_parts['basename'] , "\n";  //=> lib.inc.php
echo $path_parts['extension'], "\n";  //=> php
echo $path_parts['filename'] , "\n";  //=> lib.inc  (PHP 5.2.0 以降)


//----------( パスの最後にある名前の部分を返す )----------

// basename() はロケールに依存します。 
// マルチバイト文字を含むパスで正しい結果を得るには、それと一致するロケールを setlocale() で設定しておかなければなりません。

echo  basename("/etc/sudoers.d", ".d") . PHP_EOL;  //=>  "sudoers"
echo  basename("/etc/sudoers.d")       . PHP_EOL;  //=>  "sudoers.d"
echo  basename("/etc/passwd")          . PHP_EOL;  //=>  "passwd"
echo  basename("/etc/")                . PHP_EOL;  //=>  "etc"
echo  basename(".")                    . PHP_EOL;  //=>  "."
echo  basename("/")                    . PHP_EOL;  //=>  ""


//----------( 親ディレクトリのパスを返す )----------
echo dirname("/etc/passwd")       . PHP_EOL;  //=>  "/etc"
echo dirname("/etc/")             . PHP_EOL;  //=>  "\"
echo dirname(".")                 . PHP_EOL;  //=>  "."
echo dirname("C:\\")              . PHP_EOL;  //=>  "C:\"
echo dirname("/usr/local/lib", 2) . PHP_EOL;  //=>  "/usr"


//----------( 正規化された絶対パス名を返す )----------
chdir('/var/www/');
echo realpath('./../../etc/passwd') . PHP_EOL;  //=> /etc/passwd
echo realpath('/tmp/')              . PHP_EOL;  //=> /tmp

// Win
echo realpath('/windows/system32'), PHP_EOL;   //=> C:\Windows\System32
echo realpath('C:\Program Files\\'), PHP_EOL;  //=> C:\Program Files



//=================================
//    ファイルの拡張子を取得（ext）
//=================================
$info = new SplFileInfo('foo.txt');
var_dump($info->getExtension());  //=> string(3) "txt"

$info = new SplFileInfo('photo.jpg');
var_dump($info->getExtension());  //=> string(3) "jpg"

$info = new SplFileInfo('something.tar.gz');
var_dump($info->getExtension());  //=> string(2) "gz"


$filename = 'foo.png';
$extension = (new SplFileInfo($filename))->getExtension();
var_dump($extension);  //=> string(3) "png"



//=================================
//    ファイルに関する情報を取得
//=================================
$file_name= "foo.php";
$path = "sandbox/" . $file_name ;
$stat = stat($path);

print_r($stat);
// Array
// (
//     [0] => 2
//     [1] => 0
//     [2] => 33206
//     [3] => 1
//     [4] => 0
//     [5] => 0
//     [6] => 2
//     [7] => 451
//     [8] => 1584324745
//     [9] => 1584324745
//     [10] => 1584324132
//     [11] => -1
//     [12] => -1
//     [dev] => 2
//     [ino] => 0
//     [mode] => 33206
//     [nlink] => 1
//     [uid] => 0
//     [gid] => 0
//     [rdev] => 2
//     [size] => 451
//     [atime] => 1584324745
//     [mtime] => 1584324745
//     [ctime] => 1584324132
//     [blksize] => -1
//     [blocks] => -1
// )


//=================================
//   通常ファイルかどうかを調べる
//=================================
// ファイルが存在し、かつそれが通常のファイルである場合に TRUE、 それ以外の場合に FALSE を返します。
var_dump( is_file('a_file.txt') ) . "\n";
var_dump( is_file('/usr/bin/')  ) . "\n";



//=====================================
//  アップロードされたファイルのチェック
//=====================================
// is_uploaded_file()
// HTTP POST でアップロードされたファイルかどうかを調べる

if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
  echo "ファイル ". $_FILES['userfile']['name'] ." のアップロードに成功しました。\n";
  echo "その中身を表示します\n";
  readfile($_FILES['userfile']['tmp_name']);
} else {
  echo "おそらく何らかの攻撃を受けました。";
  echo "ファイル名 '". $_FILES['userfile']['tmp_name'] . "'.";
}


//=====================================
//    アップロードされたファイルの移動
//=====================================
// move_uploaded_file()
// アップロードされたファイルを新しい位置に移動する

$uploads_dir = '/uploads';
foreach ($_FILES["pictures"]["error"] as $key => $error) {
   if ($error == UPLOAD_ERR_OK) {
       $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
       // basename() で、ひとまずファイルシステムトラバーサル攻撃は防げるでしょう。
       // ファイル名についてのその他のバリデーションも、適切に行いましょう。
       $name = basename($_FILES["pictures"]["name"][$key]);
       move_uploaded_file($tmp_name, "$uploads_dir/$name");
   }
}



//===================================
//  ディレクトリ/フォルダ かどうかを調べる
//===================================
var_dump( is_dir('a_file.txt') );
var_dump( is_dir('bogus_dir/abc') );


//=================================
//  シンボリックリンクかどうかを調べる
//=================================
$link = 'uploads';

if (is_link($link)) {
    echo(readlink($link));
} else {
    symlink('uploads.php', $link);
}


//=================================
//    シンボリックリンク先を返す
//=================================
// 出力例 /boot/vmlinux-2.4.20-xfs
echo readlink('/vmlinuz');


//=================================
//     シンボリックリンクを作成
//=================================
$target = 'uploads.php';
$link = 'uploads';
symlink($target, $link);

echo readlink($link);


//=================================
//    リンクに関する情報を取得
//=================================
echo linkinfo('/vmlinuz'); // 835


//=================================
//       ハードリンクを作成
//=================================
$target = 'source.ext'; // これは、既存のファイル名です
$link = 'newfile.ext'; // これは、リンク先としたいファイル名です

link($target, $link);


//=============================
//   ファイル読み込み  readfile（※コンソールへの出力）
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


//=================================
//  ファイルを読み込み（Stream）
//=================================

// fopen
// fopen() は、filename で指定されたリソースをストリームに結び付けます。
// この関数は、filename がディレクトリの場合でも成功することがあります。 
// filename がファイルなのかディレクトリなのかがはっきりしない場合は、 まず is_dir() を使ってから fopen() を呼ぶようにしましょう。


// https://www.php.net/manual/ja/function.fopen.php

// ファイルを開く（戻り値は、FilePointer と呼ばれる特殊な変数）
$handle = fopen("sample01.txt", "r");  // readonly

// ファイル内容を出力
while ($line = fgets($handle)) {
  echo $line;
}
// ファイルポインタをクローズ
fclose($handle);


//=================================
//  ファイルを読み込み、配列に格納
//=================================

// ファイルの内容を配列に取り込みます。
$lines = file(__FILE__);
// $lines = file('names.txt', FILE_IGNORE_NEW_LINES);  // 末尾の改行を無視

// 行単位で出力
foreach ($lines as $line_num => $line) {
    echo "Line #{$line_num} : " . htmlspecialchars($line);
}


//----------( URLの指定も可 )----------
$lines = file('http://www.example.com/');

foreach ($lines as $line_num => $line) {
    // echo "Line #<b>{$line_num} : " . htmlspecialchars($line);
    echo "Line # {$line_num} : " . $line;
}



//----------( オプション )----------
// オプションのパラメータは PHP 5 以降で使用できます
$trimmed = file('somefile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


//==========================
//     ファイル読み書き
//==========================

//----------( 上書きモード )----------
$fp = fopen('names.txt', 'w');
fwrite($fp, "taro\n");
fclose($fp);


//----------( 追記モード )----------
$fp = fopen('names.txt', 'a');
fwrite($fp, "jiro\n");
fwrite($fp, "saburo\n");
fclose($fp);


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


if (!is_dir('examples')) {
    mkdir('examples');
}

// ディレクトリ削除
rmdir('examples');


//================================
//  定型フォーマットのファイル読み込み
//================================
//----------( XMLファイル )----------
$config_data = simplexml_load_file('config.xml');
return $config_data->master;
return $config_data->prerelease;
return $config_data->development;

//----------( iniファイル)----------
// parse_ini_file


//====================================
//       リソースタイプを調べる
//====================================
// get_resource_type - 指定したリソースの型を取得します。

// mysql link を出力
$c = mysql_connect();
echo get_resource_type($c) . "\n";

// stream を出力
$fp = fopen("foo", "w");
echo get_resource_type($fp) . "\n";

// domxml document を出力
$doc = new_xmldoc("1.0");
echo get_resource_type($doc->doc) . "\n";


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


//===========================
//         言語設定
//===========================
// メール送信・ファイル出力の時とか

//----------( 現在の言語を設定 )----------

// mb_language — 現在の言語を設定あるいは取得する

$mbl = mb_language();
var_dump($mbl);  //=> neutral   ※UTF-8

mb_language("uni");  // ※UTF-8


//----------( 内部文字エンコーディングを設定 )----------

// mb_internal_encoding — 内部文字エンコーディングを設定あるいは取得する

$mbie = mb_internal_encoding();
var_dump($mbie);  //=> UTF-8

mb_internal_encoding("utf-8");


//----------( HTTP 出力文字エンコーディングを設定 )----------

// mb_http_output — HTTP 出力文字エンコーディングを設定あるいは取得する
$mbho = mb_http_output();
var_dump($mbho);  //=> UTF-8


//----------(  )----------

// mb_internal_encoding() - 内部文字エンコーディングを設定あるいは取得する
// mb_http_input() - HTTP 入力文字エンコーディングを検出する
// mb_detect_order() - 文字エンコーディング検出順序を設定あるいは取得する


//=============================
//       クラス名を取得
//=============================
class SampleClass01
{

}
$target_class = new SampleClass01();

$target_class_name = get_class($target_class);
echo "{$target_class_name}"; //=> SampleClass01


//====================================
//        メソッドの存在チェック
//====================================
if (method_exists($this->_account, $name) || preg_match('/^find/', $name)) {
  return call_user_func_array(array($this->_account, $name), $args);
}


//====================================
//           型チェック
//====================================
$value = array(1,2,3);          // array
// $value = [1 => 2,  3=> 4];   // array
// $value = 1;                  // integer
// $value = 1.4;                // double
// $value = "1";                // string

if( gettype($value) === "array" ){
    echo "array!";
}
else{
    echo "not array! : " . gettype($value);
}


//===========================
//     コールバック関数
//===========================
// call_user_func_array - パラメータの配列を指定してコールバック関数をコールする

function foobar($arg, $arg2) {
  echo __FUNCTION__, " got {$arg} and {$arg2}" . PHP_EOL;
  return "You enterd :" . substr($arg, 0, 1) . substr($arg2, 0, 1);
}
class foo {
  function bar($arg, $arg2) {
      echo __METHOD__, " got $arg and $arg2\n";
      return "You enterd :" . strlen($arg) . strlen($arg2);
  }
}


// foobar() 関数に引数を 2 つ渡してコールします
$result1 = call_user_func_array("foobar", array("one", "two"));

// $foo->bar() メソッドに引数を 2 つ渡してコールします
$foo = new foo;
$result2 = call_user_func_array(array($foo, "bar"), array("three", "four"));


print_r($result1);
print_r($result2);


//=============================
//  json エンコード/デコード
//=============================
$original_json_data = '{"id":1, "product_name":"K001-X299022A"}';
$decoded_data = json_decode($original_json_data, true);  // true の場合、返されるオブジェクトは連想配列形式になります。
$decoded_data['check_user']     = "5656";
$decoded_data['check_datetime'] = date("Y/m/d H:i");
$encoded_data = json_encode($decoded_data);


var_dump($encoded_data);  //=> string(97) "{"id":1,"product_name":"K001-X299022A","check_user":"5656","check_datetime":"2020\/02\/04 12:28"}"


//=============================
//  配列から json に エンコード
//=============================
$array_data = [
  'name'    => 'Tom',
  'Job'     => 'Engineer',
  'country' => 'USA',
  'age'     => 28,
];

$json_encoded_data = json_encode($array_data);

echo $json_encoded_data;  //=> {"name":"Tom","Job":"Engineer","country":"USA","age":28}


//-------------------
//    エスケープ
//-------------------
$array_data = [
  'name'    => 'かき',
  'Job'     => 'エンジニア',
];

// 日本語はユニコードでエスケープ（\uXXXX）される。
$json_encoded_data_01 = json_encode($array_data);  //=> {"name":"\u304b\u304d","Job":"\u30a8\u30f3\u30b8\u30cb\u30a2"}

// Unicodeエスケープしないようにする
$json_encoded_data_02 = json_encode($array_data, JSON_UNESCAPED_UNICODE);  //=> {"name":"かき","Job":"エンジニア"}



//=============================
//          base64
//=============================
$str = 'This is an encoded string';
$encoded_str = base64_encode($str);
$decoded_str = base64_decode($encoded_str);
echo $encoded_str;    //=> VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==
echo $decoded_str;    //=> This is an encoded string



//==========================
//      URLエンコード
//==========================
//URLとして使用できない文字や記号を、使用できる文字の特殊な組み合わせで表すように変換する。

//----------( urlencode )----------
$a1 = urlencode('abc_defああああ');  //=>  abc_def%E3%81%82%E3%81%82%E3%81%82%E3%81%82
$result_1 = '<a href="nextpage?foo=' . urlencode($a1) . '">';  //=> <a href="nextpage?foo=abc_def%25E3%2581%2582%25E3%2581%2582%25E3%2581%2582%25E3%2581%2582">


//----------( rawurlencode )----------
// RFC 3986 に基づき URL エンコードを行う。urlencode関数よりrawurlencode関数を使ったほうが安全らしい。
$a2 = rawurlencode('abc_defああああ');  //=> abc_def%E3%81%82%E3%81%82%E3%81%82%E3%81%82


//==========================
//      URLデコード
//==========================
$userinput = "北斗神拳";
$encoded_user_input = rawurlencode($userinput);        //=>  %E5%8C%97%E6%96%97%E7%A5%9E%E6%8B%B3
$decoded_user_input = urldecode($encoded_user_input);  //=>  北斗神拳


$userinput = "南斗聖拳";
$encoded_user_input = rawurlencode($userinput);            //=>  %E5%8D%97%E6%96%97%E8%81%96%E6%8B%B3
$decoded_user_input = rawurldecode ($encoded_user_input);  //=>  南斗聖拳



//====================================
//  特殊文字を HTML エンティティに変換
//====================================
$new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
echo $new;  //=> &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;

echo htmlspecialchars("hi! " . $_GET['name'], ENT_QUOTES, "utf-8");
// ENT_QUOTES	シングルクオートとダブルクオートを共に変換します。



// 配列内のデータを変換したり
$array_01 = array("1","2","3","&","'","<",">",'"');
$escaped_array_01 = array_map('htmlspecialchars', $array_01);
print_r($escaped_array_01);
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => &amp;
//     [4] => '
//     [5] => &lt;
//     [6] => &gt;
//     [7] => &quot;
// )


//----------( htmlentities )----------
// この関数はhtmlspecialchars()と同じですが、 HTML エンティティと等価な意味を有する文字をHTMLエンティティに変換します。
$str = "A 'quote' is <b>bold</b>";

echo htmlentities($str);              //=>  A 'quote' is &lt;b&gt;bold&lt;/b&gt;
echo htmlentities($str, ENT_QUOTES);  //=>  A &#039;quote&#039; is &lt;b&gt;bold&lt;/b&gt;


//===================================================
//  HTML エンティティを対応する文字に変換（↑のデコード）
//===================================================
$orig = "I'll \"walk\" the <b>dog</b> now";

$a = htmlspecialchars($orig);
$b = html_entity_decode($a);

echo $a . PHP_EOL;  //=> I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now
echo $b . PHP_EOL;  //=> I'll "walk" the <b>dog</b> now



//====================================
//    HTML および PHP タグを取り除く
//====================================
$text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
$striped_text = strip_tags($text);  //=> Test paragraph. Other text
echo $striped_text;


$array_02 = array('<p>a</p>','bb<br>cc','<?php  aaa<div>bbb</div>ccc');
$escaped_array_02 = array_map('strip_tags', $array_02);
// print_r($escaped_array_02);
// (
//     [0] => a
//     [1] => bbcc
//     [2] =>
// )


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
//      METAタグ取得
//==========================
$tags = get_meta_tags('http://www.example.com/');

// すべてのキーが小文字であり、. (ピリオド) が _ に
// 置換されていることに注目してください。
echo $tags['author'];       // name
echo $tags['keywords'];     // php documentation
echo $tags['description'];  // a php manual
echo $tags['geo_position']; // 49.33;-86.59


//===========================
//  指定した時刻まで実行を遅延
//===========================
// false を返し、警告を発生します
var_dump(time_sleep_until(time()-1));

// 高速なコンピュータ上でのみ動作します。実行を 0.2 秒遅延します。
var_dump(time_sleep_until(microtime(true)+0.2));


//===========================
//   実行時間の最大値を制限
//===========================
// スクリプトが実行可能な秒数を設定します。 この制限にかかるとスクリプトは致命的エラーを返します。
// デフォルトの制限値は 30 秒です。 なお、php.iniでmax_execution_timeの 値が定義されている場合にはそれを用います。

//----------( 5秒超えたら Fatal error を返す )----------
set_time_limit(5);

$i = 0;
while ($i<=10)
{
        echo "i=$i ";
        sleep(10);
        $i++;
}

//=> Fatal error:  Maximum execution time of 5 seconds exceeded in C:\kaki\__tmp__\PHP\58_time_sleep.php on line 34


//=================================
//       ジェネレータ（yield）
//=================================
function xrange($start, $limit, $step = 1) {
  for ($i = $start; $i <= $limit; $i += $step) {
      yield $i;
  }
}

echo 'Single digit odd numbers: ';

/*
* 配列を作ったり配列を返したりしていないことに注目しましょう。
* そのぶんメモリの節約になります。
*/
foreach (xrange(1, 9, 2) as $number) {
  echo "$number ";
}


//-------------------
//      簡素化
//-------------------
function yieldNumber() {
  yield 1;
  yield 2;
  yield 3;
}

foreach(yieldNumber() as $number) {
  echo $number;
}


//-------------------
//   その他の使い方
//-------------------
// テーブルレスにシーケンスを実現したりとか
function getSequence() {
  for ($i = 1; $i <= PHP_INT_MAX; $i += 1) {
      yield $i;
  }
}

$gen = getSequence();

echo $gen->current() . PHP_EOL;  //=> 1

echo $gen->next();
echo $gen->current() . PHP_EOL;  //=> 2

echo $gen->next();
echo $gen->current() . PHP_EOL;  //=> 3

// methods:
//   rewind
//   valid
//   current
//   key
//   next
//   send
//   throw
//   getReturn


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
//      ヘッダ取得  HTTP_HEADER
//====================================


//-------------------------
//     getallheaders
//-------------------------
header( 'Foo:200' );
header( 'Bar:300' );
foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
}

// オリジナルのヘッダーは取れないみたい。
// 使えんな・・。

// ちなみに↓のエイリアス

//-------------------------
//  apache_request_headers
//-------------------------
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


//=================================
//    <input type="file"
//=================================
$file = $_FILES['update_file'];
// [update_file] => Array
// (
//     [name] => mudai.jpg
//     [type] => image/jpeg
//     [tmp_name] => C:\Windows\Temp\php909C.tmp
//     [error] => 0
//     [size] => 6847
// )



//=================================
//       ロケール情報を設定
//=================================
// Unix 系でロケールの情報を取得するには、locale コマンドを実行する

// setlocale
// (PHP 4, PHP 5, PHP 7)

// setlocale — ロケール情報を設定する

//----------( ロケール情報を取得 )----------
// https://blog.sarabande.jp/post/13110109893
// setlocale 関数の第一引数に知りたいカテゴリ、第2引数に 0 を指定する。
setlocale(LC_ALL, 'ja_JP.UTF-8');
echo setlocale(LC_ALL, 0) . PHP_EOL;


//----------( NULL が何を意味するのかわかりづらいので、getlocale 関数を定義するのであれば )----------
function getlocale($category) {
    return setlocale($category, 0);
}

setlocale(LC_ALL, 'ja_JP.UTF-8');
echo getlocale(LC_ALL) . PHP_EOL;



//====================================
//             プロセス
//====================================

//----------( PHP のプロセスの ID を取得 )----------
$process_id = getmypid();
var_dump( getmypid() );    //=> int(16300)


//----------( PHP スクリプトの所有者の GID を取得 )----------
$my_gid = getmygid();


//----------( PHP スクリプト所有者のユーザー ID を取得 )----------
$my_uid = getmyuid();


//----------( 現在の PHP スクリプトの所有者の名前を取得 )----------
$current_user = get_current_user();
//=> string(4) "IUSR"


//----------( 現在のスクリプトの inode を取得する )----------
$my_inode = getmyinode();


//----------( 最終更新時刻を取得 )----------
$lastmod = getlastmod();  //=> int(1573627087)


?>

</body>
</html>