<?php

    class Conexao {
        private static $instance;

        public static function getConn() {
            try {
                if (!isset(self::$instance)) {
                    self::$instance = new \PDO(
                        'mysql:host=localhost;dbname=fluent_ia_db;charset=utf8', // Nome do data base com o charset
                        'root', // Usuário padrão do XAMPP
                        '' // Senha padrão do XAMPP (geralmente vazia)
                    );

                    self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }

                return self::$instance;
            } catch (\PDOException $e) {
                echo "Erro de conexão: " . $e->getMessage();
                return null;
            }
        }
    }

?>