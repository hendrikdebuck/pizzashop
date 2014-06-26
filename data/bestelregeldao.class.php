<?php
//includes
require_once("entities/bestelregel.class.php");
require_once("entities/pizza.class.php");
require_once("entities/extra.class.php");
require_once("data/productdao.class.php");
class BestelregelDao {
    public static function voegBestelregelToe($bestelRegel, $bestellingId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "insert into bestelregels(bestellingsId,productId,aantal, kortingOpBestelregel ) values (:bestelid, :productid, :aantal, :kortingopregel)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":bestelid", $bestellingId);
        $stmt->bindParam(":productid" , $bestelRegel->getProduct()->getId());
        $stmt->bindParam(":aantal" , $bestelRegel->getAantal());
        $stmt->bindParam(":kortingopregel" , $bestelRegel->getKorting());
        
        if($stmt->execute()){
            return $dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
    public static function voegExtraToekenningToe($extra, $regelId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "insert into extrastoekenningen(bestelRegelId, extraId, aantal) values (:regelid, :extraid, :aantal)";
        $stmt = $dbh->prepare($sql);
        $aantal = 1;
        $stmt->bindParam(":regelid", $regelId);
        $stmt->bindParam(":extraid", $extra->getId());
        $stmt->bindParam(":aantal", $aantal);
        
        if($stmt->execute()){
            return true;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefBestelRegelsVanBestelId($bestId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select bestelregelid, productId, aantal, kortingOpBestelregel from bestelregels where bestellingsId = :bestelId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":bestelId",$bestId);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $tempRegel = new Bestelregel();
                $tempRegel->setId($rij["bestelregelid"]);
                $tempRegel->setAantal($rij["aantal"]);
                $tempRegel->setKorting($rij["kortingOpBestelregel"]);
                
                $tempRegel->setProduct(ProductDao::geefProductMetId($rij["productId"]));
                array_push($res, $tempRegel);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
}
?>