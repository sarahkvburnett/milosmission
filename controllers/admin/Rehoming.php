<?php


namespace app\controllers\admin;


use app\controllers\abstracts\AdminGroupAnimals;
use app\database\Database;
use app\Router;

class Rehoming extends AdminGroupAnimals {

    //todo need to add animal(s)

    public function __construct() {
        parent::__construct();
        $this->columns[] = "CONCAT(owners.owner_firstname, ' ', owners.owner_lastname) AS owner_name";
    }

    function setClass() {
        $this->class = 'Rehoming';
    }

    function setTable() {
        $this->table = 'rehomings';
    }

    protected function setBrowseData($search = []) {
        $db = Database::getInstance();
        $data = $db->select($this->table, $this->columns)->join('owners', 'owner_id')->where($search)->fetchAll();
        foreach ($data as $key=>$val) {
            $data[$key]['animals'] = $this->convertAnimalsToArray($data[$key]['animals']);
        }
        $this->addDataField('fields', $data);
    }

    protected function setExistingDetailsData() {
        $db = Database::getInstance();
        $data = $db->select($this->table, $this->columns)->join('owners', 'owner_id')->where([$this->getIdentifier(), $_GET['id']])->fetch();
        $data['animals'] = $this->convertAnimalsToArray($data['animals']);
        $this->addDataField('fields', $data);
    }

    public function save($router, $data){
        $data['rehoming_id'] = parent::save($router, $data);
        $this->changeAnimals($data, 'rehoming_id');
    }

    public function delete($router) {
        $this->removeAnimals('rehoming_id');
        parent::delete($router);
    }

}
