<?php
//includes
session_start();

require_once("libs/Twig/Autoloader.php");
require_once("data/productdao.class.php");
require("helpers/adminChecker.php");


//toevoegen van cat
if(isset($_POST["newcat"]) && $_POST["newcat"] && isset($_POST["newcatnaam"]) && $_POST["newcatnaam"] != ""){
    //print("toevoegen cat");
    if(ProductDao::voegNieuweCategorieToe($_POST["newcatnaam"])){
        //print("succes");
    }else{
        print("iets misgelopen met toevoegen categorie");
    }
}

if(isset($_GET["verwijder"]) && $_GET["verwijder"]){
    $catId = $_GET["verwijder"];
    //verwijderen van een categorie
    //controle op aanwezige producten, als categorie daar niet in voorkomt dan pas verwijderen
    if(ProductDao::geefProductenVanCat($catId)){
        print("Er bestaan producten met dit id, kan niet worden verwijderd");
    }else{
        //print("verwijderen");
        if(ProductDao::deleteCat($catId)){
            //print("verwijderd");
        }else{
            //print("niet verwijderd??");
        }
    }
}

if(isset($_GET["pasaan"]) && $_GET["pasaan"]){
    $aanpasId = $_GET["pasaan"];
    $omschrijving = ProductDao::geefCatOmschrijvingMetId($aanpasId);
    if(isset($_POST["newomschrijving"]) && $_POST["newomschrijving"] != ""){
        ProductDao::updateCategorie($aanpasId,$_POST["newomschrijving"]);
        
        $aanpasId = null;
        $omschrijving = null;
    }
}else{
    $aanpasId = null;
    $omschrijving = null;
}

//alle categorien tonen/aanpassen van 1
$cats = ProductDao::geefAlleCategorien();


//render
twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("a_categorien.twig", array("adminisin" => $ingelogd, "categorien" => $cats,"aanpasId" => $aanpasId, "omschrijving" => $omschrijving));
print($view);


?>