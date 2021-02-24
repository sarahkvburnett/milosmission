<?php


namespace app\controllers\abstracts;


use app\Router;

abstract class AdminGroupAnimals extends Admin {

    protected $columns;

    public function __construct($router) {
        parent::__construct($router);
        $this->setColumns();
    }

    protected function addAnimalGroupConcatColumn(){
        return $this->addGroupConcatColumn('animal_name', 'animals');
    }

    protected function setColumns(){
        $this->columns = ['t1.*', $this->addAnimalGroupConcatColumn()];
    }

    public function addColumn($column){
        $this->columns[] = $column;
    }

    protected function setBrowseData($router, $search = []) {
        $data = $router->db
            ->select($this->table, $this->columns)
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
            ->where([$this->nameIdColumn(), $_GET['id']])
            ->fetch();
        $data['animals'] = $this->convertAnimalsToArray($data['animals']);
        $this->addDataField('fields', $data);
    }

    protected function setNewDetailsData($router) {
        parent::setNewDetailsData($router);
        $this->data['fields']['animals'] = [];
    }

    protected function convertAnimalsToArray($animals){
        if (!isset($animals)) return [];
        return explode(",", $animals);
    }

    /**
     * @param Router $router
     * @param $data
     */
    protected function changeAnimals($router, $data, $idColumn) {
        if (!isset($data['animals'])) $data['animals'] = [];
        $idValue = $data[$idColumn];
        $newAnimalIds = $data['animals'];
        $currentAnimalIdStr = $router->db->select('animals', ['GROUP_CONCAT(animal_id)'])->where([$idColumn, $idValue])->fetch();
        $currentAnimalIds = $this->convertAnimalsToArray($currentAnimalIdStr['GROUP_CONCAT(animal_id)']);

        $animalsToRemove = array_filter($currentAnimalIds, fn($animal) => !in_array($animal, $newAnimalIds));
        $animalsToAdd = array_filter($newAnimalIds, fn($animal) => !in_array($animal, $currentAnimalIds));

        foreach ($animalsToAdd as $animalId){
            $data = [$idColumn => $idValue];
            $router->db->update('animals', $data)->where(['animal_id', $animalId])->execute();
        }

        foreach($animalsToRemove as $animalId){
            $data = [$idColumn => NULL];
            $router->db->update('animals', $data)->where(['animal_id', $animalId])->execute();
        }
    }

    /**
     * @param Router $router
     */
    protected function removeAnimals($router, $idColumn){
        $idValue = $_POST['id'];
        $data = [$idColumn => NULL];
        $router->db->update('animals', $data)->where([$idColumn, $idValue])->execute();
    }

}
