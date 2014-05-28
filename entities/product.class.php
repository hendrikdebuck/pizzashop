<?php
//includes
class Product {
    //put your code here
    private $id;
    private $naam;
    private $omschrijving;
    private $basisPrijs;
    private $isActief; //wordt dit product momenteel verkocht
    private $korting; //huidige toegekende korting voor dit product
    private $catId;
    private $catOmschrijving;
    
    function __construct($id, $naam, $basisPrijs) {
        $this->id = $id;
        $this->naam = $naam;
        $this->basisPrijs = $basisPrijs;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function getOmschrijving() {
        return $this->omschrijving;
    }

    public function getBasisPrijs() {
        return $this->basisPrijs;
    }

    public function getIsActief() {
        return $this->isActief;
    }

    public function getKorting() {
        return $this->korting;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function setOmschrijving($omschrijving) {
        $this->omschrijving = $omschrijving;
    }

    public function setBasisPrijs($basisPrijs) {
        $this->basisPrijs = $basisPrijs;
    }

    public function setIsActief($isActief) {
        $this->isActief = $isActief;
    }

    public function setKorting($korting) {
        $this->korting = $korting;
    }
    
    public function getCatId() {
        return $this->catId;
    }

    public function setCatId($catId) {
        $this->catId = $catId;
    }

    public function getCatOmschrijving() {
        return $this->catOmschrijving;
    }

    public function setCatOmschrijving($catOmschrijving) {
        $this->catOmschrijving = $catOmschrijving;
    }
}
?>