<?php
    class CControlAsistencia{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'ControlAsistencia.php');
                $this->objModelo = new MControlAsistencia(); 
            }
        
            public function gestionar(){
                $this->vista = 'vControlAsistencia';    
                $datos ['alumnos'] = $this->objModelo->listarAlumnos();
                $datos ['asistencias'] = $this->objModelo->asistenciaHoy();
                $datos ['fecha'] = date('d/m/Y');
                $datos ['esDiaLectivo'] = $this->objModelo->esDiaLectivo(date('Y-m-d'));

                return $datos;
            }

            public function registrarAsistencia(){
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $idAlumno = $_POST['idAlumno'] ?? null;
                    $asiste = $_POST['asiste'] ?? null;
                    
                    if ($idAlumno !== null && $asiste !== null) {
                        $resultado = $this->objModelo->registrarAsistencia($idAlumno, $asiste);
                        header('Content-Type: application/json');
                        echo json_encode($resultado);
                        exit;
                    }
                }
            }

            public function modificar() {
                $this->vista = 'vModAsistencia';
                $datos = [];

                if(isset($_GET['dia']) && isset($_GET['mes']) && isset($_GET['anio'])) {
                    $dia = $_GET['dia'];
                    $mes = $_GET['mes'];
                    $anio = $_GET['anio'];
                    $fecha = "$anio-$mes-$dia";

                    $datos['alumnos'] = $this->objModelo->listarAlumnos();
                    $datos['asistencias'] = $this->objModelo->asistenciaFecha($fecha);
                    
                    // Convertir el nombre del mes
                    $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                             'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                    $datos['fecha'] = "$dia DE " . $meses[$mes - 1] . " $anio";
                }
                
                return $datos;
            }

            public function obtenerAsistenciaFecha(){
                $this->vista = 'vModAsistencia';
                if (isset($_GET['dia']) && isset($_GET['mes']) && isset($_GET['anio'])) {
                    $dia = $_GET['dia'];
                    $mes = $_GET['mes'];
                    $anio = $_GET['anio'];
                    $fecha = "$anio-$mes-$dia";
            
                    $alumnos = $this->objModelo->listarAlumnos();
                    $asistencias = $this->objModelo->asistenciaFecha($fecha);
                    foreach ($alumnos as &$alumno) {
                        $alumno['asiste'] = in_array($alumno['idAlumno'], $asistencias);
                    }
                   
                    return ['alumnos' => $alumnos, 'fecha' => $fecha];
                }
            }

            public function modificarAsistencia(){
                $idAlumno = $_POST['idAlumno'];
                $fecha = $_POST['fecha'];
                $asiste = $_POST['asiste'];
                
                $resultado = $this->objModelo->modificarAsistencia($idAlumno, $fecha, $asiste);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => $resultado]);
                exit;
            }


        
    }