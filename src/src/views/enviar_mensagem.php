<?php
    session_start();
    require_once '../controller/MensagensController.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
        $mensagemController = new MensagensController();
        $mensagemController->criar($_POST['conversas_id'], $_SESSION['user_id'], $_POST['mensagem']);
        header('Location: chat.php?id=' . $_POST['conversas_id']);
        exit();
    }
    header('Location: chat.php');
?>