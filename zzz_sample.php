<?php



// print vsprintf("%04d-%02d-%02d", explode('-', '1988-8-1'));
// //=> 1988-08-01


$str = "Is your name O'Reilly?";

// 出力: Is your name O\'Reilly?
echo addslashes($str);

