<?php


namespace app\controllers\admin;


use app\controllers\abstracts\AdminGroupAnimals;
use app\Router;

class Rehoming extends AdminGroupAnimals {

    //todo need to add animal(s)

    public function __construct($router) {
        parent::__construct($router);
        $this->addColumn("CONCAT(owners.owner_firstname, ' ', owners.owner_lastname) AS owner_name");
    }

    function setClass() {
        $this->class = 'Rehoming';
    }

    function setTable() {
        $this->table = 'rehomings';
    }

    protected function setBrowseData($router, $search = []) {
        $data = $router->db
            ->select($this->table, $this->columns)
            ->join('owners', 'owner_id')
            ->where($search)
            ->fetchAll();
        foreach ($data as $key=>$val) {
            $data[$key]['animals'] = $this->convertAnimalsToArray($data[$key]['animals']);
        }
        $this->addDataField('fields', $data);
    }

    protected function setExistingDetailsData($router) {
        $data = $router->db
            ->select($this->table, $this->columns)
            ->join('owners', 'owner_id')
            ->where([$this->nameIdColumn(), $_GET['id']])
            ->fetch();
        $data['animals'] = $this->convertAnimalsToArray($data['animals']);
        $this->addDataField('fields', $data);
    }

    public function save($router, $data){
        $data['rehoming_id'] = parent::save($router, $data);
        $this->changeAnimals($router, $data, 'rehoming_id');
    }

    public function delete($router) {
        $this->removeAnimals($router, 'rehoming_id');
        parent::delete($router);
    }

}
