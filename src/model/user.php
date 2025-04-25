<?php

    class user{
        protected $id;
        protected $nome;
        protected $email;
        protected $senha;

        //Construct
        public function __construct($id, $nome, $email, $senha){
            $this-> id = $id;
            $this-> nome = $nome;
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

        public function getEmail(){
            return $this-> email;
        }

        public function getSenha(){
            return $this-> senha;
        }

        //Setters
        public function setId($id){
            $this-> id = $id;
        }

        public function setNome($nome){
            $this-> nome = $nome;
        }

        public function setEmail($email){
            $this-> email = $email;
        }

        public function setSenha($senha){
            $this-> senha = $senha;
        }
    }
    
?>