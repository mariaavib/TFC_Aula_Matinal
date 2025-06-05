<?php
/**
 * Modelo que gestiona las remesas
 */
    class mRemesas{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }
        /**
         * Metodo que genera una nueva remesa
         */
        public function generarNuevaRemesa($fechaRemesa) {
            $fecha = strtotime($fechaRemesa);
            $mes = date('m', strtotime('-1 month', $fecha));
            $anio = date('Y', strtotime('-1 month', $fecha));
        
            if ($this->existeRemesa($mes, $anio)) {
                return ['status' => 'error', 'message' => "Ya existe una remesa para $mes/$anio"];
            }
        
            $alumnos = $this->obtenerAlumnos();
        
            $totalAsistencias = 0;
            foreach ($alumnos as $idAlumno) {
                $totalAsistencias += $this->contarAsistencias($idAlumno, $mes, $anio);
            }
        
            if ($totalAsistencias === 0) {
                return ['status' => 'error', 'message' => "No hay asistencias para $mes/$anio. No se puede generar la remesa."];
            }
        
            $idRemesa = $this->crearRemesa($mes, $anio);
            if (!$idRemesa) {
                return ['status' => 'error', 'message' => "No se pudo crear la remesa."];
            }
        
            [$precioDia, $precioMes, $numDias] = $this->obtenerTarifas();
        
            $alumnosFacturados = [];
        
            foreach ($alumnos as $idAlumno) {
                $dias = $this->contarAsistencias($idAlumno, $mes, $anio);
                if ($dias > 0) {
                    $precioFinal = ($dias >= $numDias) ? $precioMes : $dias * $precioDia;
        
                    $this->crearRecibo($idAlumno, $idRemesa, $dias, $precioFinal, $mes, $anio);
                    $this->marcarAsistenciasComoFacturadas($idAlumno, $mes, $anio);
        
                    $infoAlumno = $this->obtenerInfoAlumno($idAlumno);
                    $alumnosFacturados[] = [
                        'idAlumno' => $idAlumno,
                        'nombre' => $infoAlumno['nombreAlumno'] . ' ' . $infoAlumno['apellidosAlumno'],
                        'clase' => $infoAlumno['clase'],
                        'diasAsistidos' => $dias,
                        'importe' => $precioFinal
                    ];
                }
            }
            return [
                'status' => 'ok',
                'message' => 'Remesa generada correctamente',
                'alumnos' => $alumnosFacturados
            ];
        }
        /**
         * Metodo privado que obtiene la información de un alumno para la remes
         */
        private function obtenerInfoAlumno($idAlumno) {
            $sql = "SELECT nombreAlumno,apellidosAlumno,clase 
                    FROM alumno 
                    INNER JOIN clases  ON alumno.idClase = clases.idClase
                    WHERE alumno.idAlumno = $idAlumno
                    LIMIT 1";
            $res = mysqli_query($this->conexion, $sql);
            return mysqli_fetch_assoc($res);
        }
        /**
         * Metodo privado que comprueba si existe una remesa para el mes y año dados
         */
        private function existeRemesa($mes, $anio) {
            $sql = "SELECT COUNT(*) AS total FROM remesas WHERE mes = $mes AND anio = $anio";
            $res = mysqli_query($this->conexion, $sql);
            $row = mysqli_fetch_assoc($res);
            return $row['total'] > 0;
        }
        /**
         * Metodo privado que crea una nueva remesa
         */
        private function crearRemesa($mes, $anio) {
            $sql = "INSERT INTO remesas (fechaGenerada, mes, anio) VALUES (NOW(), $mes, $anio)";
            mysqli_query($this->conexion, $sql);
            return mysqli_insert_id($this->conexion);
        }
        /**
         * Metodo privado que obtiene las tarifas de la aplicación
         */
        private function obtenerTarifas()
        {
            $sql = "SELECT precioDia, precioMes, numDias 
                FROM datos_aplicacion 
                WHERE precioDia IS NOT NULL 
                AND precioMes IS NOT NULL 
                AND numDias IS NOT NULL 
                LIMIT 1;";
            $resultado = mysqli_query($this->conexion, $sql);

            if ($fila = mysqli_fetch_assoc($resultado)) {
                return [$fila['precioDia'], $fila['precioMes'], $fila['numDias']];
            }
            return [0, 0, 0]; // Valor por defecto en caso de error
        }
        /**
         * Metodo privado que obtiene los alumnos
         */
        private function obtenerAlumnos() {
            $alumnos = [];
            $sql = "SELECT idAlumno FROM alumno";
            $res = mysqli_query($this->conexion, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $alumnos[] = $row['idAlumno'];
            }
            return $alumnos;
        }
        /**
         * Metodo privado que cuenta las asistencias de un alumno para un mes y año dados
         */
        private function contarAsistencias($idAlumno, $mes, $anio) {
            $sql = "SELECT COUNT(*) AS total FROM asistencia 
                    WHERE idAlumno = $idAlumno 
                    AND MONTH(fecha) = $mes 
                    AND YEAR(fecha) = $anio 
                    AND reciboEmitido = 0";
            $res = mysqli_query($this->conexion, $sql);
            $row = mysqli_fetch_assoc($res);
            return $row['total'];
        }
        /**
         * Metodo privado que crea un nuevo recibo
         */
        private function crearRecibo($idAlumno, $idRemesa, $dias, $precioFinal, $mes, $anio) {
            $sql = "INSERT INTO recibos (diasAsistidos, anio, mes, totalDias, totalPrecio, idAlumno, idRemesa)
                    VALUES ($dias, $anio, $mes, $dias, $precioFinal, $idAlumno, $idRemesa)";
            mysqli_query($this->conexion, $sql);
        }
        /**
         * Metodo privado que marca las asistencias como facturadas
         */
        private function marcarAsistenciasComoFacturadas($idAlumno, $mes, $anio) {
            $sql = "UPDATE asistencia SET reciboEmitido = 1 
                    WHERE idAlumno = $idAlumno 
                    AND MONTH(fecha) = $mes 
                    AND YEAR(fecha) = $anio 
                    AND reciboEmitido = 0";
            mysqli_query($this->conexion, $sql);
        }
        /**
         * Metodo que lista las remesas
         */
        public function listarRemesas() {
            $remesas = [];
            $sql = "SELECT * FROM remesas";
            $res = mysqli_query($this->conexion, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $remesas[] = $row;
            }
            return $remesas;
        }
        /**
         * Metodo que obtiene los detalles de un alumno
         */
        public function obtenerDetallesAlumno($idAlumno, $mes, $anio) {
            $sql = "SELECT 
                asistencia.fecha, 
                alumno.nombreAlumno, 
                alumno.apellidosAlumno, 
                inscripciones.nombrePadre,
                inscripciones.apellidosPadre,
                inscripciones.telefono
            FROM asistencia
            INNER JOIN alumno ON asistencia.idAlumno = alumno.idAlumno
            INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion
            WHERE asistencia.idAlumno = $idAlumno
            AND MONTH(asistencia.fecha) = $mes
            AND YEAR(asistencia.fecha) = $anio
            AND asistencia.reciboEmitido = 1
            ORDER BY asistencia.fecha ASC;";
        
            $res = mysqli_query($this->conexion, $sql);
            $detalles = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $detalles[] = $row;
            }
        
            return $detalles;
        }
        /**
         * Metodo que obtiene los datos mensuales de los alumnos
         */
        public function obtenerDatosMensuales($mes, $anio) {
            if (!$this->existeRemesa($mes, $anio)) {
                return [];  
            }
        
            [$precioDia, $precioMes, $numDias] = $this->obtenerTarifas();
            $datos = [];
        
            $sql = "SELECT DISTINCT alumno.idAlumno, alumno.nombreAlumno, alumno.apellidosAlumno, clases.clase
                    FROM alumno
                    INNER JOIN clases ON alumno.idClase = clases.idClase
                    INNER JOIN recibos ON alumno.idAlumno = recibos.idAlumno
                    INNER JOIN remesas ON recibos.idRemesa = remesas.idRemesa
                    WHERE remesas.mes = $mes AND remesas.anio = $anio
                    ORDER BY alumno.nombreAlumno ASC";
        
            $res = mysqli_query($this->conexion, $sql);
            if (!$res) {
                die("Error en consulta obtenerDatosMensuales: " . mysqli_error($this->conexion));
            }
        
            while ($row = mysqli_fetch_assoc($res)) {
                $idAlumno = $row['idAlumno'];
        
                $sqlAsistencias = "SELECT COUNT(*) AS total 
                                   FROM asistencia 
                                   WHERE idAlumno = $idAlumno 
                                     AND MONTH(fecha) = $mes 
                                     AND YEAR(fecha) = $anio
                                     AND reciboEmitido = 1";
        
                $resAsistencias = mysqli_query($this->conexion, $sqlAsistencias);
                if (!$resAsistencias) {
                    die("Error en consulta contar asistencias: " . mysqli_error($this->conexion));
                }
        
                $asistenciaData = mysqli_fetch_assoc($resAsistencias);
                $dias = $asistenciaData['total'];
        
                if ($dias >= $numDias) {
                    $importe = $precioMes;
                } else {
                    $importe = $dias * $precioDia;
                }
        
                if ($dias > 0) {
                    $datos[] = [
                        'idAlumno' => $idAlumno,
                        'nombre' => $row['nombreAlumno'].' '.$row['apellidosAlumno'],
                        'clase' => $row['clase'],
                        'diasAsistidos' => $dias,
                        'importe' => $importe
                    ];
                }
            }
        
            return $datos;
        }
        /**
         * Metodo que elimina una remesa
         */
        public function eliminarRemesa($idRemesa) {
            $sql = "SELECT idAlumno, mes, anio 
                    FROM recibos 
                    WHERE idRemesa = $idRemesa";
            $resultado = mysqli_query($this->conexion, $sql);
        
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $idAlumno = $fila['idAlumno'];
                $mes = $fila['mes'];
                $anio = $fila['anio'];
        
                $actualizar = "UPDATE asistencia 
                               SET reciboEmitido = 0 
                               WHERE idAlumno = $idAlumno 
                               AND MONTH(fecha) = $mes 
                               AND YEAR(fecha) = $anio";
                mysqli_query($this->conexion, $actualizar);
            }
        
            $borrarRemesa = "DELETE FROM remesas WHERE idRemesa = $idRemesa";
            $resultadoBorrarRemesa = mysqli_query($this->conexion, $borrarRemesa);
        
            if ($resultadoBorrarRemesa) {
                return ['status' => 'ok', 'message' => 'Remesa eliminada correctamente.'];
            } else {
                return ['status' => 'error', 'message' => 'Error al eliminar la remesa.'];
            }
        }
        
        /**
         * Metodo que coge los datos para el excel de remesas
         */
        public function cogerDatosExcelRemesas($mes, $anio) {
            $sql = "SELECT titularCuenta, IBAN, fechaMandato,totalPrecio, DNI
                    FROM inscripciones
                    INNER JOIN alumno ON alumno.idInscripcion = inscripciones.idInscripcion
                    INNER JOIN recibos ON recibos.idAlumno = alumno.idAlumno
                    INNER JOIN remesas ON remesas.idRemesa = recibos.idRemesa
                    WHERE remesas.mes = $mes AND remesas.anio = $anio AND completada = 1;";
            $resultado = mysqli_query($this->conexion, $sql);
            $datos = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos[] = $row;
            }
            return $datos;
        }
    }
