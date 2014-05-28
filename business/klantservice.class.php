<?php
//includes
require_once("./data/klantdao.class.php");
class KlantService {
    //put your code here
    
    public static function geefAlleKlanten(){
        /*
         * return array met alle Klanten() in
         */
        $klanten = KlantDao::GeefAlleKlanten();
        return $klanten;
    }
    
    public static function geefKlantMetId($id){
        $klant = KlantDao::GeefKlantMetId($id);
        return $klant;
    }
}
?>