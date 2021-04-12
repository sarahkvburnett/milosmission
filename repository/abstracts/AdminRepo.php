<?php


namespace app\repository\abstracts;

use app\classes\Page;
use app\database\QueryBuilder\abstracts\iQueryBuilder;
use app\database\QueryBuilder\PDO_MYSQL;

abstract class AdminRepo extends Repo implements iAdminRepo {

    protected iQueryBuilder $db;

    protected string $table;
    protected string $idColumn;

    public function __construct(){
        parent::__construct();
        $page = Page::getInstance();
        $this->idColumn = $page->getIdColumn();
        $this->db->table($page->getTable());
    }

    public function setQueryBuilder(){
        return new PDO_MYSQL($this->dbConnections->get('mysql'));
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

    //don't delete this - needed for when table changed
    public function setTable($table){
        $this->db->table($table);
    }

}
