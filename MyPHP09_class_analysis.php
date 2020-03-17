<?php

//=============================
//        クラスの解析
//=============================
function generate()
{
	yield 1;
}

$target = generate();

//-----( class name )-----
$target_class = get_class($target);
echo "class name:"        . PHP_EOL;
echo "  {$target_class}"  . PHP_EOL . PHP_EOL;


//-----( parent name )-----
$parent_class = get_parent_class($target);
echo "parent class:"      . PHP_EOL;
echo "  {$parent_class}"  . PHP_EOL . PHP_EOL;


//-----( interfaces )-----
echo "implemented interfaces:" . PHP_EOL;
$interfaces = get_declared_interfaces();
foreach ($interfaces as $interface) {
	if ($target instanceof $interface) {
		echo "  {$interface}"  . PHP_EOL;
	}
}
echo PHP_EOL;


//-----( methods )-----
$methods = get_class_methods($target);
echo "methods:" . PHP_EOL;
foreach ($methods as $method) {
	echo "  {$method}"  . PHP_EOL;
}


