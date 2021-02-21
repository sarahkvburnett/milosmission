<?php


namespace app\controllers\admin;


use app\controllers\abstracts\AdminGroupAnimals;

class Rehoming extends AdminGroupAnimals {

    //todo need to add animal(s)

    public function __construct($router) {
        parent::__construct($router);
        $this->addBrowseColumn("CONCAT(owners.owner_firstname, ' ', owners.owner_lastname) AS owner_name");
    }

    function setClass() {
        $this->class = 'Rehoming';
    }

    function setTable() {
        $this->table = 'rehomings';
    }

    protected function setBrowseData($router, $search = []) {
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table, $this->browseColumns)
                ->join('owners', 'owner_id')
                ->where($search)
                ->fetchAll()
        );
    }

}
