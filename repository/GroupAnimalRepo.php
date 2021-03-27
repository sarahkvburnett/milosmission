<?php


namespace app\repository;


use app\abstracts\repository\AdminRepo;

class GroupAnimalRepo extends AdminRepo {

    protected string $selectColumns;

    public function __construct($dbConnections) {
        parent::__construct($dbConnections);
        $this->setSelectColumns();
    }

    public function setSelectColumns(){
        $this->selectColumns = "t1.* (SELECT GROUP_CONCAT(t2.animal_name) FROM animals t2 WHERE t1.$this->idColumn = $this->idColumn) AS animals";
    }

    public function findAll($condition) {
        $data = $this->db->select($this->selectColumns)->where($condition)->findOne();
        foreach ($data as $key=>$val) {
            $data[$key]['animals'] = $this->toArray($data[$key]['animals']);
        }
        return $data;
    }

    public function findOne($id) {
        $data = $this->db->select($this->selectColumns)->where($this->idColumn, $id)->findOne();
        $data['animals'] = $this->toArray($data['animals']);
        return $data;
    }


    public function describe(){
        $data = parent::describe();
        $data['animals'] = [];
        return $data;
    }

    public function findAnimals($id){
        $column = 'GROUP_CONCAT(animal_id)';
        $data = $this->db->select($column)->where($this->idColumn, $id)->findOne();
        return $this->toArray($data[$column]);
    }

    public function changeAnimals($id, $animalsToAdd, $animalsToRemove) {
        foreach($animalsToAdd as $animalId){
            $this->db->table('animals')->update([$this->idColumn => $id])->where('animal_id', $animalId)->save();
            $this->setTable();
        }

        foreach($animalsToRemove as $animalId){
            $this->db->table('animals')->update([$this->idColumn => NULL])->where('animal_id', $animalId)->save();
            $this->setTable();
        }
    }

    public function removeAnimals($id){
        $$this->db->table('animals')->update([$this->idColumn => NULL])->where($this->idColumn, $id)->save();
    }


}
