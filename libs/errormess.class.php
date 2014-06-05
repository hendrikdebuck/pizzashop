<?php
//includes
class ErrorMessage{
    private $iden;
    private $message;
    
    function __construct($iden, $message) {
        $this->iden = $iden;
        $this->message = $message;
    }
    
    public function getIden() {
        return $this->iden;
    }

    public function setIden($iden) {
        $this->iden = $iden;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
}
?>