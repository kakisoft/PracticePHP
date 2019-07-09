<?php
//https://crieit.net/boards/programming-challenge/654e4f50c6e46c1c13f6e6df3cd86680

function repeatNumber($n){

    if($n <= 0){
        return;
    }

    $box = [];
    while(count($box) < $n){
        $r = rand ( 0 , $n );
        if($r == $n){
            array_push($box, $r);
        }
    }
    
    return join("", $box);
}

echo repeatNumber(5);



//array_fill
