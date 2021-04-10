<?php


namespace app\model\abstracts;


use app\classes\Page;

abstract class Admin extends Model implements iAdminModel {

    protected string $table;
    protected string $idColumn;
    protected string $className;
    protected string $name;

    protected array $actions;
    protected array $rules;
    protected array $types;
    protected array $searchables;
    protected array $labels;
    protected array $columns;
    protected array $counts;

    public function getTable(){
        return $this->table;
    }

    public function getIdColumn(){
        return $this->idColumn;
    }

    public function getName(){
        return $this->name;
    }

    public function setActions(){
        $name = $this->name;
        $this->actions['browse'] = '/admin/'.$name."/browse";
        $this->actions['details'] = '/admin/'.$name.'/details';
        $this->actions['delete'] = '/admin/'.$name.'/delete';
    }

}
