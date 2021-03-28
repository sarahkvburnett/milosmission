<?php


namespace app\repository\abstracts;


use app\database\QueryBuilder\PDO_MYSQL;
use app\classes\Page;
use MongoDB\Driver\Query;

class SQLRepo implements iRepo {

    protected PDO_MYSQL $db;

    protected string $table;
    protected string $idColumn;

    public function __construct($dbConnections){
        $this->setQueryBuilder($dbConnections);
        $page = Page::getInstance();
        $page->setModel();
        $this->idColumn = $page->getIdColumn();
        $this->db->table($page->getTable());
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

    public function options($table, $where){
        return $this->db->select()->from($table)->where($where)->findAll();
    }

    public function count($column = null, $where = null){
        $data = $this->db->count($this->idColumn)->where($column, $where)->findAll();
        return $data["COUNT($this->idColumn)"];
    }

    //HELPER METHODS

    protected function toArray($data){
        if (!isset($data)) return [];
        return explode(",", $data);
    }

    public function setQueryBuilder($dbConnections){
        $this->db = new PDO_MYSQL($dbConnections->get('mysql'));
    }

}
