<?php
//includes
require_once("/libs/myconfig.php");
require_once("entities/klant.class.php");
class AccountDao {
     public static function isLoginCorrect($login, $pw){
         $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
         $sql = "Select id from accounts where login = :login && paswoord = :pw && isgeblokkeerd = false";
         $stmt = $dbh->prepare($sql);
         $stmt->bindParam(":login", $login);
         $stmt->bindParam(":pw", $pw);
         
         if($stmt->execute()){
             $rij = $stmt->fetch();
             if(!$rij){
                 return null;
             }else{
                 $res = $rij["id"];
                 return $res;
             }
         }else{
             print_r($stmt->errorInfo());
         }
     }
     
     public static function getIdByLogin($login){
         $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
         $sql = "select id from accounts where login = :login";
         $stmt = $dbh->prepare($sql);
         $stmt->bindParam(":login", $login);
         
         if($stmt->execute()){
             $rij = $stmt->fetch();
             if(!$rij){
                 return null;
             }else{
                 return $rij["id"];
             }
         }else{
             print_r($stmt->errorInfo());
         }
     }
     
     public static function addNewAccount($klant){
         $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
         $sql = "insert into accounts (login, paswoord, isBeheerder) values (:login, :pass, 0)";
         $stmt = $dbh->prepare($sql);
         $stmt->bindParam(":login", $klant->getLogin());
         $stmt->bindParam(":pass", $klant->getPw());
         
         if($stmt->execute()){
             return true;
         }else{
             print_r($stmt->errorInfo());
         }
         
     }
     
     public static function adminLogin($login, $pw){
         $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
         $sql = "Select id from accounts where login = :login && paswoord = :pw && isgeblokkeerd = false & isbeheerder = true";
         $stmt = $dbh->prepare($sql);
         $stmt->bindParam(":login", $login);
         $stmt->bindParam(":pw", $pw);
         
         if($stmt->execute()){
             $rij = $stmt->fetch();
             if(!$rij){
                 return null;
             }else{
                 $res = $rij["id"];
                 return $res;
             }
         }else{
             print_r($stmt->errorInfo());
         }
     }
}
?>