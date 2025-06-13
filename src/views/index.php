<?php
    require_once __DIR__ . '/../controllers/api_control.php';

    $controller = new api_control();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->enviarMensagem();
    } else {
        $mensagem = null;
        include __DIR__ . '/chat.php';
    }
?>