<?php

class SampleClass01
{

}
$target_class = new SampleClass01();

$target_class_name = get_class($target_class);
echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01

//-----( クラスから )-----
$target_class_name = strval(SampleClass01::class);
echo "{$target_class_name}" . PHP_EOL; //=> SampleClass01


