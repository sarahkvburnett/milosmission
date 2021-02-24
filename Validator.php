<?php


namespace app;


class Validator {
    public function __construct($fields) {
        //for each set this
    }

    public static function sanitise(string $value){
        return htmlspecialchars(trim($value));
    }

    public static function sanitiseAll(array $fields){
        $sanitisedFields = [];
        foreach($fields as $field => $value){
            //todo deal with array error;
            if (!is_array($value)) $sanitisedFields[$field] = self::sanitise($value);
        }
        return $sanitisedFields;
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
