<?php
    class MTarifas{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

        /**
         * Lista las tarifas de la base de datos.
         * Busca si hay alguna fila con los datos de numDias, precioDia y precioMes.
         * @return mixed $tarifas
         */
        public function listarTarifas(){
            $sql = "SELECT numDias, precioDia, precioMes 
                    FROM datos_aplicacion
                    WHERE numDias IS NOT NULL
                    AND precioDia IS NOT NULL
                    AND precioMes IS NOT NULL";
            $resultado = $this->conexion->query($sql);
            $tarifas = [];
            $tarifas = $resultado->fetch_assoc();
            return $tarifas;
        }

        /**
         * Comprueba si hay alguna fila con los datos de numDias, precioDia y precioMes.
         * Si hay, actualiza, si no, inserta.
         * @param mixed $numDias
         * @param mixed $precioDia
         * @param mixed $precioMes
         * @return bool
         */
        public function insertarTarifas($numDias, $precioDia, $precioMes){
    
            $sql = "SELECT COUNT(*) as total 
                    FROM datos_aplicacion
                    WHERE numDias IS NOT NULL
                    AND precioDia IS NOT NULL
                    AND precioMes IS NOT NULL";
            $resultado = $this->conexion->query($sql);
            $fila = $resultado->fetch_assoc();
            
            //Si hay alguna fila con los datos de tarifas NOT NULL, actualiza.
            //Si no, inserta.
            if($fila['total'] == 1) {
                $sql = "UPDATE datos_aplicacion 
                        SET numDias = ?, precioDia = ?, precioMes = ?
                        WHERE numDias IS NOT NULL
                        AND precioDia IS NOT NULL
                        AND precioMes IS NOT NULL";
            } else {
                $sql = "INSERT INTO datos_aplicacion (numDias, precioDia, precioMes) VALUES (?, ?, ?)";
            }
            
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                error_log("Error al preparar la consulta: " . $this->conexion->error);
                return false;
            }
            $stmt->bind_param("idd", $numDias, $precioDia, $precioMes);
            
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
                    return true; // Considerar esto como éxito si la intención era asegurar los datos
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