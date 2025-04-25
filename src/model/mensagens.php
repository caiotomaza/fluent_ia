<?php

    class mensagens{
        protected $id;
        protected $conversas_id;
        protected $remetente_id;
        protected $data_hora;

        //Construct
        public function __construct($id, $conversas_id, $remetente_id, $data_hora){
            $this-> id = $id;
            $this-> conversas_id = $conversas_id;
            $this-> remetente_id = $remetente_id;
            $this-> data_hora = $data_hora;
        }

        //Getters
        public function getId(){
            return $this-> id;
        }

        public function getConversas_id(){
            return $this-> conversas_id;
        }

        public function getRemetente_id(){
            return $this-> remetente_id;
        }

        public function getData_hora(){
            return $this-> data_hora;
        }

        //Setters
        public function setId($id){
            $this-> id = $id;
        }

        public function setConversas_id($conversas_id){
            $this-> conversas_id = $conversas_id;
        }

        public function setRemetente_id($remetente_id){
            $this-> remetente_id = $remetente_id;
        }

        public function setData_hora($data_hora){
            $this-> data_hora = $data_hora;
        }
    }

?>