<?php
//includes
require_once("libs/Twig/Autoloader.php");
require_once("data/klantdao.class.php");
require_once("libs/regval.class.php");


$errors = array();
//checks
if(isset($_SESSION["bestelling"])){
    $mandje = unserialize($_SESSION["bestelling"]);
}else{
    $mandje = null;
}

if(isset($_POST["registratieToevoegen"]) && $_POST["registratieToevoegen"] == "Registreer"){
    //print("knop gedrukt");
    if(isset($_POST["txtnaam"])){
        $errors = Validate::ValidateItemOnType($_POST["txtnaam"], "txtnaam", $errors, "tekst");
    }
    if(isset($_POST["txtvnaam"])){
        $errors = Validate::ValidateItemOnType($_POST["txtvnaam"], "txtvnaam", $errors, "tekst");
    }
    if(isset($_POST["txtadres"])){
        $errors = Validate::ValidateItemOnType($_POST["txtadres"], "txtadres", $errors, "tekst");
    }
    if(isset($_POST["txtpostcode"])){
        $errors = Validate::ValidateItemOnType($_POST["txtpostcode"], "txtpostcode", $errors, "postcode");
    }
    if(isset($_POST["txtgemeente"])){
        $errors = Validate::ValidateItemOnType($_POST["txtgemeente"], "txtgemeente", $errors, "tekst");
    }
    if(isset($_POST["txttel"])){
        $errors = Validate::ValidateItemOnType($_POST["txttel"], "txttel", $errors, "telefoon");
    }
    if(isset($_POST["txtemail"])){
        //print("email ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtemail"], "txtemail", $errors, "email");
    }
    if(isset($_POST["txtlogin"])){
        //print("email ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtlogin"], "txtlogin", $errors, "gebrnaam");
    }
    if(isset($_POST["txtpw1"])){
        print("pass 1 ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtpw1"], "txtpw1", $errors, "pass");
    }
    if(isset($_POST["txtpw2"])){
        //print("pass 2 ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtpw2"], "txtpw2", $errors, "pass");
    }
    
    //print("<pre>");
    //print_r($errors);
    //print("</pre>");
}

//globals


//renders
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("registerWindow.twig", array("fouten" => $errors));
print("$view");
?>