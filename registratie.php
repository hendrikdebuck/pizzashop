<?php
//includes
require_once("libs/Twig/Autoloader.php");
require_once("data/klantdao.class.php");
require_once("libs/regval.class.php");
require_once("data/accountdao.class.php");
require_once("business/registratieservice.class.php");

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
        //print("pass 1 ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtpw1"], "txtpw1", $errors, "pass");
    }
    if(isset($_POST["txtpw2"])){
        //print("pass 2 ingevuld");
        $errors = Validate::ValidateItemOnType($_POST["txtpw2"], "txtpw2", $errors, "pass");
    }
    if(isset($_POST["txtpw1"]) && isset($_POST["txtpw2"])){
        $errors = Validate::ValidatePasswords($_POST["txtpw1"], $_POST["txtpw2"], "txtpw1", "txtpw2", $errors);
    }
//    print("<pre>");
//    print_r($errors);
//    print("</pre>");
    
    //checks met database voor invoegen
    if(empty($errors)){
        //print("no errors, lets go on!");
        //check of login bestaat, if not, naar de db ermee
        if(AccountDao::getIdByLogin($_POST["txtlogin"])){
            //print("account bestaat al");
            $mess = "Loginnaam bestaat al.";
            array_push($errors, new ErrorMessage("txtlogin", $mess));
        }
    }
    
    if(empty($errors)){
        print("we kunnen invoegen");
        //maak de nodige objecten aan en geef door aan de register service
        //$klant = new Gebruiker(0, $_POST["txtlogin"], $_POST["txtpw1"]);
        $klant = new Klant(0, $_POST["txtlogin"], $_POST["txtpw1"], 0, $_POST["txtnaam"], $_POST["txtvnaam"], $_POST["txtadres"], $_POST["txtpostcode"], $_POST["txtgemeente"], 0, 0);
        $klant->setTelefoon($_POST["txttel"]);
        $klant->setEmail($_POST["txtemail"]);
        
        RegistrationService::voegNieuweKlantToe($klant);
    }
    
    
    
}

//globals


//renders
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem("presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("registerWindow.twig", array("fouten" => $errors));
print("$view");
?>