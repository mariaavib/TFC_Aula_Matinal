<?php
    class mFechaCurso{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

        public function listarFechaCurso(){
            $sql = "SELECT inicioCurso, finCurso 
                    FROM datos_aplicacion
                    WHERE inicioCurso IS NOT NULL
                    AND finCurso IS NOT NULL";
            $resultado = $this->conexion->query($sql);
    
            $fechasCurso = [];
            $fechasCurso = $resultado->fetch_assoc();
            return $fechasCurso;
        }

        /**
         * Comprueba si hay alguna fila con los datos de inicio y fin de curso.
         * Si hay, actualiza, si no, inserta.
         * @param mixed $inicioCurso
         * @param mixed $finCurso
         * @return bool
         */
        public function insertarFechaCurso($inicioCurso, $finCurso){
    
            $sql = "SELECT COUNT(*) as total 
                    FROM datos_aplicacion
                    WHERE inicioCurso IS NOT NULL
                    AND finCurso IS NOT NULL";
            $resultado = $this->conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            
            if($fila['total'] == 1) {
                $sql = "UPDATE datos_aplicacion 
                        SET inicioCurso = ?, finCurso = ?
                        WHERE inicioCurso IS NOT NULL
                        AND finCurso IS NOT NULL";
            } else {
                $sql = "INSERT INTO datos_aplicacion (inicioCurso, finCurso) VALUES (?, ?)";
            }
            
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar la consulta: " . $this->conexion->error);
                return false;
            }
            $stmt->bind_param("ss", $inicioCurso, $finCurso);
            
            if($stmt->execute()){
                // Para UPDATE, affected_rows > 0 significa que los datos cambiaron.
                // Para INSERT, affected_rows = 1 significa éxito.
                // Si affected_rows = 0 en un UPDATE, puede ser que los datos enviados eran iguales a los existentes.
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return true;
                } elseif ($fila['total'] == 1 && $stmt->affected_rows == 0) {
                    // UPDATE se ejecutó pero no afectó filas (quizás los datos eran los mismos)
                    $stmt->close();
                    return true;
                } else if ($fila['total'] != 1 && $stmt->affected_rows > 0) {
                    // INSERT exitoso
                    $stmt->close();
                    return true;
                }
                // Si affected_rows es 0 en un INSERT, o negativo, es un error.
                error_log("Advertencia: Error en la ejecución de la consulta. Filas afectadas: " . $stmt->affected_rows . " SQL: " . $sql);
                $stmt->close();
                return false; // O true si no afectar filas en UPDATE con mismos datos es OK.
            }else{
                error_log("Error al ejecutar la consulta: " . $stmt->error . " SQL: " . $sql);
                $stmt->close();
                return false;
            }
        }
    }