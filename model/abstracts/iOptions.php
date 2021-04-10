<?php


namespace app\model\abstracts;


interface iOptions {

    public function setOptions();
    /**
     * Add option to list of options
     * @param string $name
     * @param array $data - array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
    public function addOption($name, $data);

    /**
     * Option list manually written in and not from db fields
     * @param $arr - required option list
     * @return array $data -  array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
    public function writeOptions($arr);

    /**
     * Fetch possible options from entries in db
     * @param $table - name of db table
     * @param $value - name of column to be used as value
     * @param $label - name of column to be used as label
     * @param array $where - condition to limit option from db
     * @return array $data - array of associative arrays each an option ['value' => $value, 'label' => $label]
     */
    public function findOptions($table, $value, $label, $where = []);

}
