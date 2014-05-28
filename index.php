<!DOCTYPE html>
<?php
require_once("libs/Twig/Autoloader.php");
require_once("business/klantservice.class.php");
require_once("entities/pizza.class.php");
require_once("data/productdao.class.php");


$tester = ProductDao::geefProductMetId(1);

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("mainView.twig", array("klantenLijst" => $tester));
print($view);



print("<pre>");
print_r($tester);
print("</pre>");


?>