<?php
//includes
session_start();

require_once("libs/Twig/Autoloader.php");
require_once("data/accountdao.class.php");

//admin login controller
$ingelogd = false;

//controle op inloggen van de admin
if(isset($_POST["inlogknop"]) && $_POST["inlogknop"]){
    if(isset($_POST["emailinput"]) && isset($_POST["pwinput"]) && $_POST["emailinput"] != "" && $_POST["pwinput"] != ""){
        //print("admin login");
        //velden ingevuld
        
        if(AccountDao::adminLogin($_POST["emailinput"],$_POST["pwinput"])){
            $_SESSION["adminset"] = true;
            print("ingelogd");
        }else{
            print("login niet gelukt");
        }
    }
}

//controle op uitloggen van de admin
if(isset($_POST["uitlogknop"]) && $_POST["uitlogknop"]){
    $ingelogd = false;
    $_SESSION["adminset"] = false;
}

if(isset($_SESSION["adminset"]) && $_SESSION["adminset"]){
    $ingelogd = true;
    //print("the admin stuff");
}


//render
twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("adminlogin.twig", array("adminisin" => $ingelogd));
print($view);

?>