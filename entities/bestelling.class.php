<?php
//includes
require_once("klant.class.php");
require_once("product.class.php");
class Bestelling {
    //put your code here
    private $id;
    private $klant;
    private $status; //besteld, klaargemaakt, geleverd, ...
    private $tijdBesteld;
    private $tijdGewenst;
    private $extraKorting; //eventueel volle klantenkaart, etc
    private $arrProducten = array();
    
    function __construct($id, $klant, $tijdBesteld) {
        $this->id = $id;
        $this->klant = $klant;
        $this->tijdBesteld = $tijdBesteld;
    }

    public function getId() {
        return $this->id;
    }

    public function getKlant() {
        return $this->klant;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTijdBesteld() {
        return $this->tijdBesteld;
    }

    public function getTijdGewenst() {
        return $this->tijdGewenst;
    }

    public function getExtraKorting() {
        return $this->extraKorting;
    }

    public function getArrProducten() {
        return $this->arrProducten;
    }

    public function setKlant($klant) {
        $this->klant = $klant;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setTijdGewenst($tijdGewenst) {
        $this->tijdGewenst = $tijdGewenst;
    }

    public function setExtraKorting($extraKorting) {
        $this->extraKorting = $extraKorting;
    }

    public function setArrProducten($arrProducten) {
        $this->arrProducten = $arrProducten;
    }
}
?>