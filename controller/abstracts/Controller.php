<?php


namespace app\controller\abstracts;


use app\classes\Page;
use app\classes\Request;
use app\model\abstracts\iModel;
use app\repository\abstracts\iRepo;

abstract class Controller implements iController {

    protected ?iRepo $repo;
    protected ?iModel $model;

    /**
     * Constructor.
     * @param $repo
     */
    public function __construct($repo){
        $this->repo = $repo;
        $this->model = Page::getInstance()->getModel();
        if (!empty($this->model)) $this->setModelData();
    }

    /**
     * Get accumulated vars to send to template
     * @return array
     */
    public function getData() {
        $array = get_object_vars($this);
        unset($array['repo']);
        unset($array['model']);
        return $array;
    }

    /**
     * Add fields from model to vars
     */
    protected function setModelData(){
        $data = $this->model->getData();
        foreach ($data as $key => $value){
            $this->$key = $value;
        }
    }

}
