<?php


namespace app;


use Exception;

class Validator {
    public function __construct($fields = []) {
        if (!empty($fields)) throw new Exception('No data to validate', 400);
        foreach ($fields as $field => $value){
            $this->$field = $value;
        }
    }

    public function sanitise(string $value){
        return htmlspecialchars(trim($value));
    }

    public function sanitiseAll(){
        $sanitisedFields = [];
        foreach($this->fields as $field => $value){
            //todo deal with array error;
            if (!is_array($value)) $sanitisedFields[$field] = self::sanitise($value);
        }
        return $sanitisedFields;
    }

    public function validate($allrules) {
        $errors = [];
        foreach ($allrules as $field => $rules) {
            $value = null;
            if (isset($this->fields[$field])) $value = $this->fields[$field];
            foreach($rules as $rule => $msg){
                //if rule has colon in it -> split the key into rule and pattern;
                switch($rule){
                    case 'required':
                        if (!$value) $errors[] = $msg;
                }
            }
        }
        if (!empty($errors)) throw new FailedValidation($errors);
        return $this;
    }

    public ?array $_validateConstraints = [
        'field' => 'method1|method2|method3',
    ];

    // $array[0] = field name
//    // $array[1] = | separated list of methods / constraints
//    public function validate($validateArray, special){
//        $errors = [];
//        foreach($validateArray as $field => $methods){
//            $array = explode('|', $methods);
//            foreach($array as $method){
//                $x = strpos($method, '(');
//                if ($x !== false){
//                        //
//
//                 }
//            }
//        }
//        return $errors;
//    }
//
//
//    //need to be able to put in a method with args and call the method with those args

    //TODO: validation methods e.g.
    public function required($value){

    }

    public function email($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    //required, email, date, status, postcode, matches()

    protected function matches($value, $str){
        return $value === $str;
    }

    public static function convertStrToInt($value){
        return intval($value);
    }






}
