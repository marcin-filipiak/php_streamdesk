<?php
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

