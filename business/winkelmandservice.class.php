<?php
//includes
require_once("entities/winkelmand.class.php");

class WinkelmandService {
    //put your code here
    public static function voegBestellingToe($mandje){
        //voeg de bestelling zelf toe (in bestellingen)
        //tijd besteld
        $tijd = new DateTime();
        $tijdBesteld = $tijd->format('Y-m-d H:i:s');
        
        $mandje->setBesteld($tijdBesteld);
        //vraag id van bestelling
        
        //voeg bestelregel(s) toe
        
        //voeg eventuele extrasToekenningen toe
        
        //temp checking code
        /*print("<pre>");
        print_r($mandje);
        print("</pre>");*/
    }
}
?>