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
        /**
         * Metodo que lista los dias no lectivos
         *
         * @return array
         */
        public function listarDias(){
            $sql = "SELECT * FROM dias_no_lectivos";
            $resultado = $this->conexion->query($sql);
            return $resultado;
        }  
        /**
         * Metodo que obtiene un dia no lectivo por su id
         *
         * @param int $id
         * @return array
         */
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
        /**
         * Metodo que da de alta un dia no lectivo
         *
         * @param string $fecha
         * @param string $motivo
         * @return boolean
         */
        public function altaDias($fecha, $motivo){
            $sql = "INSERT INTO dias_no_lectivos (fecha, motivo) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $fecha, $motivo);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        /**
         * Metodo que modifica un dia no lectivo
         *
         * @param int $id
         * @param string $fecha
         * @param string $motivo
         * @return boolean
         */
        public function updateDias($id, $fecha, $motivo){
            $sql = "UPDATE dias_no_lectivos SET fecha = ?, motivo = ? WHERE idDia = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi", $fecha, $motivo, $id);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado; 
            
        }
        /**
         * Metodo que elimina un dia no lectivo
         *
         * @param int $id
         * @return boolean
         */
        public function eliminarDias($id){
            $sql = "DELETE FROM dias_no_lectivos WHERE idDia =?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado; 
        }
    }