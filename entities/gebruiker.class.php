<?php
//includes
class Gebruiker {
    //put your code here
    private $id;
    private $login;
    private $pw;
    
    function __construct($id, $login, $pw) {
        $this->login = $login;
        $this->pw = $pw;
        $this->$id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPw() {
        return $this->pw;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPw($pw) {
        $this->pw = $pw;
    }
    
    public function setId($id){
        $this->id = $id;
    }
}
?>