<?php
//includes
require_once("entities/extra.class.php");
require_once("data/productdao.class.php");
class ExtraDao extends ProductDao {
    //put your code here
    public static function getAllExtras(){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select producten.id as prodid, naam, prijs from producten inner join categorien on categorieid = categorien.id where categorien.omschrijving = 'Extra'";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $extra = new Extra($rij["prodid"], $rij["naam"], $rij["prijs"]);
                
                array_push($res, $extra);
            }
            return $res;
        }else{
            print($stmt->errorInfo());
        }
    }
    
    public static function getExtraById($id){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select naam, prijs from producten where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id",$id);
        if($stmt->execute()){
            $rij = $stmt->fetch();
            $extra = new Extra($id, $rij["naam"], $rij["prijs"]);
            
            return $extra;
        }else{
            print($stmt->errorInfo());
        }
    }
    
    public static function getAllExtraIds(){
        //return arr of ints
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select producten.id as extraid from producten inner join categorien on categorieid = categorien.id where categorien.omschrijving = 'Extra'";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                array_push($res,$rij["extraid"]);
            }
            return $res;
        }else{
            print($stmt->errorInfo());
        }
    }
    
}
?>