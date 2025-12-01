<?php
/**
 * StreamDesk – Editor Controller
 * MIT License – Author: Marcin Filipiak 
 */

include __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/EditorModel.php';

class EditorController {

    private $model;

    public function __construct() {
        session_start();
        $this->model = new EditorModel(__DIR__ . '/../data.json');
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';

        if ($action === 'save') {
            $this->save();
        } else {
            $this->index();
        }
    }

    private function index() {
        $logged = isset($_SESSION['logged']) && $_SESSION['logged'] === true;
        $error = '';

        if (!$logged && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            if ($password === EDITOR_PASSWORD) {
                $_SESSION['logged'] = true;
                $logged = true;
            } else {
                $error = 'Nieprawidłowe hasło.';
            }
        }

        $jsonContent = $logged ? $this->model->loadJson() : '';

        include __DIR__ . '/../view/editor.php';
    }

    private function save() {
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            header("Location: index.php?op=editor");
            exit;
        }

        $json = $_POST['json'] ?? '';

        $this->model->saveJson($json);

        header("Location: index.php?op=index");
        exit;
    }
}

