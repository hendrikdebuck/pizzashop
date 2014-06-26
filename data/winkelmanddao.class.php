<?php
//includes
require_once("entities/winkelmand.class.php");
require_once("data/klantdao.class.php");
require_once("libs/myconfig.php");
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
    public static function geefAlleBestellingen(){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select bestellingen.id as besId, klantId, tijdBesteld, tijdGewenst, status, extraKorting from bestellingen";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $tempBest = new Winkelmand();
                $tempBest->setId($rij["besId"]);
                $tempBest->setStatus($rij["status"]);
                $tempBest->setBesteld($rij["tijdBesteld"]);
                $tempBest->setGewenst($rij["tijdGewenst"]);
                $tempBest->setExtraKorting($rij["extraKorting"]);
                
                $tKlant = KlantDao::GeefKlantMetId($rij["klantId"]);
                $tempBest->setKlant($tKlant);
                
                array_push($res, $tempBest);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
    public static function geefBestellingMetId($id){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select bestellingen.id as besId, klantId, tijdBesteld, tijdGewenst, status, extraKorting from bestellingen where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            $rij = $stmt->fetch();
            if($rij){
                $tempBest = new Winkelmand();
                $tempBest->setId($rij["besId"]);
                $tempBest->setStatus($rij["status"]);
                $tempBest->setBesteld($rij["tijdBesteld"]);
                $tempBest->setGewenst($rij["tijdGewenst"]);
                $tempBest->setExtraKorting($rij["extraKorting"]);
                
                $tKlant = KlantDao::GeefKlantMetId($rij["klantId"]);
                $tempBest->setKlant($tKlant);
                
                return $tempBest;
            }
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
}
?>