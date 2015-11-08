<?php
    error_reporting(E_ALL);
    require_once("../queue.php");
    $testObj = new actionQueue();
    $testObj->initQueue();
    $testObj->push("banana");
    var_dump($testObj);
    $testObj->push("orange");
    var_dump($testObj);
    $testObj->push("233");
    var_dump($testObj);
    $testObj->pop();
    var_dump($testObj);
    $testObj->pop();
    var_dump($testObj);
    $testObj->pop();
