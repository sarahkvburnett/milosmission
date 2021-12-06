<?php


namespace app\classes;


class Route {

    public function __construct($arr){
        foreach($arr as $key => $value){
            $this->$key = $value;
        }
    }

    public function __get($prop){
        return $this->$prop;
    }

}
