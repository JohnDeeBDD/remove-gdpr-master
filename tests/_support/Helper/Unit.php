<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module{

    //command can go here. They run after each test
    public function __contruct(){
        echo("CONSTRUCTCONSTRUCTCONSTRUCTCONSTRUCTCONSTRUCTCONSTRUCTCONSTRUCTCONSTRUCT");
    }
    // HOOK: before each suite
    public function _beforeSuite($settings = array()) {
        echo("BEFOREBEFOREBEFOREBEFOREBEFOREBEFOREBEFOREBEFOREBEFOREBEFORE ");die();
    }
}