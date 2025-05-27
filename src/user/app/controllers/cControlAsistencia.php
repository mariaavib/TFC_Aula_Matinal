<?php
<<<<<<< HEAD
=======
/**
 * Controlador CControlAsistencia
 * 
 * Se encarga de gestionar las asistencias de los alumnos
 * carga los datos desde el modelo y pasa la información a la vista,
 * también procesa las solicitudes de registrar o modificar asistencias.
 * 
 * Se manejan metodos para gestionar la asistencia, registrar y modificar 
 * asistencias.
 */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    class CControlAsistencia{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'ControlAsistencia.php');
                $this->objModelo = new MControlAsistencia(); 
            }
        
<<<<<<< HEAD
=======
            /**
             * Gestiona la asistencia de los alumnos
             *
             * Carga los datos de los alumnos y las asistencias de hoy desde el modelo.
             *
             */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
            public function gestionar(){
                $this->vista = 'vControlAsistencia';    
                $datos ['alumnos'] = $this->objModelo->listarAlumnos();
                $datos ['asistencias'] = $this->objModelo->asistenciaHoy();
                $datos ['fecha'] = date('d/m/Y');
                $datos ['esDiaLectivo'] = $this->objModelo->esDiaLectivo(date('Y-m-d'));

                return $datos;
            }
<<<<<<< HEAD

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

=======
            /**
             * Registra la asistencia de un alumno
             *
             * Recibe los datos del alumno y la asistencia desde el formulario.
             * 
             */
            public function registrarAsistencia(){
                header('Content-Type: application/json');
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $idAlumno = isset($_POST['idAlumno']) ? intval($_POST['idAlumno']) : null;
                    $asiste = isset($_POST['asiste']) ? intval($_POST['asiste']) : null;
                    
                    if ($idAlumno !== null && $asiste !== null) {
                        $resultado = $this->objModelo->registrarAsistencia($idAlumno, $asiste === 1);
                        echo json_encode(['success' => $resultado]);
                        exit;
                    }
                }
                
                echo json_encode(['success' => false]);
                exit;
            }
            /**
             * Modifica la asistencia de un alumno
             *
             * Recibe los datos del alumno y la asistencia desde el formulario.
             *
             */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
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
                    
<<<<<<< HEAD
                    // Convertir el nombre del mes
                    $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                             'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                    $datos['fecha'] = "$dia DE " . $meses[$mes - 1] . " $anio";
=======
                    $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                             'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                    $datos['fecha'] = "$dia DE " . $meses[$mes - 1] . " $anio"; // se resta 1 porque los meses en PHP van de 0 a 11
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
                }
                
                return $datos;
            }
<<<<<<< HEAD

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

=======
            /**
             * Obtiene la asistencia de un alumno para una fecha específica
             *
             * Recibe los datos del alumno y la fecha desde el formulario.
             *
             */
            public function obtenerAsistenciaFecha(){
                $this->vista = 'vModAsistencia';
                if (isset($_POST['fecha']) && !empty($_POST['fecha'])) {
                    $fecha = $_POST['fecha'];
            
                    //Convertir la fecha al formato deseado (DD DE MES YYYY)
                    $fechaFormateada = date('d \d\e F Y', strtotime($fecha));
                    $fechaFormateada = mb_strtoupper($fechaFormateada);
            
                    $alumnos = $this->objModelo->listarAlumnos();
                    $asistencias = $this->objModelo->asistenciaFecha($fecha);
                    
                    return [
                        'alumnos' => $alumnos, 
                        'asistencias' => $asistencias,
                        'fecha' => $fechaFormateada
                    ];
                }
                return [];
            }
            /**
             * Modifica la asistencia de un alumno para una fecha específica
             *
             * Recibe los datos del alumno, la fecha y la asistencia desde el formulario.
             *
             */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
            public function modificarAsistencia(){
                $idAlumno = $_POST['idAlumno'];
                $fecha = $_POST['fecha'];
                $asiste = $_POST['asiste'];
                
                $resultado = $this->objModelo->modificarAsistencia($idAlumno, $fecha, $asiste);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => $resultado]);
                exit;
            }
<<<<<<< HEAD


        
=======
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    }