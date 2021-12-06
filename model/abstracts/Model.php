<?php


namespace app\model\abstracts;


use app\classes\Page;

abstract class Model implements iModel {

    protected string $table;
    protected string $idColumn;
    protected string $name;

    public function getTable(){
        return $this->table;
    }

    public function getIdColumn(){
        return $this->idColumn;
    }

    public function getName(){
        return $this->name;
    }

    public function setData(){
        $this->repo = Page::getInstance()->getRepo();
        $this->callSetters();
    }

    public function getData(){
        $this->setData();
        return get_object_vars($this);
    }

    public function getSetters(){
        $methods = get_class_methods($this);
        $setters = [];
        foreach ($methods as $method){
            if (substr( $method, 0, 3 ) === "set" && $method !== 'setData'){
                $setters[] = $method;
            }
        }
       return $setters;
    }

    public function callSetters(){
        $setters = $this->getSetters();
        //need to call setActions before setCounts
        if (in_array('setActions', $setters)) {
            $this->setActions();
        }
        foreach ($setters as $setter){
            if ($setter !== 'setActions') $this->$setter();
        }
    }
}
