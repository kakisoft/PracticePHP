<?php

function repeatNumber1($n){
	return str_repeat($n, $n);
}



function repeatNumber2($n){
	return $n * sprintf("%'1{$n}d", 1);
}



function repeatNumber3($n){
	$str = sprintf("%'0{$n}d",0);
	return str_replace(0, $n, $str);
}



