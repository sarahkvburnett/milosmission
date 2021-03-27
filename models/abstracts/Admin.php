<?php


namespace app\models\abstracts;


abstract class Admin extends Base {

    /**
     * Set counts
     */
    abstract function setCounts();

    /**
     * Add key/value pair to counts
     * @param string $name
     * @param int $count
     * @param string $url
     */
    protected function addCount($name, $count, $url){
        $this->counts[$name]['value'] = $count;
        $this->counts[$name]['url'] = $url;
    }

}
