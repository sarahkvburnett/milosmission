<?php


namespace app\models\viewmodels;

use app\models\viewmodels\abstracts\Options;

class Media extends Options {

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
}
