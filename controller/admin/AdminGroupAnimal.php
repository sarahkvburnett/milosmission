<?php


namespace app\controller\admin;


use app\classes\Request;
use app\database\Database;
use app\Router;

class AdminGroupAnimal extends Admin {

    public function save($data){
        $id = parent::save($data);
        $this->changeAnimals($data, $this->model->getIdColumn());
    }

    public function delete($router) {
        $this->removeAnimals($this->model->getIdColumn());
        parent::delete($router);
    }

    /**
     * Update relations between updating entry and existing animal(s) in db
     * @param $data - update data including updated animals
     * @param $idColumn - id column to select current animals for comparison
     */
    protected function changeAnimals($data, $idColumn) {
        if (!isset($data['animals'])) $data['animals'] = [];
        $id = $data[$idColumn];
        $newAnimalIds = $data['animals'];
        $currentAnimalIds = $this->repo->findAnimals($id);

        $animalsToRemove = array_filter($currentAnimalIds, fn($animal) => !in_array($animal, $newAnimalIds));
        $animalsToAdd = array_filter($newAnimalIds, fn($animal) => !in_array($animal, $currentAnimalIds));

        $this->repo->changeAnimals($id, $animalsToAdd, $animalsToRemove);
    }

    /**
     * Remove relation between updated entry and existing animal(s) in db
     * @param $idColumn - id of animal to have association removed
     */
    protected function removeAnimals($idColumn){
        $request = Request::getInstance();
        $id = $request->get('id');
        $this->repo->removeAnimals($id);
    }

}
