<?php
//includes
require_once("entities/bestelregel.class.php");
require_once("entities/pizza.class.php");
require_once("entities/extra.class.php");
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
    
}
?>