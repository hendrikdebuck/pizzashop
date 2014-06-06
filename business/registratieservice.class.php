<?php
//includes
require_once("data/accountdao.class.php");
require_once("data/klantdao.class.php");
class RegistrationService {
    //put your code here
    public static function voegNieuweKlantToe($klant){
        print(" in service ");
        //voeg account toe
        if(AccountDao::addNewAccount($klant)){
            print("great succes ");
        }
        //vraag id van de nieuwe account op met loginnaam
        $accId = AccountDao::getIdByLogin($klant->getLogin());
        //print($accId);
        $klant->setId($accId);
        //controle of postcode in db zit
        if(!($gemId = KlantDao::geefIdVanGemeente($klant->getGemeente()))){
            //voeg nieuwe postcode toe in database
            print("de gemeente zit niet in de db!");
            if(KlantDao::voegGemeenteMetPostcodeToe($klant->getGemeente(), $klant->getPostcode())){
                print(" gemeente en postcode toegevoegd ");
                $gemId = KlantDao::geefIdVanGemeente($klant->getGemeente());
            }
        }
        //print(" gemeenteId = " . $gemId);
        //print(" id uit object: " . $klant->getId());
        //voeg de klant toe
        if(KlantDao::voegKlantToe($klant,$gemId)){
            print("klant toegevoegd!");
        }
    }
}

?>
