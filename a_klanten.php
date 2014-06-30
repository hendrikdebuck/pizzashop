<?php
//includes
session_start();

require_once("libs/Twig/Autoloader.php");
require_once("data/klantdao.class.php");

require("helpers/adminChecker.php");

if(isset($_GET["pasaan"]) && $_GET["pasaan"]){
    
}


$klanten = KlantDao::GeefAlleKlanten();




twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("a_klanten.twig", array("adminisin" => $ingelogd, "klanten" => $klanten));
print($view);


?>