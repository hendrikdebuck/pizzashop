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
}
?>