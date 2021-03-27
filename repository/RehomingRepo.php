<?php


namespace app\repository;


use app\repository\abstracts\Repository;

class RehomingRepo extends GroupAnimalRepo implements Repository {

    public function setTable(){
        $this->db->table('rehomings');
    }

    public function setIdColumn(){
        $this->idColumn = 'rehoming_id';
    }

    public function setSelectColumns(){
        $this->selectColumns = "t1.* (SELECT GROUP_CONCAT(t2.animal_name) FROM animals t2 WHERE t1.$this->idColumn = $this->idColumn) AS animals";
        $this->selectColumns .= "CONCAT(owners.owner_firstname, ' ', owners.owner_lastname) AS owner_name";
    }

}
