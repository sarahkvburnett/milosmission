<?php


namespace app\abstracts\repository;


use app\database\Database;
use app\database\Adaptor\interfaces\Adaptor;
use app\pages\Page;
use app\repository\abstracts\Repository;

class AdminRepo implements Repository {

    protected Adaptor $db;

    protected string $table;
    protected string $idColumn;

    public function __construct($dbConnections){
        $this->db = $dbConnections['mysql'];
        $page = Page::getInstance();
        $this->idColumn = $page->getIdColumn();
        $this->table = $page->getTable();
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
        $this->db->update($model)->where($this->idColumn, $id);
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

    public function option($table, $where){
        return $this->db->select()->from($table)->where($where)->findAll();
    }

    public function count($condition){
        $data = $this->db->count($this->idColumn)->where($condition);
        return $data["COUNT($this->idColumn)"];
    }

    //HELPER METHODS

    protected function toArray($data){
        if (!isset($data)) return [];
        return explode(",", $data);
    }

}
