<?php
session_start();
//includes
require_once("libs/Twig/Autoloader.php");
require_once("entities/winkelmand.class.php");
require_once("data/pizzadao.class.php");
require_once("data/extradao.class.php");
require_once("business/winkelmandservice.class.php");
require_once("entities/klant.class.php");

if(isset($_GET["bevestig"]) && $_GET["bevestig"] == "Bestelling plaatsen"){
    //activeer de service
    //leeg de session
    //print("bevestigd!");
    if(isset($_SESSION["klant"]) && $_SESSION["klant"] != ""){
        WinkelmandService::voegBestellingToe(unserialize($_SESSION["bestelling"]));
    }else{
        header("location: winkelmand.php?inloggenaub=true");
    }
}

if(isset($_SESSION["klant"]) && $_SESSION["klant"] != ""){
    $klant = unserialize($_SESSION["klant"]);
}else{
    $klant = null;
}

if(isset($_SESSION["bestelling"])){
    $mandje = unserialize($_SESSION["bestelling"]);
    if(isset($_GET["verwijder"]) && $_GET["verwijder"] >= 0){
        //print("verwijdering processing");
        $mandje->verwijderBestelregel($_GET["verwijder"]);
        //print("id weg: " . $_GET["verwijder"]);
        $_SESSION["bestelling"] = serialize($mandje);
    }
}else{
    $mandje = null;
}

if(isset($_GET["inloggenaub"]) && $_GET["inloggenaub"]){
    //print("login needed");
    $loginneeded = true;
}else{
    $loginneeded = false;
}

$donotshowmand = true;

twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("winkelmandlarge.twig", array("donotshowmand" => $donotshowmand,"klant" => $klant, "mandje" => $mandje, "inloggenpls" => $loginneeded));
print($view);
?>