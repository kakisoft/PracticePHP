<?php


//=============================
//  json エンコード/デコード
//=============================
$original_json_data = '{"id":1, "product_name":"K001-X299022A"}';
$decoded_data = json_decode($original_json_data);  // true の場合、返されるオブジェクトは連想配列形式になります。
$decoded_data['check_user']     = "5656";
$decoded_data['check_datetime'] = date("Y/m/d H:i");
$encoded_data = json_encode($decoded_data);

print_r($decoded_data);


// //----------(  実行を遅延させる。単位は秒。 )----------
// // 現在の時刻
// echo date('h:i:s')       . PHP_EOL;  //=> 10:36:57
// echo date('Y/m/d H:i:s') . PHP_EOL;  //=> 2022/03/09 10:36:57
// echo date('YmdHis')      . PHP_EOL;  //=> 20220309104132


// /*

// |  フォーマット  |  内容                       |  出力結果(例)  |
// |:-------------|:---------------------------|:----------|
// |  Y           |  西暦(4桁)                  |  2017     |
// |  y           |  西暦(2桁)                  |  17       |
// |  l           |  うるう年: 1、平年: 0        |  0        |
// |  m           |  月(0埋め)                  |  08       |
// |  n           |  月(0埋め無し)               |  8        |
// |  M           |  月 英語表記                |  August   |
// |  d           |  日付(0埋め)                |  08       |
// |  j           |  日付(0埋め無し)             |  8        |
// |  H           |  時刻 24時間表記 (0埋め)     |  09       |
// |  G           |  時刻 24時間表記 (0埋め無し)  |  9        |
// |  h           |  時刻 12時間表記 (0埋め)      |  09       |
// |  g           |  時刻 12時間表記 (0埋め無し)  |  9        |
// |  i           |  分                        |  02       |
// |  s           |  秒                        |  02       |

// */

// // // $value = "202211"; //=> false
// // // $value = "2022111"; //=> false （2022年1月111日）
// // // $value = "2021/2/2"; //=> 2021年2月2日
// // // $value = "2021/11"; //=> false
// // // $value = "2021/11/1"; //=> 2021年11月1日

// // $date = date_parse($value);

// // echo $date['year'] . '年' . $date['month'] . '月' . $date['day'] . '日' . PHP_EOL;

// // $isDate = checkdate($date['month'], $date['day'], $date['year']);
// // var_dump($isDate);




// // // function f2($array)
// // // {
// // //     return array_reduce($array, function ($carry, $item) {
// // //         if (ctype_lower($item[0])) {
// // //             $carry[] = '!' . $item;
// // //         }
// // //         return $carry;
// // //     }, []);
// // // }
// // // var_dump(f2(['Aa', 'bb', 'cC', 'DD']));
// // // /*
// // // array(2) {
// // //   [0] =>
// // //   string(3) "!bb"
// // //   [1] =>
// // //   string(3) "!cC"
// // // }
// // // */

// // // // // ファイルの内容を配列に取り込みます。
// // // // $lines = file(__FILE__);
// // // // // $lines = file('names.txt', FILE_IGNORE_NEW_LINES);  // 末尾の改行を無視

// // // // // 行単位で出力
// // // // foreach ($lines as $line_num => $line) {
// // // //     echo "Line #{$line_num} : " . htmlspecialchars($line);
// // // // }


// // // // // // 「全角カタカナ」を「半角カタカナ」に変換。濁点は別の文字扱い。
// // // // // $str1 = "ｺﾝﾅｶﾝｼﾞ１Ａ";
// // // // // $str2 = "こんなかんじ１Ａ";
// // // // // $converted_str1 = mb_convert_kana($str1, "KV");
// // // // // $converted_str2 = mb_convert_kana($str2, "KV");
// // // // // echo $converted_str1 . PHP_EOL;  //=> "コンナカンジ１Ａ"
// // // // // echo $converted_str2 . PHP_EOL;  //=> "こんなかんじ１Ａ"



// // // // // // $targetData = 'ﾀﾞﾁﾞﾂﾞﾃﾞﾄﾞ';
// // // // // // $convertedData = mb_convert_kana($targetData, 'K');

// // // // // // echo $convertedData . PHP_EOL;

// // // // // // $convertedData = mb_convert_kana($targetData, 'KV');

// // // // // // echo $convertedData . PHP_EOL;


// // // // // // $details = [];
// // // // // // $details[0]['id'] = 19;
// // // // // // $details[0]['row_no'] = 1;
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'] = [];

// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][0]['id'] = 35;
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][0]['key'] = '区分１';
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][0]['value'] = 'x1';
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][1]['id'] = 36;
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][1]['key'] = '区分２';
// // // // // // $details[0]['tmp_extends_shipping_instruction_details'][1]['value'] = 'x2';

// // // // // // // print_r($details);


// // // // // // $maxDetailRowNo = getMaxDetailRowNo($shippingInstruction['tmp_shipping_instruction_details']);
// // // // // // echo $maxDetailRowNo . PHP_EOL;

// // // // // // function getMaxDetailRowNo(array $details): int
// // // // // // {
// // // // // //     // 'tmp_extends_shipping_instruction_details'

// // // // // //     if( count($details) <= 0 ){
// // // // // //         return 0;
// // // // // //     }

