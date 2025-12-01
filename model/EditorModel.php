<?php
/**
 * StreamDesk – JSON Editor Model
 * MIT License – Author: Marcin Filipiak
 */

class EditorModel {

    private $jsonFile;

    public function __construct($file) {
        $this->jsonFile = $file;
    }

    public function loadJson() {
        if (!file_exists($this->jsonFile)) {
            return '';
        }
        return file_get_contents($this->jsonFile);
    }

    public function saveJson($content) {
        return file_put_contents($this->jsonFile, $content);
    }
}
?>
