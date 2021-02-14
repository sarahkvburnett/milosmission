<?php


namespace app\models\viewmodels\abstracts;

use app\models\viewmodels\abstracts\Base;

abstract class Options extends Base {

    protected ?array $options;

    abstract function setOptions();

    protected function writeOptions($arr){
        $options = [];
        foreach ($arr as $item){
            $options[] = [
                'value' => $item,
                'label' => $item
            ];
        }
        return $options;
    }

    protected function fetchOptions($table, $value, $label, $where = []){
        $options = [];
        $options[] = [
            'value' => '',
            'label' => '-- Please select --'
        ];
        $data = $this->_db->select($table)->where($where)->fetchAll();
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
