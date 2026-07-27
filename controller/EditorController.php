<?php

include __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/EditorModel.php';
require_once __DIR__ . '/../plugins/PluginManager.php';

class EditorController {

    private $model;
    private $pluginManager;

    public function __construct() {
        session_start();
        $this->model = new EditorModel(__DIR__ . '/../data.json');
        $this->pluginManager = new PluginManager(__DIR__ . '/../plugins');
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';

        if ($action === 'save') {
            $this->save();
        } elseif ($action === 'logout') {
            $this->logout();
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
        $plugins = $this->pluginManager->getAll();

        include __DIR__ . '/../view/editor.php';
    }

    private function save() {
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            header("Location: index.php?op=editor");
            exit;
        }

        $json = $_POST['json'] ?? '';
        $decoded = json_decode($json, true);
        $logged = true;
        $plugins = $this->pluginManager->getAll();

        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            $error = 'Nieprawidłowy format JSON. Sprawdź składnię i spróbuj ponownie.';
            $jsonContent = $json;
            include __DIR__ . '/../view/editor.php';
            return;
        }

        if (!isset($decoded['media']) || !is_array($decoded['media'])) {
            $error = 'JSON musi zawierać klucz "media" z tablicą kategorii.';
            $jsonContent = $json;
            include __DIR__ . '/../view/editor.php';
            return;
        }

        $result = $this->model->saveJson($json);

        if ($result === false) {
            $error = 'Błąd zapisu do pliku data.json. Sprawdź uprawnienia.';
            $jsonContent = $json;
            include __DIR__ . '/../view/editor.php';
            return;
        }

        header("Location: index.php?op=index");
        exit;
    }

    private function logout() {
        unset($_SESSION['logged']);
        header("Location: index.php");
        exit;
    }

}
