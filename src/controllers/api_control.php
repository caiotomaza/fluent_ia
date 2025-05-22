<?php
    require_once __DIR__ . '/../model/api.php';

    class api_control {
        public function enviarMensagem() {
            if (isset($_POST['mensagem']) && !empty(trim($_POST['mensagem']))) {
                $mensagem = trim($_POST['mensagem']);
                $gemini = new api();
                $resposta = $gemini->obterResposta($mensagem);
                include __DIR__ . '/../views/teste.php';
            } else {
                $resposta = "Por favor, digite uma mensagem.";
                include __DIR__ . '/../views/teste.php';
            }
        }
    }
?>