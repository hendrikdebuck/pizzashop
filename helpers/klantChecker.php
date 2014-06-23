<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//includes
require_once("entities/klant.class.php");

if(isset($_SESSION["klant"]) && $_SESSION["klant"] != ""){
    $klant = unserialize($_SESSION["klant"]);
}else{
    $klant = null;
}
?>