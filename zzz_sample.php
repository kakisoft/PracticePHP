<?php

// foo(1, 2, 3);

function foo()
{
    $numargs = func_num_args();
    echo "引数の数: $numargs \n";  //=> 引数の数: 3
    if ($numargs >= 2) {
        echo "二番目の引数は: " . func_get_arg(1) . " です。\n";  //=> 二番目の引数は: 2 です。
    }
    $arg_list = func_get_args();
    for ($i = 0; $i < $numargs; $i++) {
        echo "引数 $i は: " . $arg_list[$i] . " です。\n";
    }

    // 引数 0 は: 1 です。
    // 引数 1 は: 2 です。
    // 引数 2 は: 3 です。

}

foo(1, 2, 3);

// //=>
// 引数の数: 3
// 二番目の引数は: 2 です。
// 引数 0 は: 1 です。
// 引数 1 は: 2 です。
// 引数 2 は: 3 です。


// use Exception;

// function div27($a, $b) {
//   try {
//       if ($b === 0) {
//           throw new Exception("cannot divide by 0!");
//       }
//       echo $a / $b;
//       echo PHP_EOL;

//   } catch (Exception $e) {
//       // エラーメッセージを取得する
//       echo $e->getMessage();
//       echo PHP_EOL . PHP_EOL;

//       // Exception::getCode
//       // 例外コードを取得する
//       echo "The exception code is : " . $e->getCode ();  //=> 例外コードを取得
//       echo PHP_EOL . PHP_EOL;

//       // Exception::getFile
//       // 例外が作られたファイルを取得する
//       echo "The exception was created in : " . $e->getFile();  //=> 例外が発生したファイルを表示
//       echo PHP_EOL . PHP_EOL;

//       // Exception::getLine
//       // 例外が作られた行を取得する
//       echo "The exception was created on line: " . $e->getLine();  //=> 例外が発生した行数を表示
//       echo PHP_EOL . PHP_EOL;

//       // Exception::getTrace
//       // スタックトレースを取得する
//       print_r($e->getTrace());  //=> 配列形式
//       echo PHP_EOL . PHP_EOL;

//       // Exception::getTraceAsString
//       // スタックトレースを文字列で取得する
//       echo "The exception's stack trace: " . $e->getTraceAsString ();  //=> スタックトレース
//       echo PHP_EOL . PHP_EOL;


//   } finally {
//       echo "First finally." . PHP_EOL;
//   }
// }

// div27(7, 2);
// div27(5, 0);





