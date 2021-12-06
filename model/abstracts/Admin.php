<?php


namespace app\model\abstracts;


use app\classes\Page;

abstract class Admin extends Model implements iAdminModel {

    protected string $className;

    protected array $actions;
    protected array $rules;
    protected array $types;
    protected array $searchables;
    protected array $labels;
    protected array $columns;
    protected array $counts;
    protected array $menu;

    public function setMenu(){
        $this->menu = $this->repo->findMenu('adminMain');
    }

    public function setActions(){
        $name = $this->name;
        $this->actions['browse'] = '/admin/'.$name."/browse";
        $this->actions['details'] = '/admin/'.$name.'/details';
        $this->actions['delete'] = '/admin/'.$name.'/delete';
    }

}
