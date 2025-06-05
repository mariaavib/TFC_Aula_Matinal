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
        public function listarDias() {
            $sql = "SELECT * FROM dias_no_lectivos ORDER BY fecha ASC";
            $result = $this->conexion->query($sql);
        
            $dias = [];
            while ($fila = $result->fetch_assoc()) {
                $dias[] = $fila;
            }
        
            return $dias;
        }
        /***
         * Metodo para actualizar el año de los dias no lectivos
         */
        public function actualizarAnioDiasNoLectivos(){
            $añoActual = date('Y');
            $sql = "SELECT idDia, fecha, motivo FROM dias_no_lectivos;";
            $resultado = $this->conexion->query($sql);

            if ($resultado && $resultado->num_rows > 0) {
                while ($dia = $resultado->fetch_assoc()) {
                    $fecha = new DateTime($dia['fecha']);
                    $anio = $fecha->format('Y');
                    $mesDia = $fecha->format('m-d');
        
                    // Si el año no es el actual
                    if ($anio != $añoActual) {
                        $nuevaFecha = "$añoActual-$mesDia";
        
                        // Verificamos si ya existe esa fecha en la base de datos
                        $sqlExiste = "SELECT COUNT(*) as total FROM dias_no_lectivos WHERE fecha = '$nuevaFecha'";
                        $resExiste = $this->conexion->query($sqlExiste);
                        $filaExiste = $resExiste->fetch_assoc();
        
                        if ($filaExiste['total'] == 0) {
                            // Actualizamos la fecha
                            $id = $dia['idDia'];
                            $sqlUpdate = "UPDATE dias_no_lectivos SET fecha = '$nuevaFecha' WHERE idDia = $id";
                            $this->conexion->query($sqlUpdate);
                        }
                    }
                }
            }
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
            return $stmt->execute() ? true : false;
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
        /**
         * Comprueba si existe un día no lectivo con la misma fecha 
         * En la edición, excluye el registro con $id para no validar contra sí mismo.
         *
         * @param string $fecha
         * @param string $motivo
         * @param int|null $id Opcional. ID a excluir en la comprobación (para edición).
         * @return bool Devuelve true si existe un registro con esa fecha y motivo.
         */
        public function comprobar($fecha, $id = null) {
            if ($id) {
                $sql = "SELECT COUNT(*) as total FROM dias_no_lectivos WHERE fecha = ? AND idDia != ?";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param("si", $fecha, $id);
            } else {
                $sql = "SELECT COUNT(*) as total FROM dias_no_lectivos WHERE fecha = ?";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param("s", $fecha);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            $stmt->close();
        
            return $fila['total'] > 0;
        }
    }