<?php

class Team {
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
  public function sayHi() {
    echo "hi, We are  $this->name!";
  }
}