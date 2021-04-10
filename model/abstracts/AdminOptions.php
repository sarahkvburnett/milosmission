<?php


namespace app\model\abstracts;

use app\model\abstracts\Admin;

abstract class AdminOptions extends Admin implements iOptions {

    protected array $options;

    public function addOption($name, $data){
        $this->options[$name] = $data;
    }

    public function writeOptions($arr){
        $options = [];
        foreach ($arr as $item){
            $options[] = [
                'value' => $item,
                'label' => $item
            ];
        }
        return $options;
    }

    public function findOptions($table, $value, $label, $where = []){
        $options = [];
        $data = $this->repo->options($table, $where);
        if (empty($data)) return $options;
        foreach($data as $row){
            $options[] = [
                'value' => $row[$value],
                'label' => $row[$label]
            ];
        };
        return $options;
    }
}
