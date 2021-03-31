<?php


namespace app\models\abstracts;


use app\classes\Page;

abstract class Model implements iModel {

    protected string $table;
    protected string $idColumn;
    protected string $className;
    protected string $name;

    protected array $rules;
    protected array $types;
    protected array $searchables;
    protected array $labels;
    protected array $columns;
    protected array $counts;

    public function setData(){
        $page = Page::getInstance();
        $this->repo = $page->getRepo();
    }

    /**
     * Extract model data for request
     * @return array
     */
    public function getData(){
        $this->setData();
        $array = get_object_vars($this);
        foreach($array as $field => $value){
            if(strpos($field, '_') === 0){
                unset($array[$field])
                    ;
            }
        }
        return $array;
    }

    public function getTable(){
        return $this->table;
    }

    public function getIdColumn(){
        return $this->idColumn;
    }

    public function getName(){
        return $this->name;
    }


    /**
     * Add key/value pair to counts
     * @param string $name
     * @param int $count
     * @param string $url
     */
    protected function addCount($name, $count, $url){
        $this->counts[$name]['value'] = $count;
        $this->counts[$name]['url'] = $url;
    }

}
