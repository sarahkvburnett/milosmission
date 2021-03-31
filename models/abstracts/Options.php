<?php


namespace app\models\abstracts;

use app\models\abstracts\Model;

abstract class Options extends Model {

    protected array $options;

    public function setData() {
        parent::setData();
        $this->setOptions();
    }

    /**
     * Add option to list of options
     * @param string $name
     * @param array $data - array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
    protected function addOption($name, $data){
        $this->options[$name] = $data;
    }

    /**
     * Option list manually written in and not from db fields
     * @param $arr - required option list
     * @return array $data -  array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
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

    /**
     * Fetch possible options from entries in db
     * @param $table - name of db table
     * @param $value - name of column to be used as value
     * @param $label - name of column to be used as label
     * @param array $where - condition to limit option from db
     * @return array $data - array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
    protected function findOptions($table, $value, $label, $where = []){
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
