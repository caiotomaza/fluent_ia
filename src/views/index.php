<?php
    require_once __DIR__ . '/../controllers/api_control.php';

    $controller = new api_control();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->enviarMensagem();
    } else {
        $resposta = null;
        include __DIR__ . '/teste.php';
    }
?>