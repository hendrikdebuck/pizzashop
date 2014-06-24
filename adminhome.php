<?php
//includes
session_start();

require_once("libs/Twig/Autoloader.php");
require_once("data/accountdao.class.php");

//admin login controller
if(isset($_POST["inlogknop"]) && $_POST["inlogknop"]){
    if(isset($_POST["emailinput"]) && isset($_POST["pwinput"]) && $_POST["emailinput"] != "" && $_POST["pwinput"] != ""){
        print("admin login");
    }
}


//render
twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);
$view = $twig->render("adminlogin.twig");
print($view);

?>