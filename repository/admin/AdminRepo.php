<?php


namespace app\repository\admin;

use app\classes\Page;
use app\repository\abstracts\iAdminRepo;
use app\repository\abstracts\Repo;

class AdminRepo extends Repo implements iAdminRepo {

    protected string $idColumn;

    public function __construct(){
        $this->init('PDO_MYSQL', 'mysql');
        $model = Page::getInstance()->getModel();
        $this->setIDColumn($model->getIdColumn());
        $this->setTable($model->getTable());
    }

    public function findOne($id){
        return $this->db->select()->where($this->idColumn, $id)->findOne();
    }

    public function findAll($where){
        return $this->db->select()->where($where)->findAll();
    }

    public function create($model) {
        $this->db->insert($model)->save();
        return $this->db->lastInsertId();
    }

    public function update($id, $model){
        $this->db->update($model)->where($this->idColumn, $id)->save();
        return $id;
    }

    public function delete($id){
        $this->db->delete($id)->save();
    }

    public function describe() {
        $data = $this->db->describe()->findAll();
        $fields = [];
        foreach ($data as $item){
            $fields[$item['Field']] = '';
        }
        return $fields;
    }

    public function options($table, $where){
        return $this->db->select()->from($table)->where($where)->findAll();
    }

    public function count($column = null, $where = null){
        $data = $this->db->count($this->idColumn)->where($column, $where)->findOne();
        return $data["COUNT($this->idColumn)"];
    }


    //HELPER METHODS

    protected function toArray($data){
        if (!isset($data)) return [];
        return explode(",", $data);
    }

    public function setIDColumn($column){
        $this->idColumn = $column;
    }

}
