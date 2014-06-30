<?php
//includes
session_start();

require_once("data/winkelmanddao.class.php");
require_once("data/bestelregeldao.class.php");
require_once("libs/Twig/Autoloader.php");

require("helpers/adminChecker.php");

if(isset($_POST["updatestatus"]) && $_POST["updatestatus"]){
    if(isset($_POST["newstatus"]) && $_POST["newstatus"]){
        print("both set");
        WinkelmandDAO::updateStatusVanBestellingMetId($_GET["bekijk"], $_POST["newstatus"]);
    }
}

if(isset($_GET["bekijk"]) && $_GET["bekijk"] >= 0){
    $bestellingen = null;
    $gekozenBestel = WinkelmandDAO::geefBestellingMetId($_GET["bekijk"]);
    $bestelregels = BestelregelDao::geefBestelRegelsVanBestelId($_GET["bekijk"]);
}else{
    $bestellingen = WinkelmandDAO::geefAlleBestellingen();
    $bestelregels = null;
    $gekozenBestel = null;
}
//render
twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("a_bestellingen.twig", array("adminisin" => $ingelogd, "bestellingen" => $bestellingen, "bekijkBestelling" => $gekozenBestel, "regels" => $bestelregels));
print($view);

?>