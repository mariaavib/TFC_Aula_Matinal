<?php
    class MDiasNoLectivos{
        private $conexion;

        public function __construct(){
            require_once(CONFIG.'configdb.php');
            $objConexion = new Db();
            $this->conexion = $objConexion->conexion;
        }

        public function listarDias(){
            $sql = "SELECT * FROM dias_no_lectivos";
            $resultado = $this->conexion->query($sql);
            return $resultado;
        }  
    }