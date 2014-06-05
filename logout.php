<?php
session_start();

if(isset($_POST["uitlogknop"]) && $_POST["uitlogknop"] == "Afmelden"){
    if(isset($_SESSION["klant"])){
        $_SESSION["klant"] = null;
    }
    header("location: toonPizzas.php");
}
?>