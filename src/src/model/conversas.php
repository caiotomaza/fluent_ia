<?php

    class conversas{
        protected $id;
        protected $user_id;
        protected $nome;
        protected $data_hora;

        //Construct
        public function __construct($id, $user_id, $nome, $data_hora){
            $this-> id = $id;
            $this-> user_id = $user_id;
            $this-> nome = $nome;
            $this-> data_hora = $data_hora;
        }

        //Getters
        public function getId(){
            return $this-> id;
        }

        public function getUser_id(){
            return $this-> user_id;
        }

        public function getNome(){
            return $this-> nome;
        }

        public function getData_hora(){
            return $this-> data_hora;
        }

        //Setters
        public function setId($id){
            $this-> id = $id;
        }

        public function setUser_id($user_id){
            $this-> user_id = $user_id;
        }

        public function setNome($nome){
            $this-> nome = $nome;
        }

        public function setData_hora($data_hora){
            $this-> data_hora = $data_hora;
        }
    }

?>