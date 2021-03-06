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
    
    public static function geefProductenVanCat($catid){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select id from producten where categorieid = :catid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":catid",$catid);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                array_push($res, $rij["id"]);
            }
            if(!$res){
                return false;
            }else{
                return $res;
            }
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
    
    public static function voegNieuwProductToe($product){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Insert into producten (naam, omschrijving, prijs, categorieId, korting, isActief) values (:naam, :omschrijving, :prijs, :categorieId, :korting, :isActief)";
        $stmt = $dbh->prepare($sql);
        $actief = 1;
        $stmt->bindParam(":naam", $product->getNaam());
        $stmt->bindParam(":omschrijving",$product->getOmschrijving() );
        $stmt->bindParam(":prijs",$product->getBasisPrijs() );
        $stmt->bindParam(":categorieId",$product->getCatId() );
        $stmt->bindParam(":korting",$product->getKorting() );
        $stmt->bindParam(":isActief", $actief);
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
    
    public static function updateProduct($product){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Update producten set omschrijving = :omschrijving , naam = :naam, prijs = :prijs, categorieId = :catid, korting = :korting where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id",$product->getId());
        $stmt->bindParam(":omschrijving",$product->getOmschrijving());
        $stmt->bindParam(":naam",$product->getNaam());
        $stmt->bindParam(":catid",$product->getCatId());
        $stmt->bindParam(":prijs",$product->getBasisPrijs());
        $stmt->bindParam(":korting",$product->getKorting());
        if($stmt->execute()){
            return true;
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
    public static function deleteCat($catId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Delete from categorien where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id",$catId);
        if($stmt->execute()){
            return true;
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
    public static function geefCatOmschrijvingMetId($catId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select omschrijving from categorien where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id",$catId);
        if($stmt->execute()){
            $rij = $stmt->fetch();
            return $rij["omschrijving"];
        }else{
            print_r($stmt->errorInfo());
            return false;
        }
    }
}
?>