<?php
/**
 * Clase MControlAsistencia
 * 
 * Clase que gestiona la lógica de la aplicación relacionada con el control de asistencia.
 * Tiene métodos para verificar si es un día lectivo, listar alumnos, registrar asistencia,
 * obtener asistencia de hoy y de una fecha específica, y modificar la asistencia de un alumno.
 * 
 */
    class MControlAsistencia{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }
        /**
         * Verifica si es un día lectivo.
         *
         * @param string $fecha La fecha a verificar en formato 'YYYY-MM-DD'.
         * @return bool True si es un día lectivo, False en caso contrario.
         */
        public function esDiaLectivo($fecha){
            //Verificar si es fin de semana
            $diaSemana = date('N', strtotime($fecha));
            if($diaSemana >= 6){
                return false;
            }
            //Verificar si es día no lectivo
            $sql = "SELECT COUNT(*) as total FROM dias_no_lectivos WHERE fecha = ?";
            $stmt = $this->conexion->prepare($sql);
  
            $stmt->bind_param('s', $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            $stmt->close();

            return $fila['total'] == 0;
        }
        /**
         * Obtiene la lista de alumnos inscritos.
         *
         * @return array Un array con los datos de los alumnos inscritos.
         */
        public function listarAlumnos(){
            $sql = "SELECT alumno.idAlumno,alumno.apellidosAlumno,alumno.nombreAlumno 
                    FROM alumno 
                    INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion 
                    ORDER BY alumno.apellidosAlumno";
            $resultado = $this->conexion->query($sql);
            
            $alumnos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $alumnos[] = $fila;
            }
            return $alumnos;
        }
        /**
         * Registra la asistencia de un alumno.
         *
         * @param int $idAlumno El ID del alumno.
         * @param bool $asiste True si el alumno asiste, False si no asiste.
         * @return bool True si se registró la asistencia correctamente, False en caso contrario.   
         */
        public function registrarAsistencia($idAlumno, $asiste){
            if(!$this->esDiaLectivo(date('Y-m-d'))){
                return false;
            }
            
            $fecha = date('Y-m-d');
            
            if($asiste) {
                $sql = "INSERT INTO asistencia (fecha, pagado, idAlumno) VALUES (?, 0, ?)";
            } else {
                $sql = "DELETE FROM asistencia WHERE fecha = ? AND idAlumno = ?";
            }
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si', $fecha, $idAlumno);
            $resultado = $stmt->execute();
            $stmt->close();
            
            return $resultado;
        }
        /**
         * Obtiene la lista de alumnos que asistieron hoy.
         * 
         * @return array Un array con los ID de los alumnos que asistieron hoy.
         */

        public function asistenciaHoy(){
            $fecha = date('Y-m-d');
            $sql = "SELECT idAlumno FROM asistencia WHERE fecha = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $asistencias = [];
            while ($fila = $resultado->fetch_assoc()){
                $asistencias[] = $fila['idAlumno'];
            }
            $stmt->close();
            return $asistencias;
        }
        /**
         * Obtiene la lista de alumnos que asistieron en una fecha específica.
         * 
         * @param string $fecha La fecha en formato 'YYYY-MM-DD'.
         * @return array Un array con los ID de los alumnos que asistieron en la fecha especificada.
         */
        public function asistenciaFecha($fecha){
            $sql = "SELECT idAlumno FROM asistencia WHERE fecha = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $asistencias = [];
            while ($fila = $resultado->fetch_assoc()) {
                $asistencias[] = $fila['idAlumno'];
            }
            $stmt->close();
            return $asistencias;
        }
        /**
         * Modifica la asistencia de un alumno en una fecha específica.
         * 
         * @param int $idAlumno El ID del alumno.
         * @param string $fecha La fecha en formato 'YYYY-MM-DD'.
         * @param bool $asiste True si el alumno asiste, False si no asiste.
         */
        public function modificarAsistencia($idAlumno, $fecha, $asiste){
            if($asiste){
                $sql = "INSERT INTO asistencia (fecha, pagado, idAlumno) VALUES (?, 0, ?)";
            } else {
                $sql = "DELETE FROM asistencia WHERE fecha = ? AND idAlumno = ?";
            }
        
            $stmt = $this->conexion->prepare($sql);
            if(!$stmt){
                echo json_encode(['success' => false, 'error' => "Error en la preparación: " . $this->conexion->error]);
                exit;
            }
        
            if (!$stmt->bind_param('si', $fecha, $idAlumno)) {
                echo json_encode(['success' => false, 'error' => "Error en bind_param: " . $stmt->error]);
                exit;
            }
        
            $resultado = $stmt->execute();
            if(!$resultado){
                echo json_encode(['success' => false, 'error' => "Error en la ejecución: " . $stmt->error]);
                exit;
            }
        
            $stmt->close();
            echo json_encode(['success' => true]);
            exit;
        }
        /**
         * Verifica si una fecha es no lectiva y devuelve información detallada.
         *
         * @param string $fecha La fecha a verificar en formato 'YYYY-MM-DD'.
         * @return array Retorna un array con el estado y mensaje
         */
        public function esDiaNoLectivo($fecha){
            $resultado = ['esNoLectivo' => false, 'mensaje' => ''];
        
            // Verificar si es fin de semana
            $diaSemana = date('N', strtotime($fecha));
            if($diaSemana >= 6){
                $resultado['esNoLectivo'] = true;
                $resultado['mensaje'] = 'No se puede seleccionar un fin de semana';
                return $resultado;
            }
        
            // Verificar si es día no lectivo en la base de datos
            $sql = "SELECT motivo FROM dias_no_lectivos WHERE fecha = ?";
            $stmt = $this->conexion->prepare($sql);
        
            if (!$stmt) {
                die("Error en prepare(): " . $this->conexion->error);
            }
        
            $stmt->bind_param('s', $fecha);
            $stmt->execute();
            $resultadoDB = $stmt->get_result();
        
            if($resultadoDB->num_rows > 0){
                $fila = $resultadoDB->fetch_assoc();
                $resultado['esNoLectivo'] = true;
                $resultado['mensaje'] = 'Esta fecha es un día no lectivo: '.$fila['motivo'];
            }
        
            $stmt->close();
            return $resultado;
        }
        
    }
?>
