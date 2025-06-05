<?php
    require_once __DIR__ . '/../model/api.php';
    require_once __DIR__ . '/mensagens_control.php';

    class api_control {
        public function enviarMensagem() {
            if (isset($_POST['mensagem']) && !empty(trim($_POST['mensagem']))) {
                $pergunta = trim($_POST['mensagem']);

                $gemini = new api();
                $MensagensController = new MensagensController();

                $remetente_id = null;
                $conversas_id = 1; //$_SESSION['conversa_id'];

                $mensagem = $gemini->obterResposta($pergunta);

                $guardar = $MensagensController->enviar($conversas_id, $remetente_id, $mensagem);

                include __DIR__ . '/../views/chat.php';

            } else {
                $mensagem = "Por favor, digite uma mensagem.";
                include __DIR__ . '/../views/chat.php';
                
            }
        }
    }
?>