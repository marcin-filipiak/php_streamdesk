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

$op = $_GET['op'] ?? 'index';

switch ($op) {
    case 'editor':
        require_once __DIR__ . '/controller/EditorController.php';
        $controller = new EditorController();
        break;

    default:
        require_once __DIR__ . '/controller/DashboardController.php';
        $controller = new DashboardController();
        break;
}

$controller->handleRequest();
?>
