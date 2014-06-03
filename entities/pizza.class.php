<?php
//includes
require_once("product.class.php");
class Pizza extends Product {
    //put your code here
    private $arrExtras = array();
    
    function __construct($id, $naam, $basisPrijs){
        parent::__construct($id, $naam, $basisPrijs);
    }
    public function getArrExtras() {
        return $this->arrExtras;
    }
    public function setArrExtras($arrExtras) {
        $this->arrExtras = $arrExtras;
    }
    public function voegExtraToe($extra){
        $temp = $this->getArrExtras();
        array_push($temp, $extra);
        $this->setArrExtras($temp);
    }
}
?>