<?php
//includes
require_once("gebruiker.class.php");

class Klant extends Gebruiker {
    //put your code here
    private $naam;
    private $vnaam;
    private $adres;
    private $postcode;
    private $gemeente;
    private $btwNr;
    private $telefoon;
    private $email;
    private $pizzaTeller;
    private $opmerkingen;
    private $isBlocked;
    private $klantId;
    
    function __construct($id, $login, $pw,$klantId, $naam, $vnaam, $adres, $postcode, $gemeente, $pizzaTeller, $isBlocked) {
        parent::__construct($id, $login, $pw);
        $this->klantId = $klantId;
        $this->naam = $naam;
        $this->vnaam = $vnaam;
        $this->adres = $adres;
        $this->postcode = $postcode;
        $this->gemeente = $gemeente;
        $this->pizzaTeller = $pizzaTeller;
        $this->isBlocked = $isBlocked;
    }
    
    public function getNaam() {
        return $this->naam;
    }

    public function getVnaam() {
        return $this->vnaam;
    }

    public function getAdres() {
        return $this->adres;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function getGemeente() {
        return $this->gemeente;
    }

    public function getBtwNr() {
        return $this->btwNr;
    }

    public function getTelefoon() {
        return $this->telefoon;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPizzaTeller() {
        return $this->pizzaTeller;
    }

    public function getOpmerkingen() {
        return $this->opmerkingen;
    }

    public function getIsBlocked() {
        return $this->isBlocked;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function setVnaam($vnaam) {
        $this->vnaam = $vnaam;
    }

    public function setAdres($adres) {
        $this->adres = $adres;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function setGemeente($gemeente) {
        $this->gemeente = $gemeente;
    }

    public function setBtwNr($btwNr) {
        $this->btwNr = $btwNr;
    }

    public function setTelefoon($telefoon) {
        $this->telefoon = $telefoon;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPizzaTeller($pizzaTeller) {
        $this->pizzaTeller = $pizzaTeller;
    }

    public function setOpmerkingen($opmerkingen) {
        $this->opmerkingen = $opmerkingen;
    }

    public function setIsBlocked($isBlocked) {
        $this->isBlocked = $isBlocked;
    }
    
    public function getKlantId() {
        return $this->klantId;
    }
}
?>