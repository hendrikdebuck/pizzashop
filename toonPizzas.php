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
//de gewenste/ongewenste extra zijn (niet)geselecteerd
if(isset($_POST["pizzaId"]) && isset($_POST["extrastoevoegen"]) && $_POST["extrastoevoegen"] == "Toevoegen"){
    if(!isset($_SESSION["bestelling"])){
        print("leeg mandje");
        $bestelling = new Winkelmand();
        $nieuwePizza = PizzaDao::getPizzaById($_POST["pizzaId"]);
        $extraids = ExtraDao::getAllExtraIds();
        //print_r($extraids);
        //overloop alle mogelijke extras en kijk hoeveel ze erbij gegooid moeten worden
        foreach($extraids as $exId){
            if(isset($_POST[$exId]) && (int)$_POST[$exId] != 0){
                //print("id" + $exId);
                $extrObjToeTeVoegen = ExtraDao::getExtraById($exId);
                $nieuwePizza->voegExtraToe($extrObjToeTeVoegen);
            }
        }
        $bestelling->voegProductToe($nieuwePizza);
//        print("<pre>");
//        print_r($bestelling);
//        print("</pre>");
        $ser = serialize($bestelling);
        //print($ser);
        $_SESSION["bestelling"] = $ser;

    }else{
        $bestelling = unserialize($_SESSION["bestelling"]);
        //$bestelling->voegProductToe();
    }
}
if(isset($_SESSION["bestelling"])){
    //$testbest = new Winkelmand();
    $testunser = unserialize($_SESSION["bestelling"]);
    print("<pre>");
    print_r($testunser);
    print("</pre>");
}
//globals
$lijstPizzas = PizzaDao::geefAlleSoortenPizzas();
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$pre = $twig->render("topHeader.twig");
$end = $twig->render("bottomCloser.twig");
if(isset($nieuwePizza)){
    $view = $twig->render("productenVoorKlant.twig", array("pizzaLijst" => $lijstPizzas, "nieuwePizza" => $nieuwePizza, "extras" => $extras));
}else{
    $view = $twig->render("productenVoorKlant.twig", array("pizzaLijst" => $lijstPizzas));
}
print($pre);
print($view);
print($end);

?>