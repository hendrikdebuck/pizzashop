<?php
//includes
require_once("/libs/myconfig.php");
require_once("/entities/klant.class.php");

class KlantDao {
    //put your code here
    
    public static function GeefAlleKlanten(){
        /*
         * return array Klant met alle klanten
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $res = array();
        $sql = "Select klanten.id as klantid, accounts.login as login, accounts.paswoord as pw,accounts.id as accid, naam, voornaam, adres, postcode, gemeente, btwnr, telefoon, email, pizzateller, opmerkingen, blokkering, accountId from klanten inner join accounts on klanten.accountid = accounts.id inner join postcodes on postcodeId = postcodes.id";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute()){
            $dataSet = $stmt->fetchAll();
            //print_r($dataSet);
            
            foreach($dataSet as $rij){
                $klant = new Klant($rij["accid"], $rij["login"], $rij["pw"],$rij["klantid"], $rij["naam"], $rij["voornaam"], $rij["adres"], $rij["postcode"], $rij["gemeente"], $rij["pizzateller"], $rij["blokkering"]);
                //print("klant af");
                array_push($res, $klant);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
        
    }
    
    public static function GeefKlantMetId($id){
        /*
         * @id = klant id
         * returns Klant()
         */
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select accounts.login as login, accounts.paswoord as pw,accounts.id as accid, naam, voornaam, adres, postcode, gemeente, btwnr, telefoon, email, pizzateller, opmerkingen, blokkering, accountId from klanten inner join accounts on klanten.accountid = accounts.id inner join postcodes on postcodeId = postcodes.id where klanten.id = :klantid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":klantid",$id);
        
        if($stmt->execute()){
            $rij = $stmt->fetch();
            $klant = new Klant($rij["accid"], $rij["login"], $rij["pw"],$id, $rij["naam"], $rij["voornaam"], $rij["adres"], $rij["postcode"], $rij["gemeente"], $rij["pizzateller"], $rij["blokkering"]);
            
            return $klant;
        }else{
            print_r($stmt->errorInfo());
        }
        
        
    }
        
}

?>
