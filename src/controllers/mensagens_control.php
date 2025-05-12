<?php
    require_once __DIR__ . '/../model/mensagens.php';
    require_once __DIR__ . '/../database/conexao.php';

    class MensagensController {
        private $conn;

        public function __construct() {
            $this->conn = Conexao::getConn();
        }

        // Criar nova mensagem
        public function criar($conversas_id, $remetente_id, $mensagem) {
            $sql = "INSERT INTO mensagens (conversas_id, remetente_id, message) VALUES (:conversas_id, :remetente_id, :message)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':conversas_id', $conversas_id);
            $stmt->bindParam(':remetente_id', $remetente_id);
            $stmt->bindParam(':message', $mensagem);
            return $stmt->execute();
        }

        // Listar todas as mensagens
        public function listarTodas() {
            $sql = "SELECT * FROM mensagens";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $mensagens = [];
            foreach ($resultados as $row) {
                $mensagens[] = new Mensagens(
                    $row['id'],
                    $row['conversas_id'],
                    $row['remetente_id'],
                    $row['data_hora']
                );
            }
            return $mensagens;
        }

        // Buscar mensagens de uma conversa específica
        public function buscarPorConversa($conversas_id) {
            $sql = "SELECT * FROM mensagens WHERE conversas_id = :conversas_id ORDER BY data_hora ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':conversas_id', $conversas_id);
            $stmt->execute();

            $mensagens = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $mensagens[] = new Mensagens(
                    $row['id'],
                    $row['conversas_id'],
                    $row['remetente_id'],
                    $row['data_hora']
                );
            }
            return $mensagens;
        }

        // Deletar mensagem por ID
        public function deletar($id) {
            $sql = "DELETE FROM mensagens WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
?>