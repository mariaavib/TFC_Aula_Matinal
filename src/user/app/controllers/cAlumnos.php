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
        $datos['clases'] = $this->objModelo->obtenerClases();
        return $datos;
    }
    /**
     * Inserta un nuevo alumno en la base de datos y redirige a la vista de control de asistencia
     */
    public function insertar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['nombreAlumno'])) {
                    $nombreAlumno = $_POST['nombreAlumno'];
                } else {
                    $nombreAlumno = '';
                }
            
                if (isset($_POST['apellidosAlumno'])) {
                    $apellidosAlumno = $_POST['apellidosAlumno'];
                } else {
                    $apellidosAlumno = '';
                }
            
                if (isset($_POST['nombrePadre'])) {
                    $nombrePadre = $_POST['nombrePadre'];
                } else {
                    $nombrePadre = '';
                }
            
                if (isset($_POST['apellidosPadre'])) {
                    $apellidosPadre = $_POST['apellidosPadre'];
                } else {
                    $apellidosPadre = '';
                }
            
                if (isset($_POST['telefono'])) {
                    $telefono = $_POST['telefono'];
                } else {
                    $telefono = '';
                }
            
                if (isset($_POST['idClase'])) {
                    $idClase = $_POST['idClase'];
                } else {
                    $idClase = '';
                }
            }

            if (empty($nombreAlumno) || empty($apellidosAlumno) || empty($nombrePadre) || empty($apellidosPadre) || empty($telefono) || empty($idClase)) {
                $this->vista = 'vAltaAlumno';
                $clases = $this->objModelo->obtenerClases();
                return [
                    'error' => 'Todos los campos son obligatorios',
                    'clases' => $clases,
                    'datosForm' => $_POST
                ];
            }
    
            if (!preg_match('/^\+?[1-9][0-9]{7,14}$/', $telefono) || strlen($telefono) > 24) {
                $this->vista = 'vAltaAlumno';
                $clases = $this->objModelo->obtenerClases();
                return [
                    'error' => 'El teléfono no es válido',
                    'clases' => $clases,
                    'datosForm' => $_POST
                ];
            }
            $resultado = $this->objModelo->insertarAlumno($nombreAlumno, $apellidosAlumno, $nombrePadre, $apellidosPadre, $telefono, $idClase);
            if ($resultado) {
                header('Location: index.php?c=ControlAsistencia&m=gestionar&mens=b');
                exit();
            } else {
                $this->vista = 'vAltaAlumno';
                $clases = $this->objModelo->obtenerClases();
                return [
                    'error' => 'Error al insertar el alumno',
                    'clases' => $clases,
                    'datosForm' => $_POST
                ];
            }
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