<?php


namespace app\model\abstracts;


abstract class AdminOptionsCounts extends AdminOptions implements iCounts {

    public function setCounts(){
        $this->addCount('All', $this->actions['browse']);
    }

    public function addSearchCount($name, $column, $value){
        $this->counts[$name]['value'] = $this->repo->count($column, $value);
        $this->counts[$name]['url'] = "?searchValue=$value&searchColumn=$column";
    }

    public function addCount($name, $url){
        $this->counts[$name]['value'] = $this->repo->count();
        $this->counts[$name]['url'] = $url;
    }

}
