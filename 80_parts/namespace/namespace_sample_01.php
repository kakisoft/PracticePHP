<?php
//=====================================================
//    異なる名前空間の、同一クラス・同一メソッドを使用
//=====================================================
require_once 'lib1.php';
require_once 'lib2.php';

$foo_1 = new Lib1\SampleClass();
echo $foo_1->getSomeName() . "\n";  //=> [Lib1]-[Lib1\SampleClass]-[Lib1\SampleClass::getSomeName]

$foo_2 = new Lib2\SampleClass();
echo $foo_2->getSomeName() . "\n";  //=> [Lib2]-[Lib2\SampleClass]-[Lib2\SampleClass::getSomeName]


//=====================================================
//                use でエイリアスを指定
//=====================================================
require_once 'lib3.php';

use Foo\Bar\Baz\Lib3 as Lib3;  // Foo\Bar\Baz\Lib1を、Lib1で参照できるようにエイリアスを作成。
$foo_3_1 = new Lib3\FooSampleClass01();
$foo_3_2 = new Lib3\FooSampleClass02();
$foo_3_3 = new Lib3\FooSampleClass03();
echo $foo_3_1->getSomeName() . "\n";  //=>  [Foo\Bar\Baz\Lib3]-[Foo\Bar\Baz\Lib3\FooSampleClass01]-[Foo\Bar\Baz\Lib3\FooSampleClass01::getSomeName]
echo $foo_3_2->getSomeName() . "\n";  //=>  [Foo\Bar\Baz\Lib3]-[Foo\Bar\Baz\Lib3\FooSampleClass02]-[Foo\Bar\Baz\Lib3\FooSampleClass02::getSomeName]
echo $foo_3_3->getSomeName() . "\n";  //=>  [Foo\Bar\Baz\Lib3]-[Foo\Bar\Baz\Lib3\FooSampleClass03]-[Foo\Bar\Baz\Lib3\FooSampleClass03::getSomeName]





