<?php


namespace app\models\abstracts;

use app\database\Database;

interface iModel {

    /**
     * Set validation rules
     */
    function setRules();

    /**
     * Set labels for the view form elements
     */
    function setLabels();

    /**
     * Set required columns for the view table (in order)
     */
    function setColumns();

    /**
     * Set types for the view form elements
     */
    function setTypes();

    /**
     * Set the fields to be searchable in search form
     */
    function setSearchables();


    /**
     * Set counts
     */
    function setCounts();


}
