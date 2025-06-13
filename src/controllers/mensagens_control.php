<?php
    require_once __DIR__ . '/../model/mensagens.php';
    require_once __DIR__ . '/../database/conexao.php';

    class MensagensController {
        private $conn;

        public function __construct() {
            $this->conn = Conexao::getConn();
        }

        // Enviar nova mensagem
        public function enviar($conversas_id, $remetente_id, $message) {
            $sql = "INSERT INTO mensagens (conversas_id, remetente_id, message) VALUES (:conversas_id, :remetente_id, :message)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':conversas_id', $conversas_id);
            $stmt->bindParam(':remetente_id', $remetente_id);
            $stmt->bindParam(':message', $message);
            $stmt->execute();
        }

        public function buscarPorConversa($conversas_id) {
            $sql = "SELECT * FROM mensagens WHERE conversas_id = :conversas_id ORDER BY data_hora ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':conversas_id', $conversas_id);
            $stmt->execute();

            $mensagens = [];
            while ($row = $stmt->fetch(mode: PDO::FETCH_ASSOC)) {
                $mensagens[] = new mensagens(
                    $row['id'],
                    $row['conversas_id'],
                    $row['remetente_id'],
                    $row['message'],
                    $row['data_hora']
                );
            }
            return $mensagens;
        }

        // Busca menssagens do chat selecionado
        public function BuscarMenssagen($conversas_id) {
            $sql = "SELECT * FROM mensagens WHERE conversas_id = :conversas_id ORDER BY data_hora ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['conversas_id' => $conversas_id]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $mensagens = [];

            foreach ($resultados as $row) {
                $mensagens[] = new mensagens(
                    $row['id'],
                    $row['conversas_id'],
                    $row['remetente_id'],
                    $row['message'],
                    $row['data_hora']
                );
            }
            return $mensagens;
        }
    }
?>