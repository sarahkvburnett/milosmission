<?php


namespace app\models;

use app\models\abstracts\Options;

class Media extends Options {

    protected string $table = 'media';
    protected string $idColumn = 'media_id';
    protected string $className = 'Media';
    protected string $name = 'media';

    function setRules(){
        $this->rules = [
           'media_filename' => ['required' => "Please add a file"],
           'media_type' => ['required' => "Please indicate the filetype"],
           'media_category' => ['required' => "Please indicate the category"],
           'media_subcategory' => ['required' => "Please indicate the subcategory"]
        ];
    }

    function setLabels() {
       $this->labels = [
           "media_id" => "ID",
           "media_filename" => "Filename",
           "media_type" => "Type",
           "media_category" => "Category",
           "media_subcategory" => "Subcategory",
           "preview" => "Preview"
       ];
    }

    function setColumns() {
        $this->columns = [
            "media_id", "media_filename", "media_type", "media_category", "media_subcategory", "preview"
        ];
    }

    function setTypes() {
        $this->types = [
            'media_id' => "hidden",
            'media_filename' =>  "file",
            'media_type' => "select",
        ];
    }

    function setSearchables() {
        $this->searchables = [
            'media_id', 'media_filename', 'media_type', 'media_category', 'media_subcategory'
        ];
    }

    function setOptions() {
        $this->addOption('media_type', $this->writeOptions(['Image', 'Video']));
        $this->addOption('media_category', $this->writeOptions(['Animal']));
        $this->addOption('media_subcategory', $this->fetchOptions('animals', 'animal_name', 'animal_name'));
    }

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
