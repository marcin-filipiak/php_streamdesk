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
include __DIR__ . '/../config.php';

class DashboardController {
    private $model;
    private $defaultOffline = '/assets/img/offline.jpg';

    public function __construct() {
        $this->model = new DataModel(__DIR__ . '/../data.json');
    }

    public function handleRequest() {
        $op = $_GET['op'];

        switch ($op) {
            case 'index':
                $this->index();
                break;

            case 'viewimage':
                $this->viewImage();
                break;

            default: 
                $this->index();
                break;
        }
    }

    public function index() {
        $links = $this->model->getLinks();
        $media = $this->model->getMedia();

        include __DIR__ . '/../view/dashboard.php';
    }

    public function viewImage() {
        $img = $_GET['img'] ?? '';
        if (!$img) {
            header("Location: index.php?op=index");
            exit;
        }

        $this->imageUrl = $img;
        include __DIR__ . '/../view/image.php';
    }
}

