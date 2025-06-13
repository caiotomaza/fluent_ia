<?php
   require_once __DIR__ . '/../model/user.php';
   require_once __DIR__ . '/../database/conexao.php';

   class UserController {

      private $conn;

      public function __construct() {
         $this->conn = Conexao::getConn();
      }

      // Criar novo usuário
      public function criar($nome, $email, $senha) {
         $sql = "INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':nome', $nome);
         $stmt->bindParam(':email', $email);
         $stmt->bindParam(':senha', $senha);
         return $stmt->execute();
      }

      // Listar todos os usuários
      public function listarTodos() {
         $sql = "SELECT * FROM users";
         $stmt = $this->conn->prepare($sql);
         $stmt->execute();
         $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

         $usuarios = [];
         foreach ($resultados as $row) {
               $usuarios[] = new User(
                  $row['id'],
                  $row['nome'],
                  $row['data_hora'],
                  $row['email'],
                  $row['senha']
               );
         }
         return $usuarios;
      }

      // Buscar usuário por ID
      public function buscarPorId($id) {
         $sql = "SELECT * FROM users WHERE id = :id";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':id', $id);
         $stmt->execute();

         if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               return new User(
                  $row['id'],
                  $row['nome'],
                  $row['data_hora'],
                  $row['email'],
                  $row['senha']
               );
         }
         return null;
      }

      // Atualizar usuário
      public function atualizar($id, $nome, $email, $senha) {
         $sql = "UPDATE users SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':id', $id);
         $stmt->bindParam(':nome', $nome);
         $stmt->bindParam(':email', $email);
         $stmt->bindParam(':senha', $senha);
         return $stmt->execute();
      }

      // Deletar usuário
      public function deletar($id) {
         $sql = "DELETE FROM users WHERE id = :id";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':id', $id);
         return $stmt->execute();
      }
      // Buscar por e-mail
      public function buscarPorEmail($email) {
         $sql = "SELECT * FROM users WHERE email = :email";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':email', $email);
         $stmt->execute();

         if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new User(
                  $row['id'],
                  $row['nome'],
                  $row['data_hora'],
                  $row['email'],
                  $row['senha']
            );
         }
         return null;
      }

      public function buscarNomePorId($id) {
         $sql = "SELECT nome FROM users WHERE id = :id";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':id', $id);
         $stmt->execute();
         return $stmt->fetchColumn(); // retorna apenas o valor da coluna "nome"
      }
   }
?>