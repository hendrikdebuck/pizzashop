<?php
//includes
require_once("libs/errormess.class.php");
class Validate {
    //put your code here
    function __construct() {
    }
    
    public static function ValidateItemOnType($toTest, $iden, $errArr, $type){
        //needs $toTest string for testing
        //needs $iden , this becomes the index in the array if checking fails
        //return & requires $errArr with present errors
        //needs $type string
        
        //types:
        //postcode
        //email
        //login
        //pw
        
        //is value ingevuld?
        if(!isset($toTest) || trim($toTest) == ""){
            $mess = "Veld niet ingevuld.";
            $toAdd = new ErrorMessage($iden, $mess);
            array_push($errArr,$toAdd);
            
        }else{
            //check op type
            if($type == "tekst"){
                if(!(strlen($toTest) > 1)){
                    $mess = "Gelieve een geldige tekst op te geven!";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }elseif($type == "postcode"){
                $tonum = (int)$toTest;
                if($tonum < 1000 || $tonum > 9999){
                    $mess = "Postcode moet tussen 1000 en 9999 liggen!";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }elseif($type =="email"){
                //print("<br />");
                //print(strpos($toTest,"@"));
                if(!strpos($toTest,"@")){
                    //print("email nok");
                    $mess = "email oncorrect";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }elseif($type == "telefoon"){
                $toTest = str_replace(array(".","/"," "), "",$toTest);
                //print($toTest);
                if(!is_numeric($toTest)){
                    //print("geen nummer!");
                    $mess = "Geen geldig telefoon nummer!";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }elseif($type == "gebrnaam"){
                if(!(strlen($toTest) >= 6)){
                    $mess = "Gebruikersnaam niet lang genoeg, min 6 letters.";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }elseif($type == "pass"){
                //print("passing");
                if(!(strlen($toTest) >= 8)){
                    $mess = "Wachtwoord niet lang genoeg, min 8 letters.";
                    array_push($errArr, new ErrorMessage($iden, $mess));
                }
            }
        }
        
        return $errArr;
    }
    
    public static function ValidatePasswords($toTest1, $toTest2, $iden1, $iden2, $errArr){
        
    }
}
?>