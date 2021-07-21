<?php

class Foo {
    public static function aStaticMethod() {
        // ...
    }
}

Foo::aStaticMethod();
$classname = 'Foo';
$classname::aStaticMethod();


//  php -l a.php


// class ParentClass {
//     // 「self」は、定義されたクラスを指す。
//     // この場合、どこからコールされても、クラス「ParentClass」を指す
//     public static function getNewSelfName() {
//         return get_class(new self());
//     }

//     // 「static」は、呼び出された時のクラスを指す。
//     // このクラスを継承した ChildClass からコールされる場合、「ChildClass」を指す
//     public static function getNewStaticName() {
//         return get_class(new static());
//     }
// }

// class ChildClass extends ParentClass {
// }

// // 「self」は、定義されたクラスを指す
// echo ParentClass::getNewSelfName() . PHP_EOL;    //=> ParentClass
// echo ChildClass::getNewSelfName()  . PHP_EOL;    //=> ParentClass

// // 「static」は、呼び出されたクラスを指す
// echo ParentClass::getNewStaticName() . PHP_EOL;  //=> ParentClass
// echo ChildClass::getNewStaticName()  . PHP_EOL;  //=> ChildClass


