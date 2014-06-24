<?php
//includes
require_once("/libs/myconfig.php");
require_once("/entities/product.class.php");

class ProductDao {
    //put your code here
    public static function geefAlleProducten(){
        /*
         * returnt array van Product() met alle producten
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select  producten.id as prodid, naam, producten.omschrijving as prodomschrijving, prijs, categorieid, categorien.omschrijving as catomschrijving, korting, isActief from producten inner join categorien on categorieid = categorien.id";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $product = new Product($rij["prodid"], $rij["naam"], $rij["prijs"]);
                $product->setOmschrijving($rij["prodomschrijving"]);
                $product->setCatId($rij["categorieid"]);
                $product->setCatOmschrijving($rij["catomschrijving"]);
                $product->setKorting($rij["korting"]);
                $product->setIsActief($rij["isActief"]);
                array_push($res,$product);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefProductMetId($id){
        /*
         * return Product() object van het meegegeven id
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select naam, producten.omschrijving as prodomschrijving, prijs, categorieid, categorien.omschrijving as catomschrijving, korting, isActief from producten inner join categorien on categorieid = categorien.id where producten.id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        if($stmt->execute()){
            $rij = $stmt->fetch();
            $product = new Product($id, $rij["naam"], $rij["prijs"]);
            $product->setOmschrijving($rij["prodomschrijving"]);
            $product->setCatId($rij["categorieid"]);
            $product->setCatOmschrijving($rij["catomschrijving"]);
            $product->setKorting($rij["korting"]);
            $product->setIsActief($rij["isActief"]);
            
            return $product;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefAlleProductenTenzijExtraOfPizza(){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select  producten.id as prodid, naam, producten.omschrijving as prodomschrijving, prijs, categorieid, categorien.omschrijving as catomschrijving, korting, isActief from producten inner join categorien on categorieid = categorien.id where categorien.omschrijving != 'Pizza' && categorien.omschrijving != 'Extra' order by categorieid";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $product = new Product($rij["prodid"], $rij["naam"], $rij["prijs"]);
                $product->setOmschrijving($rij["prodomschrijving"]);
                $product->setCatId($rij["categorieid"]);
                $product->setCatOmschrijving($rij["catomschrijving"]);
                $product->setKorting($rij["korting"]);
                $product->setIsActief($rij["isActief"]);
                array_push($res,$product);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefAlleCategorienTenzijExtraOfPizza(){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select id, omschrijving from categorien where (omschrijving != 'Pizza') && (omschrijving != 'Extra')";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                array_push($res, $rij["omschrijving"]);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefAlleCategorien(){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select id, omschrijving from categorien ";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $toadd = array($rij["id"],$rij["omschrijving"]);
                array_push($res, $toadd);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function voegNieuweCategorieToe($omschrijvingCat){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Insert into categorien (omschrijving) values (:omschrijving)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":omschrijving", $omschrijvingCat);
        if($stmt->execute()){
            return $dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
            return null;
        }
    }
    
    public static function updateCategorie($catId, $catOmschrijving){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Update categorien set omschrijving = :omschrijving where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id",$catId);
        $stmt->bindParam(":omschrijving",$catOmschrijving);
        if($stmt->execute()){
            return true;
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
}
?>