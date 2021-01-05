<?php


namespace app;


class Validator {
    static public function sanitise($value){
        return htmlspecialchars(trim($value));
    }

    static public function sanitiseAll($fields){
        $sanitisedFields = [];
        foreach($fields as $field => $value){
            $sanitisedFields[$field] = self::sanitise($value);
        }
        return $sanitisedFields;
    }

    //TODO: validation methods e.g.
    public function checkEmail($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    static public function convertStrToInt($value){
        return intval($value);
    }

}
