<?php
//includes
session_start();
require_once("libs/Twig/Autoloader.php");
require_once("business/klantservice.class.php");
require_once("entities/pizza.class.php");
require_once("data/pizzadao.class.php");
require_once("data/extradao.class.php");
require_once("entities/winkelmand.class.php");
//globals
//checks

if(isset($_SESSION["bestelling"])){
    print("isset");
    //$testbest = new Winkelmand();
    $testunser = unserialize($_SESSION["bestelling"]);
    print("<pre>");
    print_r($testunser);
    print("</pre>");
}else{
    print("not set");
}
?>

