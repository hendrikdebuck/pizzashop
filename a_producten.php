<?php
//includes
session_start();

require_once("libs/Twig/Autoloader.php");
require_once("data/productdao.class.php");

require("helpers/adminChecker.php");
//


if(isset($_GET["pasaan"]) && $_GET["pasaan"] >= 0){
    //print("aanpassen prod");
    $aanTePassenProd = ProductDao::geefProductMetId($_GET["pasaan"]);
}else{
    $aanTePassenProd = null;
}

//toevoegen van een nieuw
if(isset($_POST["newprod"]) && $_POST["newprod"]){
    //print("geduwd!");
    //controle op ingegeven waarden
    if(isset($_POST["newprodnaam"]) && isset($_POST["newprodomschrijving"]) && isset($_POST["newprodprijs"]) && isset($_POST["newprodkorting"])){
        //print("alles set");
        if($_POST["newprodnaam"] && $_POST["newprodomschrijving"] && $_POST["newprodprijs"]){
            //print("ingevuld");
            //invoeren van nieuw product
            $nProduct = new Product(0, $_POST["newprodnaam"], $_POST["newprodprijs"]);
            $nProduct->setCatId($_POST["newprodcatid"]);
            $nProduct->setKorting($_POST["newprodkorting"]);
            $nProduct->setOmschrijving($_POST["newprodomschrijving"]);
            ProductDao::voegNieuwProductToe($nProduct);
        }else{
            print("leeg");
            //geef errormessages
        }
    }
}

//updaten van bestaande producten
if(isset($_POST["produpdate"]) && $_POST["produpdate"]){
    //print("updating");
    if(isset($_POST["newprodnaam"]) && isset($_POST["newprodomschrijving"]) && isset($_POST["newprodprijs"]) && isset($_POST["newprodkorting"])){
        //print("alles set");
        if($_POST["newprodnaam"] && $_POST["newprodomschrijving"] && $_POST["newprodprijs"]){
            //print("ingevuld");
            //invoeren van nieuw product
            $nProduct = new Product($_POST["pasaan"], $_POST["newprodnaam"], $_POST["newprodprijs"]);
            $nProduct->setCatId($_POST["newprodcatid"]);
            $nProduct->setKorting($_POST["newprodkorting"]);
            $nProduct->setOmschrijving($_POST["newprodomschrijving"]);
            
            ProductDao::updateProduct($nProduct);
        }
    }
}

$producten = ProductDao::geefAlleProducten();
$cats = ProductDao::geefAlleCategorien();
//render
twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("a_producten.twig", array("adminisin" => $ingelogd, "producten" => $producten,"modiProd" => $aanTePassenProd, "categorien" => $cats));
print($view);


?>