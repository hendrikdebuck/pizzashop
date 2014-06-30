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
                $klant->setEmail($rij["email"]);
                $klant->setBtwNr($rij["btwnr"]);
                $klant->setTelefoon($rij["telefoon"]);
                $klant->setOpmerkingen($rij["opmerkingen"]);
                //print("klant af");
                array_push($res, $klant);
            }
            return $res;
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function geefIdVanGemeente($gemeente){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "Select id from postcodes where gemeente = :gemeente";
        $stmt = $dbh->prepare($sql);
        
        $stmt->bindParam(":gemeente" , $gemeente);
        if($stmt->execute()){
            $rij = $stmt->fetch();
            if(!$rij){
                return null;
            }else {
                return $rij["id"];
            }
        }else{
            print_r($stmt->errorInfo());
        }
    }
    
    public static function voegGemeenteMetPostcodeToe($gemeente, $postcode){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "insert into postcodes (postcode,gemeente) values (:postcode,:gemeente)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":postcode",$postcode);
        $stmt->bindParam(":gemeente",$gemeente);
        if($stmt->execute()){
            return true;
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
    
    public static function voegKlantToe($klant, $gemId){
        $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
        $sql = "insert into klanten (naam, voornaam, adres, postcodeId, btwNr, telefoon, email, pizzateller, opmerkingen, blokkering, accountId) values
            ( :naam, :vnaam , :adres , :postcodeId, :btw, :tel, :email, 0, '', 0, :accId )";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":naam",$klant->getNaam());
        $stmt->bindParam(":vnaam",$klant->getVnaam());
        $stmt->bindParam(":adres",$klant->getAdres());
        $stmt->bindParam(":postcodeId",$gemId);
        $stmt->bindParam(":btw",$klant->getBtwNr());
        $stmt->bindParam(":tel",$klant->getTelefoon());
        $stmt->bindParam(":email",$klant->getEmail());
        $stmt->bindParam(":accId",$klant->getId());
        
        if($stmt->execute()){
            print(" reg compleet");
        }else{
            print_r($stmt->errorInfo());
        }
    }
}

?>
