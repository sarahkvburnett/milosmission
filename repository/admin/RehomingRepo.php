<?php


namespace app\repository\admin;



use app\repository\abstracts\AdminGroupAnimalRepo;

class RehomingRepo extends AdminGroupAnimalRepo {

    public function setSelectColumns(){
        parent::setSelectColumns();
        $this->selectColumns .= ", CONCAT(owners.owner_firstname, ' ', owners.owner_lastname) AS owner_name";
    }

    public function findAll($condition) {
        $data = $this->db->select($this->selectColumns)->join('owners', 'owner_id')->where($condition)->findAll();
        foreach ($data as $key=>$val) {
            $data[$key]['animals'] = $this->toArray($data[$key]['animals']);
        }
        return $data;
    }

    public function findOne($id) {
        $data = $this->db->select($this->selectColumns)->join('owners', 'owner_id')->where($this->idColumn, $id)->findOne();
        $data['animals'] = $this->toArray($data['animals']);
        return $data;
    }


}
