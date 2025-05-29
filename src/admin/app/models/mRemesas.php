<?php
    class mRemesas{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

        public function obtenerTarifa() {
            $sql = "SELECT precioDia, precioMes, numDias FROM datos_aplicacion";
            $resultado = $this->conexion->query($sql);
            $tarifa = $resultado->fetch_assoc();
            return $tarifa;
        }

        private function obtenerAlumnosConAsistenciaPendiente($mes, $anio) {
            $sql = "SELECT alumno.idAlumno, nombreAlumno, apellidosAlumno, clase, COUNT(asistencia.idAsistencia) AS num_dias_asistidos
                    FROM alumno
                    INNER JOIN asistencia ON alumno.idAlumno = asistencia.idAlumno
                    INNER JOIN clases ON alumno.idClase = clases.idClase
                    WHERE MONTH(asistencia.fecha) = ? AND YEAR(asistencia.fecha) = ? AND asistencia.pagado = 0
                    GROUP BY alumno.idAlumno, nombreAlumno, apellidosAlumno, clase";
    
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $mes, $anio);
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            $alumnos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $alumnos[] = $fila;
            }
        
            return $alumnos;
        }

        private function calcularTotalPrecioRecibo($diasAsistidos) {
            // Si el alumno asistió al menos el número mínimo de días para el precio mensual,
            // se cobra el precio mensual fijo.
            if ($diasAsistidos >= $this->tarifaActual['numDias']) {
                return $this->tarifaActual['precioMes'];
            }
            
            // Si asistió menos días, se cobra el precio por día multiplicado por los días asistidos.
            return $diasAsistidos * $this->tarifaActual['precioDia'];
        }
        
        private function obtenerDiasNoLectivosMes($mes, $anio) {
            $sql = "SELECT fecha FROM dias_no_lectivos WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $mes, $anio);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fechasNoLectivas = [];
            while ($fila = $resultado->fetch_assoc()) {
                $fechasNoLectivas[] = $fila['fecha'];
            }
            $stmt->close();
            return $fechasNoLectivas;
        }

        public function generarNuevaRemesa($fechaRemesaStr) {
            // Iniciar la transacción
            $this->conexion->begin_transaction();
        
            // Validar formato de fecha simple
            if (strlen($fechaRemesaStr) != 10 || $fechaRemesaStr[4] != '-' || $fechaRemesaStr[7] != '-') {
                $this->conexion->rollback();
                return ['status' => 'error', 'message' => 'Fecha inválida. Usa formato YYYY-MM-DD'];
            }
        
            // Extraer año y mes con substr
            $anio = (int)substr($fechaRemesaStr, 0, 4);
            $mes = (int)substr($fechaRemesaStr, 5, 2);
        
            // Restar un mes manualmente (sin usar modify)
            $mesRecibos = $mes - 1;
            $anioRecibos = $anio;
            if ($mesRecibos == 0) {
                $mesRecibos = 12;
                $anioRecibos = $anio - 1;
            }
        
            // Convertir mesRecibos a cadena con cero delante si es menor a 10 (sin operador ternario)
            if ($mesRecibos < 10) {
                $mesConCero = "0" . $mesRecibos;
            } else {
                $mesConCero = (string)$mesRecibos;
            }
        
            // Obtener nombre del mes
            $nombreMes = $this->getNombreMes($mesConCero) . " " . $anioRecibos;
        
            // Crear registro remesa
            $idRemesa = $this->crearRegistroRemesa($fechaRemesaStr);
            if (!$idRemesa) {
                $this->conexion->rollback();
                return ['status' => 'error', 'message' => 'Error al crear la remesa'];
            }
        
            // Obtener alumnos con asistencia pendiente
            $alumnos = $this->obtenerAlumnosConAsistenciaPendiente($mesRecibos, $anioRecibos);
        
            if (empty($alumnos)) {
                $this->conexion->commit();
                return [
                    'status' => 'success',
                    'message' => "Remesa creada pero no hay alumnos con asistencia pendiente para $nombreMes.",
                    'recibos' => [],
                    'mesAnioRecibos' => $nombreMes,
                    'idRemesa' => $idRemesa
                ];
            }
        
            $recibos = [];
        
            foreach ($alumnos as $alumno) {
                $resultado = $this->insertarReciboYActualizarAsistencia($alumno, $idRemesa, $mesRecibos, $anioRecibos);
                if ($resultado === false) {
                    $this->conexion->rollback();
                    return ['status' => 'error', 'message' => 'Error al crear recibo para alumno ID ' . $alumno['idAlumno']];
                }
                $recibos[] = $resultado;
            }
        
            // Terminar transacción
            $this->conexion->commit();
        
            return [
                'status' => 'success',
                'message' => "Remesa generada correctamente para $nombreMes.",
                'recibos' => $recibos,
                'mesAnioRecibos' => $nombreMes,
                'idRemesa' => $idRemesa
            ];
        }
        
        private function getNombreMes($numeroMes) {
            $meses = [
                '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
                '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
                '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
            ];
            if (isset($meses[$numeroMes])) {
                return $meses[$numeroMes];
            } else {
                return 'Mes Desconocido';
            }
        }
        
    }