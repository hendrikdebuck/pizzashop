<?php
//includes
require_once("entities/winkelmand.class.php");
class WinkelmandDAO {
    public static function voegNieuweBestellingToe($bestelling){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "insert into bestellingen(klantId,tijdBesteld,tijdGewenst,status,extraKorting) values (:klantid, :tijdbesteld, :tijdgewenst, :status, :extrakorting )";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":klantid", $bestelling->getKlant()->getKlantId());
        //print($bestelling->getBesteld());
        $stmt->bindParam(":tijdbesteld", $bestelling->getBesteld());
        $stmt->bindParam(":tijdgewenst", $bestelling->getGewenst());
        $stmt->bindParam(":status" , $bestelling->getStatus());
        $stmt->bindParam(":extrakorting", $bestelling->getExtraKorting());

        if($stmt->execute()){
            return $dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
}
?>