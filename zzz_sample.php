<?php

$details = [];
$details[0]['id'] = 19;  $details[0]['row_no'] = 1;
$details[1]['id'] = 20;  $details[1]['row_no'] = 2;
$details[2]['id'] = 21;  $details[2]['row_no'] = 3;


$maxRowNo = getMaxRowNo($details);
echo $maxRowNo . PHP_EOL;

function getMaxRowNo(array $details): int
{
    return array_reduce(
        $details,
        function ($carry, $row) {  // コールバックの第１引数の最初の値は、以下で定義した「初期値」。それ以降の第一引数の値は、メソッドの戻り値。　コールパックの第二引数は配列の要素。
            if ($row['row_no'] > $carry) {
                $carry = $row['row_no'];
            }
            return $carry;
        },
        0);  // 初期値
}



// $fileName = str_replace('.', '', strval(microtime(true)));

// var_dump($fileName);

// $contents = "John Smith\n";

// file_put_contents($fileName, $contents);
// unlink($fileName);



// // $file = 'people.txt';
// // // // ファイルをオープンして既存のコンテンツを取得します
// // // $current = file_get_contents($file);
// // // // 新しい人物をファイルに追加します
// // $current = "John Smith\n";
// // // 結果をファイルに書き出します
// // file_put_contents($file, $current);

// // // $value = "2020-10";

// // // $date = date_parse($value);

// // // // var_dump($date);
// // // print_r($date);

// // // // echo "=============================================" . PHP_EOL;

// // // // $targetText = "ABCDEABCDE";
// // // // $s3 = strtr($targetText, array('A' => 'B', 'B' => 'C'));           //strtr
// // // // $s4 = str_replace(array('A', 'B'), array('B', 'C'), $targetText);  //str_replace

// // // // echo $s3 . PHP_EOL;  //=> "BBEDEBBEDE"
// // // // echo $s4 . PHP_EOL;  //=> "CDCDECDCDE"



// // // // echo "=============================================" . PHP_EOL;

// // // // $targetText = "110100";
// // // // $s3 = strtr($targetText, array('1' => '0', '0' => '1'));           //strtr
// // // // $s4 = str_replace(array('1', '0'), array('0', '1'), $targetText);  //str_replace

// // // // echo $s3 . PHP_EOL;  //=> "001011"
// // // // echo $s4 . PHP_EOL;  //=> "111111"





// // // // // $targetText = "ABCABC";
// // // // // $replaceText = str_replace("A", "×", $targetText);
// // // // // echo $replaceText . PHP_EOL;  //=> "AbcdE"

// // // // $targetText = "ABCABC";
// // // // $replaceText = strtr($targetText, "A", "x");
// // // // echo $replaceText . PHP_EOL;  //=> "xBCxBC"


// // // // echo "=========================================" . PHP_EOL;  //=> "AbcdE"

// // // // // strtr — 文字の変換あるいは部分文字列の置換を行う



// // // // $s1 = strtr('abcde', array('a' => 'A', 'e' => 'E'));           //strtr
// // // // $s2 = str_replace(array('a', 'e'), array('A', 'E'), 'abcde');  //str_replace

// // // // echo $s1 . PHP_EOL;  //=> "AbcdE"
// // // // echo $s2 . PHP_EOL;  //=> "AbcdE"


// // // // $s3 = strtr('110100', array('1' => '0', '0' => '1'));           //strtr
// // // // $s4 = str_replace(array('1', '0'), array('0', '1'), '110100');  //str_replace

// // // // echo $s3 . PHP_EOL;  //=> "001011"
// // // // echo $s4 . PHP_EOL;  //=> "111111"



// // // // // class SampleClass01
// // // // // {

// // // // // }
// // // // // $target_class = new SampleClass01();

// // // // // $target_class_name = get_class($target_class);
// // // // // echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01

// // // // // //-----( クラスから )-----
// // // // // $target_class_name = strval(SampleClass01::class);
// // // // // echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01


