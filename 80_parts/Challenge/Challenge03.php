<?php
function solve($num) {
    if(!is_int($num)){ return; }
    if( $num <= 0 ){ return; }

    $str = "";
    for($i=0; $i<$num; $i++ ){
        $str .= "x";
    }

    $centerPosi = ceil(strlen($str) / 2);

    $firstHalf  = substr($str, 0, $centerPosi);
    $secondHalf = substr($str, $centerPosi);

    if($firstHalf != $secondHalf){
        return 0;
    }else{
        return 1;
    }
}


echo solve(3);
echo solve(10);


// 1. 引数の数の長さの文字列を生成
// 2. 真ん中から２つに分ける
// 3. 分けた文字の長さが異なっていれば奇数。同一なら偶数

// 結局、２で割っているところが敗北感バリバリなので、別の方法を考える。

