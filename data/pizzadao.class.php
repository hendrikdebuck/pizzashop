<?php
//includes
require_once("productdao.class.php");
require_once("entities/pizza.class.php");
require_once("entities/extra.class.php");
class PizzaDao extends ProductDao {
    //put your code here
    public static function geefAlleExtrasVanBesteldePizzaByBestelregelId($id){
        /*
         * returns array van Extra() voor een samengestelde pizza naar zijn bestelregelId
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select producten.id as prodid, naam, omschrijving, prijs, isactief, aantal from extrasToekenningen inner join producten on extraid = producten.id where bestelregelid = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $extra = new Extra($rij["prodid"],$rij["naam"],$rij["prijs"]);
                
                array_push($res,$extra);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function getPizzaById($id){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select naam, producten.omschrijving as prodomschrijving, prijs, categorieid, categorien.omschrijving as catomschrijving, korting, isActief from producten inner join categorien on categorieid = categorien.id where producten.id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        if($stmt->execute()){
            $rij = $stmt->fetch();
            $pizza = new Pizza($id, $rij["naam"], $rij["prijs"]);
            $pizza->setOmschrijving($rij["prodomschrijving"]);
            $pizza->setCatId($rij["categorieid"]);
            $pizza->setCatOmschrijving($rij["catomschrijving"]);
            $pizza->setKorting($rij["korting"]);
            $pizza->setIsActief($rij["isActief"]);
            
            return $pizza;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefAlleSoortenPizzas(){
        /*
         * return array van Pizza(), alle soorten
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select producten.id as prodid, naam,korting, producten.omschrijving as om, prijs from producten inner join categorien on categorieid = categorien.id where categorien.omschrijving = 'Pizza'";   
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            foreach($dataSet as $rij){
                $pizza = new Pizza($rij["prodid"], $rij["naam"], $rij["prijs"]);
                $pizza->setOmschrijving($rij["om"]);
                $pizza->setKorting($rij["korting"]);
                
                array_push($res, $pizza);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
}
?>