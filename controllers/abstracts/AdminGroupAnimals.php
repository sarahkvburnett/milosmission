<?php


namespace app\controllers\abstracts;


abstract class AdminGroupAnimals extends Admin {

    protected $browseColumns;

    public function __construct($router) {
        parent::__construct($router);
        $this->setBrowseColumns();
    }

    private function addGroupConcatColumn($originColumn, $joinTable){
        return '(SELECT GROUP_CONCAT(t2.'.$originColumn.') FROM '.$joinTable.' t2 WHERE t1.'.$this->class.'_id = t2.'.$this->class.'_id) AS '.$joinTable.'';
    }

    private function addAnimalGroupConcatColumn(){
        return $this->addGroupConcatColumn('animal_name', 'animals');
    }

    private function setBrowseColumns(){
        $this->browseColumns = ['t1.*', $this->addAnimalGroupConcatColumn()];
    }

    public function addBrowseColumn($column){
        $this->browseColumns[] = $column;
    }

    protected function setBrowseData($router, $search = []) {
        $this->addDataField(
            'fields',
            $router->db
                ->select($this->table, $this->browseColumns)
                ->where($search)
                ->fetchAll()
        );
    }

}
