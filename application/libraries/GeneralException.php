<?php

class GeneralException extends Exception {
    public $errorCode;
    public $errorMessage;
    public $errorType;
   
    function __construct($errorCode="",$errorMessage="", $errorType=""){
        $this->errorCode=$errorCode;
        $this->errorType=$errorType;
        $this->errorMessage=$errorMessage;
    }
}
?>