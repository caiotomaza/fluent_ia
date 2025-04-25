<?php

    class conversas{
        protected $id;
        protected $user_id;
        protected $data_hora;

        //Construct
        public function __construct($id, $user_id, $data_hora){
            $this-> id = $id;
            $this-> user_id = $user_id;
            $this-> data_hora = $data_hora;
        }

        //Getters
        public function getId(){
            return $this-> id;
        }

        public function getUser_id(){
            return $this-> user_id;
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

        public function setData_hora($data_hora){
            $this-> data_hora = $data_hora;
        }
    }

?>