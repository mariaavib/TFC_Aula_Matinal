<?php
    class MControlAsistencia{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

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

        public function listarAlumnos(){
            if (!$this->esDiaLectivo(date('Y-m-d'))) {
                return [];
            }
            $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno  
                    FROM alumno 
                    INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion 
                    ORDER BY alumno.nombreAlumno";
            $resultado = $this->conexion->query($sql);
            
            $alumnos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $alumnos[] = $fila;
            }
            return $alumnos;
        }

        public function registrarAsistencia($idAlumno, $asiste){
            if(!$this->esDiaLectivo(date('Y-m-d'))){
                return false;
            }
            $fecha = date('Y-m-d');

            if($asiste){
                $sql = "INSERT INTO asistencia (fecha, pagado, idAlumno) VALUES (?, 0, ?)";
            }else{
                $sql = "DELETE FROM asistencia WHERE fecha = ? AND idAlumno = ?";
            }
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si', $fecha, $idAlumno);
            $resultado = $stmt->execute();
            $stmt->close();
            
            return ['success' => $resultado];
        }

        public function asistenciaHoy(){
            $fecha = date('Y-m-d');
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

        public function modificarAsistencia($idAlumno, $fecha,$asiste){
            if($asiste){
                $sql = "INSERT INTO asistencia (fecha, pagado, idAlumno) VALUES (?, 0,?)";
            }else{
                $sql = "DELETE FROM asistencia WHERE fecha =? AND idAlumno =?";
            }
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si', $fecha, $idAlumno);
            $resultado = $stmt->execute();
            $stmt->close();

            return $resultado;
        }
        
    }