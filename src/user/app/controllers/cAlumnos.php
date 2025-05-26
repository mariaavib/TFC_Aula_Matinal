<?php
/**
 * Controlador CAlumnos
 * 
 * Se encarga de controlar todo lo relacionado con los alumnos,
 * mostrar el formulario de alta, insertar, consultar y obtener detalles de los alumnos
 */
    class CAlumnos {
            private $objModelo;
            public $vista;    

            function __construct(){
                require_once(RUTA_MODELOS.'Alumnos.php');
                $this->objModelo = new MAlumnos(); 
            }
            /**
             * Muestra el formulario de alta de alumnos
             */
            public function alta() {
                $this->vista = 'vAltaAlumno';
                return [];
            }
            /**
             * Inserta un nuevo alumno en la base de datos y redirige a la vista de control de asistencia
             */
            public function insertar(){
                $nombreAlumno = $_POST['nombreAlumno'];
                $telefono = $_POST['telefono'];
                $fechaMandato = date('Y-m-d');

                $resultado = $this->objModelo->insertarAlumno($nombreAlumno, $telefono, $fechaMandato);

                if($resultado){
                    header('Location: index.php?c=ControlAsistencia&m=gestionar');  
                }else{
                    $this->vista = 'vAltaAlumno';
                    return ['error' => 'Error al insertar el alumno'];
                }
            }
            /**
             * Muestra la vista de consulta de alumnos y obtiene la lista de alumnos
             * 
             */
            public function consultar() {
                $this->vista = 'vConsultaAlumnos';
                $datos['alumnos'] = $this->objModelo->obtenerAlumnos();
                return $datos;
            }
            /**
             * Obtiene los detalles de un alumno y los devuelve en formato JSON
             */
            public function obtenerDetalles() {
                /**
                 * Obtiene los detalles de un alumno y los devuelve en formato JSON
                 */
                header('Content-Type: application/json');
                if(isset($_GET['id'])){
                    $idAlumno = $_GET['id'];
                }else{
                    $idAlumno = 0;
                }
                $alumno = $this->objModelo->obtenerDetallesAlumno($idAlumno);
                
                if ($alumno) {
                    /**
                     * Si el alumno existe, se devuelve en formato JSON
                     */
                    echo json_encode([
                        'success' => true,
                        'alumno' => $alumno
                    ]);
                } else {
                    /**
                     * Si el alumno no existe, se devuelve un mensaje de error en formato JSON
                     */
                    echo json_encode([
                        'success' => false,
                        'message' => 'Alumno no encontrado'
                    ]);
                }
                exit;
            }
    }
?>