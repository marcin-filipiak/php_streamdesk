<?php
/**
 * StreamDesk – Content Aggregator
 * 
 * Open source project under MIT License.
 * Author: Marcin Filipiak
 * 
 * Description: A universal content aggregator that displays images, videos, YouTube videos,
 * and embedded pages in a responsive card grid layout.
 */
 
class DataModel {
    private $data = [];

    public function __construct($jsonFile) {
        if (file_exists($jsonFile)) {
            $this->data = json_decode(file_get_contents($jsonFile), true) ?: [];
        }
    }

    public function getLinks() {
        return $this->data['links'] ?? [];
    }

    public function getMedia() {
        return $this->data['media'] ?? [];
    }
}

