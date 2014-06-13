<?php
//includes
require_once("pizza.class.php");
require_once("extra.class.php");
class Bestelregel {
    //put your code here
    private $product;
    private $aantal;
    private $subtotaal;
    
    function __construct() {
    }
    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
    }

    public function getAantal() {
        return $this->aantal;
    }

    public function setAantal($aantal) {
        $this->aantal = $aantal;
    }

    public function getSubtotaal() {
        return $this->subtotaal;
    }

    public function setSubtotaal() {
        $this->subtotaal = ($this->getProduct()->getBasisPrijs() - $this->getProduct()->getKorting()) * $this->getAantal();
    }
}

?>
