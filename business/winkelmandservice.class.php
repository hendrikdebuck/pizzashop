<?php
//includes
require_once("entities/winkelmand.class.php");
require_once("data/winkelmanddao.class.php");
require_once("entities/klant.class.php");
require_once("data/bestelregeldao.class.php");

class WinkelmandService {
    //put your code here
    public static function voegBestellingToe($mandje){
        //voeg de bestelling zelf toe (in bestellingen)
        //tijd besteld
        $tijd = new DateTime();
        $tijdBesteld = $tijd->format('Y-m-d H:i:s');
        
        $mandje->setBesteld($tijdBesteld);
        $tijd->add(new DateInterval('PT15M'));
        //temp values
        $tijdGewenst = $tijd->format('Y-m-d H:i:s');
        $mandje->setGewenst($tijdGewenst);
        $mandje->setStatus(3);
        $mandje->setExtraKorting(0);
        
        //toevoegen van de nieuwe bestelling
        if($BestelId = WinkelmandDAO::voegNieuweBestellingToe($mandje)){
            //vraag id van bestelling
            //print($BestelId);
            $mandje->setId($BestelId);
            //voeg bestelregel(s) toe
            foreach($mandje->getBestelregelArr() as $bestelRegel){
                $bestelRegel->setKorting(0);
                $regelId = BestelregelDao::voegBestelregelToe($bestelRegel, $BestelId);
                //controle of het product een pizza is
                if(get_class($bestelRegel->getProduct()) == "Pizza"){
                    //print("tis een pizza!");
                    //voeg de pizza extras toe
                    foreach($bestelRegel->getProduct()->getArrExtras() as  $extraatje){
                        //voeg elke extra toe
                        //print("een extra: <br>");
                        //print($regelId . " => regelid<br>");
                        //print($extraatje->getId() . "=> extra id <br>");
                        BestelregelDao::voegExtraToekenningToe($extraatje, $regelId);
                        
                    }
                }
            }
            
        }
        
        //temp checking code
        /*print("<pre>");
        print_r($mandje);
        print("</pre>");*/
    }
}
?>