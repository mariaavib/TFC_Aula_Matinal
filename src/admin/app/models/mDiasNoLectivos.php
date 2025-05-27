<?php
    /**
     * Modelo mDiasNoLectivos
     * 
     * Permite listrar, obetener por id, dar de alta, modificar y eliminar un dia no lectivo
     */
    class MDiasNoLectivos{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

        public function listarDias(){
            $sql = "SELECT * FROM dias_no_lectivos";
            $resultado = $this->conexion->query($sql);
            return $resultado;
        }  

        public function obtenerPorId($id) {
            $sql = "SELECT * FROM dias_no_lectivos WHERE idDia = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            $stmt->close();
            //var_dump($fila);
            return $fila;
        }

        public function altaDias($fecha, $motivo){
            $sql = "INSERT INTO dias_no_lectivos (fecha, motivo) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $fecha, $motivo);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }

        public function updateDias($id, $fecha, $motivo){
            $sql = "UPDATE dias_no_lectivos SET fecha = ?, motivo = ? WHERE idDia = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi", $fecha, $motivo, $id);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado; 
            
        }

        public function eliminarDias($id){
            $sql = "DELETE FROM dias_no_lectivos WHERE idDia =?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado; 
        }
    }