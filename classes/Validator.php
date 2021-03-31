<?php


namespace app\classes;


use Exception;

class Validator {
    public function __construct($fields = []) {
        if (empty($fields)) throw new Exception('No data to validate', 400);
        $this->fields = $fields;
    }


    /**
     * Sanitise input
     * @return $this
     */
    public function sanitise(){
        $sanitisedFields = [];
        foreach($this->fields as $field => $value){
            //todo deal with array error;
            if (!is_array($value)) $sanitisedFields[$field] = htmlspecialchars(trim($value));
        }
        $this->fields = $sanitisedFields;
        return $this;
    }

    /**
     * Validate fields
     * @param $allrules
     * @return $this
     * @throws FailedValidation
     */
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
                        break;
                        //todo add validation options - required, email, password, match pattern but also like something that can't have one field if diff one is present
                    case 'default':
                        break;
                }
            }
        }
        if (!empty($errors)) throw new FailedValidation($errors);
        return $this;
    }

    /**
     * Return sanitised fields on model
     */
    public function getFields(){
        $page = Page::getInstance();
        $model = $page->describe();
        $fields = [];
        foreach ($model as $key => $value){
            if (isset($this->fields[$key])) {
                $fields[$key] = $this->fields[$key];
            }
        }
        return $fields;
    }

}
