<?php
    require_once __DIR__ . '/../model/conversas.php';
    require_once __DIR__ . '/../database/conexao.php';

    class ConversasController {
        private $conn;

        public function __construct() {
            $this->conn = Conexao::getConn();
        }

        // Criar nova conversa
        public function criar($user_id) {
            $sql = "INSERT INTO conversas (user_id) VALUES (:user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            return $stmt->execute();
        }

        // Listar todas as conversas
        public function listarTodas() {
            $sql = "SELECT * FROM conversas";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $conversas = [];
            foreach ($resultados as $row) {
                $conversas[] = new Conversas(
                    $row['id'],
                    $row['user_id'],
                    $row['data_hora']
                );
            }
            return $conversas;
        }

        // Buscar conversa por ID
        public function buscarPorId($id) {
            $sql = "SELECT * FROM conversas WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return new Conversas(
                    $row['id'],
                    $row['user_id'],
                    $row['data_hora']
                );
            }
            return null;
        }

        // Deletar conversa
        public function deletar($id) {
            $sql = "DELETE FROM conversas WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
?>