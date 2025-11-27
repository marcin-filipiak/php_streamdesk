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

require_once __DIR__ . '/../model/DataModel.php';
include('config.php');

class DashboardController {
    private $model;
    private $defaultOffline = '/assets/img/offline.jpg';

    public function __construct() {
        $this->model = new DataModel(__DIR__ . '/../data.json');
    }

    public function index() {
        $links = $this->model->getLinks();
        $media = $this->model->getMedia(); // zmiana nazwy zmiennej

        include __DIR__ . '/../view/dashboard.php';
    }
}

