<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["adminset"]) && $_SESSION["adminset"]){
    $ingelogd = true;
}else{
    $ingelogd = false;
}

?>
