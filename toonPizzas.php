<!DOCTYPE HTML>
<?php
session_start();
//includes
require_once("libs/Twig/Autoloader.php");
require_once("business/klantservice.class.php");
require_once("entities/pizza.class.php");
require_once("data/pizzadao.class.php");
require_once("data/extradao.class.php");
require_once("entities/winkelmand.class.php");

//checken op inkomende requests

//er is geklikt op een pizzalijn (bestel hier)
if(isset($_GET["bestel"]) && $_GET["bestel"] == "pizza"){
    if(isset($_GET["pizzaId"])){
        //doe wat te doen na selecteren van een pizza (extra's en zo toevoegen)
        $nieuwePizza = ProductDao::geefProductMetId($_GET["pizzaId"]);
        $extras = ExtraDao::getAllExtras();
        //print_r($nieuwePizza);
    }
}
//er is geklikt op een andere product dan een pizza
if(isset($_GET["bestel"]) && $_GET["bestel"] == "product"){
    if(isset($_GET["productId"])){
        //nieuw product toevoegen, anders dan een pizza
        if(!isset($_SESSION["bestelling"])){
            //print("leeg mandje");
            $bestelling = new Winkelmand();
        }else{
            //print("al een mandje");
            $bestelling = unserialize($_SESSION["bestelling"]);
        }
        $nieuwProduct = ProductDao::geefProductMetId($_GET["productId"]);
        //invoegen van nieuwe bestelregel in sessie
        $bestelregel = new Bestelregel();
        $bestelregel->setProduct($nieuwProduct);
        if(isset($_GET["prodaantal"]) && is_numeric($_GET["prodaantal"]) && $_GET["prodaantal"] >= 0 && $_GET["prodaantal"] != ""){
            $aantal = $_GET["prodaantal"];
        }else{
            $aantal = 1;
        }
        $bestelregel->setAantal($aantal);
        $bestelling->voegBestelregelToe($bestelregel);
        print($aantal);
        $_SESSION["bestelling"] = serialize($bestelling);
    }
}
//de gewenste/ongewenste extra zijn (niet)geselecteerd
if(isset($_POST["pizzaId"]) && isset($_POST["extrastoevoegen"]) && $_POST["extrastoevoegen"] == "Toevoegen"){
    if(!isset($_SESSION["bestelling"])){
        //print("leeg mandje");
        $bestelling = new Winkelmand();
    }else{
        //print("al een mandje");
        $bestelling = unserialize($_SESSION["bestelling"]);
        //$bestelling->voegProductToe();
    }
    $nieuwePizza = PizzaDao::getPizzaById($_POST["pizzaId"]);
    $extraids = ExtraDao::getAllExtraIds();
    //print_r($extraids);
    //overloop alle mogelijke extras en kijk of ze erbij gegooid moeten worden
    foreach($extraids as $exId){
        if(isset($_POST[$exId]) && (int)$_POST[$exId] != 0){
            //print("id" + $exId);
            $extrObjToeTeVoegen = ExtraDao::getExtraById($exId);
            $nieuwePizza->voegExtraToe($extrObjToeTeVoegen);
        }
    }
    //aantal toevoegen
    if(isset($_POST["prodaantal"]) && is_numeric($_POST["prodaantal"]) && $_POST["prodaantal"] >= 0){
        $aantal = $_POST["prodaantal"];
    }else{
        $aantal = 1;
    }
    $pizzaRegel = new Bestelregel();
    $pizzaRegel->setProduct($nieuwePizza);
    $pizzaRegel->setAantal($aantal);
    $bestelling->voegBestelregelToe($pizzaRegel);
//        print("<pre>");
//        print_r($bestelling);
//        print("</pre>");
    $ser = serialize($bestelling);
    //print($ser);
    $_SESSION["bestelling"] = $ser;
}
if(isset($_SESSION["bestelling"])){
    $mandje = unserialize($_SESSION["bestelling"]);
    //print("<pre>");
    //print_r($testunser);
    //print("</pre>");
}else{
    $mandje = null;
}
if(isset($_SESSION["klant"])){
    $klant = unserialize($_SESSION["klant"]);
}else{
    $klant = null;
}
//globals
$lijstPizzas = PizzaDao::geefAlleSoortenPizzas();
$lijstAndere = ProductDao::geefAlleProductenTenzijExtraOfPizza();

$lijstCats = ProductDao::geefAlleCategorienTenzijExtraOfPizza();
//print_r($lijstCats);
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
if(isset($nieuwePizza)){
    $view = $twig->render("productenVoorKlant.twig", array("pizzaLijst" => $lijstPizzas, "klant" => $klant, "productLijst" => $lijstAndere, "catLijst" => $lijstCats, "nieuwePizza" => $nieuwePizza, "extras" => $extras, "mandje" => $mandje));
}else{
    $view = $twig->render("productenVoorKlant.twig", array("pizzaLijst" => $lijstPizzas, "klant" => $klant, "productLijst" => $lijstAndere, "catLijst" => $lijstCats, "mandje" => $mandje));
}
print($view);

?>