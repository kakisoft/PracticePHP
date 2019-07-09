<?php

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