// // // // // //     return count($details[0]['tmp_extends_shipping_instruction_details']);
// // // // // // }



// // // // // // // $details = [];
// // // // // // // $details[0]['id'] = 19;  $details[0]['row_no'] = 1;
// // // // // // // $details[1]['id'] = 20;  $details[1]['row_no'] = 2;
// // // // // // // $details[2]['id'] = 21;  $details[2]['row_no'] = 3;


// // // // // // // $maxRowNo = getMaxRowNo($details);
// // // // // // // echo $maxRowNo . PHP_EOL;

// // // // // // // function getMaxRowNo(array $details): int
// // // // // // // {
// // // // // // //     return array_reduce(
// // // // // // //         $details,
// // // // // // //         function ($carry, $row) {  // コールバックの第１引数の最初の値は、以下で定義した「初期値」。それ以降の第一引数の値は、メソッドの戻り値。　コールパックの第二引数は配列の要素。
// // // // // // //             if ($row['row_no'] > $carry) {
// // // // // // //                 $carry = $row['row_no'];
// // // // // // //             }
// // // // // // //             return $carry;
// // // // // // //         },
// // // // // // //         0);  // 初期値
// // // // // // // }



// // // // // // // // $fileName = str_replace('.', '', strval(microtime(true)));

// // // // // // // // var_dump($fileName);

// // // // // // // // $contents = "John Smith\n";

// // // // // // // // file_put_contents($fileName, $contents);
// // // // // // // // unlink($fileName);



// // // // // // // // // $file = 'people.txt';
// // // // // // // // // // // ファイルをオープンして既存のコンテンツを取得します
// // // // // // // // // // $current = file_get_contents($file);
// // // // // // // // // // // 新しい人物をファイルに追加します
// // // // // // // // // $current = "John Smith\n";
// // // // // // // // // // 結果をファイルに書き出します
// // // // // // // // // file_put_contents($file, $current);

// // // // // // // // // // $value = "2020-10";

// // // // // // // // // // $date = date_parse($value);

// // // // // // // // // // // var_dump($date);
// // // // // // // // // // print_r($date);

// // // // // // // // // // // echo "=============================================" . PHP_EOL;

// // // // // // // // // // // $targetText = "ABCDEABCDE";
// // // // // // // // // // // $s3 = strtr($targetText, array('A' => 'B', 'B' => 'C'));           //strtr
// // // // // // // // // // // $s4 = str_replace(array('A', 'B'), array('B', 'C'), $targetText);  //str_replace

// // // // // // // // // // // echo $s3 . PHP_EOL;  //=> "BBEDEBBEDE"
// // // // // // // // // // // echo $s4 . PHP_EOL;  //=> "CDCDECDCDE"



// // // // // // // // // // // echo "=============================================" . PHP_EOL;

// // // // // // // // // // // $targetText = "110100";
// // // // // // // // // // // $s3 = strtr($targetText, array('1' => '0', '0' => '1'));           //strtr
// // // // // // // // // // // $s4 = str_replace(array('1', '0'), array('0', '1'), $targetText);  //str_replace

// // // // // // // // // // // echo $s3 . PHP_EOL;  //=> "001011"
// // // // // // // // // // // echo $s4 . PHP_EOL;  //=> "111111"





// // // // // // // // // // // // $targetText = "ABCABC";
// // // // // // // // // // // // $replaceText = str_replace("A", "×", $targetText);
// // // // // // // // // // // // echo $replaceText . PHP_EOL;  //=> "AbcdE"

// // // // // // // // // // // $targetText = "ABCABC";
// // // // // // // // // // // $replaceText = strtr($targetText, "A", "x");
// // // // // // // // // // // echo $replaceText . PHP_EOL;  //=> "xBCxBC"


// // // // // // // // // // // echo "=========================================" . PHP_EOL;  //=> "AbcdE"

// // // // // // // // // // // // strtr — 文字の変換あるいは部分文字列の置換を行う



// // // // // // // // // // // $s1 = strtr('abcde', array('a' => 'A', 'e' => 'E'));           //strtr
// // // // // // // // // // // $s2 = str_replace(array('a', 'e'), array('A', 'E'), 'abcde');  //str_replace

// // // // // // // // // // // echo $s1 . PHP_EOL;  //=> "AbcdE"
// // // // // // // // // // // echo $s2 . PHP_EOL;  //=> "AbcdE"


// // // // // // // // // // // $s3 = strtr('110100', array('1' => '0', '0' => '1'));           //strtr
// // // // // // // // // // // $s4 = str_replace(array('1', '0'), array('0', '1'), '110100');  //str_replace

// // // // // // // // // // // echo $s3 . PHP_EOL;  //=> "001011"
// // // // // // // // // // // echo $s4 . PHP_EOL;  //=> "111111"



// // // // // // // // // // // // class SampleClass01
// // // // // // // // // // // // {

// // // // // // // // // // // // }
// // // // // // // // // // // // $target_class = new SampleClass01();

// // // // // // // // // // // // $target_class_name = get_class($target_class);
// // // // // // // // // // // // echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01

// // // // // // // // // // // // //-----( クラスから )-----
// // // // // // // // // // // // $target_class_name = strval(SampleClass01::class);
// // // // // // // // // // // // echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01


