<?php


namespace app\controllers\abstracts;


use app\database\Database;
use app\Router;

abstract class AdminGroupAnimals extends Admin {

    /**
     * @var array - columns for select query
     */
    protected $columns;

    /**
     * AdminGroupAnimals constructor.
     * @throws \Exception
     */
    public function __construct() {
        parent::__construct();
        $this->columns = ['t1.*', $this->addAnimalGroupConcatColumn()];
    }

    /**
     * Specific add group contact column method for animal names
     * @return string
     */
    protected function addAnimalGroupConcatColumn(){
        return $this->addGroupConcatColumn('animal_name', 'animals');
    }

    protected function setBrowseData($search = []) {
        $db = Database::getInstance();
        $data = $db->select($this->table, $this->columns)->where($search)->fetchAll();
        foreach ($data as $key=>$val) {
            $data[$key]['animals'] = $this->convertAnimalsToArray($data[$key]['animals']);
        }
        $this->addDataField('fields', $data);
    }

    protected function setExistingDetailsData() {
        $db = Database::getInstance();
        $data = $db->select($this->table, $this->columns)->where([$this->getIdentifier(), $_GET['id']])->fetch();
        $data['animals'] = $this->convertAnimalsToArray($data['animals']);
        $this->addDataField('fields', $data);
    }

    protected function setNewDetailsData() {
        parent::setNewDetailsData();
        $this->data['fields']['animals'] = [];
    }

    /**
     * Convert animal group concat string to array
     * @param $animals
     * @return array
     */
    protected function convertAnimalsToArray($animals){
        if (!isset($animals)) return [];
        return explode(",", $animals);
    }

    /**
     * Update relations between updating entry and existing animal(s) in db
     * @param $data - update data including updated animals
     * @param $idColumn - id column to select current animals for comparison
     */
    protected function changeAnimals($data, $idColumn) {
        $db = Database::getInstance();
        if (!isset($data['animals'])) $data['animals'] = [];
        $idValue = $data[$idColumn];
        $newAnimalIds = $data['animals'];
        $currentAnimalIdStr = $db->select('animals', ['GROUP_CONCAT(animal_id)'])->where([$idColumn, $idValue])->fetch();
        $currentAnimalIds = $this->convertAnimalsToArray($currentAnimalIdStr['GROUP_CONCAT(animal_id)']);

        $animalsToRemove = array_filter($currentAnimalIds, fn($animal) => !in_array($animal, $newAnimalIds));
        $animalsToAdd = array_filter($newAnimalIds, fn($animal) => !in_array($animal, $currentAnimalIds));

        foreach ($animalsToAdd as $animalId){
            $data = [$idColumn => $idValue];
            $db->update('animals', $data)->where(['animal_id', $animalId])->execute();
        }

        foreach($animalsToRemove as $animalId){
            $data = [$idColumn => NULL];
            $db->update('animals', $data)->where(['animal_id', $animalId])->execute();
        }
    }

    /**
     * Remove relation between updated entry and existing animal(s) in db
     * @param $idColumn - id of animal to have association removed
     */
    protected function removeAnimals($idColumn){
        $idValue = $_POST['id'];
        $data = [$idColumn => NULL];
        $db = Database::getInstance();
        $db->update('animals', $data)->where([$idColumn, $idValue])->execute();
    }

}
