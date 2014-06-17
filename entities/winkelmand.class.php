<?php
//includes
require_once("bestelregel.class.php");

class Winkelmand{
    private $bestelregelArr = array();
    private $klant;
    private $besteld;
    private $gewenst;
    private $extraKorting;
    private $id;
    private $status;
    
    function __construct() {
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
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    public function voegBestelregelToe($nieuweRegel){
        //check of hetzelfe product bestaat in een andere bestelregel
        //indien niet, maak nieuwe bestelregel
        $exists = false;
        $temp = $this->getBestelregelArr();
        
        foreach ($temp as $regel){
            if(!$exists){
                if($regel->getProduct() == $nieuweRegel->getProduct()){
                    print("hetzelfde product!");
                    $regel->setAantal($regel->getAantal() + $nieuweRegel->getAantal());
                    $regel->setSubtotaal();
                    $exists = true;
                }
            }
        }
        
        if(!$exists){
        //nieuwe regel
            array_push($temp, $nieuweRegel);
        }
        $this->setBestelregelArr($temp);
    }
    
    public function verwijderBestelregel($arrIndex){
        $temp = $this->getBestelregelArr();
        unset($temp[$arrIndex]);
        $temp = array_values($temp);
        $this->setBestelregelArr($temp);
    }
            
    public function getBestelregelArr() {
        return $this->bestelregelArr;
    }

    public function setBestelregelArr($bestelregelArr) {
        $this->bestelregelArr = $bestelregelArr;
    }
    
    public function getTotaal(){
        $totaal = 0;
        foreach($this->getBestelregelArr() as $regel){
            $totaal += $regel->getSubtotaal();
        }
        return $totaal;
    }
}
?>