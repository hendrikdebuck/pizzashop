<?php
//includes
require_once("/libs/myconfig.php");
class AccountDao {
     
     
     public static function isLoginCorrect($login, $pw){
         $dbh = new PDO(Info::$dbinfo,Info::$dbusername, Info::$dbpw);
         $sql = "Select id from accounts where login = :login && paswoord = :pw";
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