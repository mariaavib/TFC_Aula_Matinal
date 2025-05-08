<?php
    class MDiasNoLectivos{
        private $conexion;

        public function __construct(){
            require_once('db.php');
            $objConexion = new Db();
            $this->conexion = $objConexion->conexion;
        }

        public function listarDias(){
            $sql = "SELECT * FROM dias_no_lectivos";
            $resultado = $this->conexion->query($sql);
            return $resultado;
        }  

        public function altaDias($fecha, $motivo){
            $sql = "INSERT INTO dias_no_lectivos (fecha, motivo) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $fecha, $motivo);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
    }