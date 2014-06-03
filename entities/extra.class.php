<?php
//includes
require_once("/entities/product.class.php");
class Extra extends Product {
    //put your code here
    //enkel toe te voegen bij pizza's
    function __construct($id, $naam, $basisPrijs){
        parent::__construct($id, $naam, $basisPrijs);
    }

}
?>