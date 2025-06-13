<?php
    require_once __DIR__ . '/../model/api.php';
    require_once __DIR__ . '/mensagens_control.php';

    class api_control {
        public function enviarMensagem() {
            if (isset($_POST['mensagem']) && !empty(trim($_POST['mensagem']))) {
                session_start();
                $pergunta_user = trim($_POST['mensagem']);

                $gemini = new api();
                $MensagensController = new MensagensController();

                $remetente_id = null;
                $conversas_id = $_SESSION['conversas_id'];

                if($_SESSION['metodo_ia'] = 1){
                    $pergunta = 'melhore esta frase: ';
                    $pergunta .= $pergunta_user;
                }

                if($_SESSION['metodo_ia'] = 2){
                    $pergunta = 'Simplifique esta frase: ';
                    $pergunta .= $pergunta_user;
                }

                if($_SESSION['metodo_ia'] = 3){
                    $pergunta = 'Traduza para portugues brasileiro esta frase: ';
                    $pergunta .= $pergunta_user;
                }

                $message = $gemini->obterResposta($pergunta);

                $guardar = $MensagensController->enviar($conversas_id, $remetente_id, $message);

                session_abort();

                include __DIR__ . '/../views/chat.php';

            } else {
                $message = "Por favor, digite uma mensagem.";
                include __DIR__ . '/../views/chat.php';
                
            }
        }
    }
?>