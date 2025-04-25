<?php

    class user{
        protected $id;
        protected $nome;
        protected $data_hora;
        protected $email;
        protected $senha;

        //Construct
        protected function __construct($id, $nome, $data_hora, $email, $senha){
            $this-> id = $id;
            $this-> nome = $nome;
            $this-> data_hora = $data_hora;
            $this-> email = $email;
            $this-> senha = $senha;
        }

        //Getters
        public function getId(){
            return $this-> id;
        }

        public function getNome(){
            return $this-> nome;
        }

        private function getData_hora(){
            return $this-> data_hora;
        }

        protected function getEmail(){
            return $this-> email;
        }

        private function getSenha(){
            return $this-> senha;
        }

        //Setters
        public function setId($id){
            $this-> id = $id;
        }

        public function setNome($nome){
            $this-> nome = $nome;
        }

        private function setData_hora($data_hora){
            $this-> data_hora = $data_hora;
        }

        protected function setEmail($email){
            $this-> email = $email;
        }

        private function setSenha($senha){
            $this-> senha = $senha;
        }
    }

?>