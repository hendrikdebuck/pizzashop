<?php
session_start();
//includes
require_once("data/accountdao.class.php");
require_once("data/klantdao.class.php");
//checks
//is het loginform ingevuld?
if(isset($_POST["inlogknop"]) && $_POST["inlogknop"] == "Aanmelden"){
    if(isset($_POST["emailinput"]) && isset($_POST["pwinput"])){
        //print("via form met info in beide velden");
        //doe de check met db
        $idIngelogd = AccountDao::isLoginCorrect($_POST["emailinput"],$_POST["pwinput"]);
        if(isset($idIngelogd)){
            print("succes");
            $deklant = KlantDao::GeefKlantMetId($idIngelogd);
            //print_r($deklant);
            $_SESSION["klant"] = serialize($deklant);
            //print_r(unserialize($_SESSION["klant"]));
        }else{
            print("login NOK");
        }
        header("location: toonPizzas.php");
    }
}else{
    header("location: toonPizzas.php");
}

?>