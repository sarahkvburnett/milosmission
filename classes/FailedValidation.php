<?php


namespace app\classes;


use Exception;
use Throwable;

class FailedValidation extends Exception {

    protected array $errors;

    public function __construct($errors) {
        parent::__construct("Errors in response", 400, null);
        $this->errors = $errors;
    }

    public function getErrors(){
        return $this->errors;
    }

}
