<?php
namespace Lib2;

class SampleClass {
    public function getSomeName() {
        $ret = "[" . __NAMESPACE__ . "]-[" . __CLASS__ . "]-[" . __METHOD__ . "]";
        return $ret;
    }
}