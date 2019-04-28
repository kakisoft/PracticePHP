<?php

// class_exists
// method_exists

$controller =& new $class;

if (class_exists($class)) {
    $controller =& new $class;
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
        exit;
    }
}
