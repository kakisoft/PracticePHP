<?php


// list($array_01, $array_02, $array_03) = getListData();
[$array_01, $array_02, $array_03] = getListData();

function getListData(){
    $array_01 = [1, 3, 5];
    $array_02 = ['A', 'C', 'D'];
    $array_03 = ['n', 'm', 'k'];

    return array($array_01, $array_02, $array_03);
}


print_r($array_01);
print_r($array_02);
print_r($array_03);
