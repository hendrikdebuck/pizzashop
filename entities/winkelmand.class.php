<?php
//includes
require_once("entities/pizza.class.php");

class Winkelmand{
    private $producten = array();
    private $klant;
    private $besteld;
    private $gewenst;
    private $extraKorting;
    private $id;
    
    function __construct() {
    }
    
    public function getProducten() {
        return $this->producten;
    }

    public function getKlant() {
        return $this->klant;
    }

    public function getBesteld() {
        return $this->besteld;
    }

    public function getGewenst() {
        return $this->gewenst;
    }

    public function getExtraKorting() {
        return $this->extraKorting;
    }

    public function getId() {
        return $this->id;
    }
    public function setProducten($producten) {
        $this->producten = $producten;
    }

    public function setBesteld($besteld) {
        $this->besteld = $besteld;
    }

    public function setGewenst($gewenst) {
        $this->gewenst = $gewenst;
    }

    public function setExtraKorting($extraKorting) {
        $this->extraKorting = $extraKorting;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function setKlant($klant) {
        $this->klant = $klant;
    }
    
    public function voegProductToe($product){
        $temp = $this->getProducten();
        array_push($temp, $product);
        $this->setProducten($temp);
    }
}
?>