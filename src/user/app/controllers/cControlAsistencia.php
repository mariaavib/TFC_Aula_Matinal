<?php
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
    class CControlAsistencia{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'ControlAsistencia.php');
                $this->objModelo = new MControlAsistencia(); 
            }
        
            /**
             * Gestiona la asistencia de los alumnos
             *
             * Carga los datos de los alumnos y las asistencias de hoy desde el modelo.
             *
             */
            public function gestionar(){
                $this->vista = 'vControlAsistencia';    
                $alumnos = $this->objModelo->listarAlumnos();
                $asistencias = $this->objModelo->asistenciaHoy();
                $fecha = date('d/m/Y');
                $esDiaLectivo = $this->objModelo->esDiaLectivo(date('Y-m-d'));
            
                $datos = [
                    'alumnos' => $alumnos,
                    'asistencias' => $asistencias,
                    'fecha' => $fecha,
                    'esDiaLectivo' => $esDiaLectivo,
                    'sinAlumnos' => empty($alumnos) 
                ];

                return $datos;
            }
            
            /**
             * Registra la asistencia de un alumno
             *
             * Recibe los datos del alumno y la asistencia desde el formulario.
             * 
             */
            public function registrarAsistencia(){
                header('Content-Type: application/json');
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['idAlumno'])) {
                        $idAlumno = $_POST['idAlumno']; 
                    } else {
                        $idAlumno = null;
                    }
                
                    if (isset($_POST['asiste'])) {
                        $asiste = $_POST['asiste']; 
                    } else {
                        $asiste = null;
                    }
                
                    if ($idAlumno !== null && $asiste !== null) {
                        $resultado = $this->objModelo->registrarAsistencia($idAlumno, $asiste == 1);
                        echo json_encode(['success' => $resultado]);
                        exit;
                    }
                }
                
                echo json_encode(['success' => false]);
                exit;
            }
            /**
             * Vista para modificar la asistencia de los alumnos
             */
            public function modificar() {
                $this->vista = 'vModAsistencia';
                $datos = [];

                return $datos;
            }
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
            
                    $meses = [
                        '01' => 'enero','02' => 'febrero','03' => 'marzo','04' => 'abril','05' => 'mayo','06' => 'junio','07' => 'julio',
                        '08' => 'agosto','09' => 'septiembre','10' => 'octubre','11' => 'noviembre','12' => 'diciembre',
                    ];

                    list($anio, $mes, $dia) = explode('-', $fecha);
                    $fechaFormateada = $dia.' de '.$meses[$mes].' de '.$anio;

            
                    $alumnos = $this->objModelo->listarAlumnos();
                    $asistencias = $this->objModelo->asistenciaFecha($fecha);
                    
                    return [
                        'alumnos' => $alumnos, 
                        'asistencias' => $asistencias,
                        'fecha' => $fechaFormateada,
                        'fechaSeleccionada' => $fecha  
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
            public function modificarAsistencia(){
                header('Content-Type: application/json');
                
                if (isset($_POST['idAlumno'])) {
                    $idAlumno = $_POST['idAlumno'];
                }

                if (isset($_POST['fecha'])) {
                    $fecha = $_POST['fecha'];
                }

                if (isset($_POST['asiste'])) {
                    $asiste = $_POST['asiste'];
                }

                if ($idAlumno === null || $fecha === null || $asiste === null) {
                    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
                    exit;
                }
            
                try {
                    $resultado = $this->objModelo->modificarAsistencia($idAlumno, $fecha, $asiste);
                    echo json_encode(['success' => $resultado]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
                exit;
            }
            
            /**
             * Verifica si un día es no lectivo
             *
             * Recibe la fecha desde el formulario. 
             * 
             */
            public function verificarDiaNoLectivo() {
                header('Content-Type: application/json');
                $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
            
                $resultado = $this->objModelo->esDiaNoLectivo($fecha);
            
                echo json_encode($resultado);
                exit;  
            }
    }