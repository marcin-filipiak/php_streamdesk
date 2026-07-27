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

include __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/DataModel.php';
require_once __DIR__ . '/../plugins/PluginManager.php';

class DashboardController {
    private $model;
    private $pluginManager;

    public function __construct() {
        $this->model = new DataModel(__DIR__ . '/../data.json');
        $this->pluginManager = new PluginManager(__DIR__ . '/../plugins');
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
        $pluginManager = $this->pluginManager;

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

