<?php
class CGestionInscripciones{
    private $obj_modelo;
    public $vista;

    public $mensajes;

    public function __construct(){
        require_once(RUTA_MODELOS.'GestionInscripciones.php');
        $this->obj_modelo = new MGestionInscripciones();
    }

    public function alta(){
        $this->vista = 'vAltaInscripcion';
        $datos = $this->obj_modelo->listarclases();
        return $datos;
    }

    // Función auxiliar para validar campos requeridos
    private function validarRequerido($campo, $nombreCampo, &$errores) {
        if (empty(trim($campo))) {
            
            $errores[] = "El campo '{$nombreCampo}' es obligatorio.";
            return false;
        }
        return true;
    }

    // Función auxiliar para validar DNI, NIE o Pasaporte
    private function validarDocumentoIdentidad($documento, &$errores) {
        $dniNieRegex = '/^([0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE])|(X|Y|Z)[0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
        $pasaporteRegex = '/^[A-Z0-9]{6,20}$/i';

        //preg_match() realiza una búsqueda de una expresión regular en una cadena. 
        //Devuelve true si la expresión regular ( pattern ) se encuentra en la cadena ( subject ), 
        //y false en caso contrario.
        if (!preg_match($dniNieRegex, $documento) && !preg_match($pasaporteRegex, $documento)) {
            $errores[] = "El DNI/NIE/Pasaporte no es válido.";
            return false;
        }
        return true;
    }

    // Función auxiliar para validar IBAN
    private function validarIBAN($iban, &$errores) {

        //str_replace() --> elimina los espacios en blanco del IBAN antes de validar con la expresión regular
        $iban_limpio = str_replace(' ', '', $iban);
        if (!preg_match('/^[A-Z]{2}[0-9A-Z]{2,32}$/i', $iban_limpio) || strlen($iban_limpio) > 34) {
            $errores[] = "El IBAN no es válido (debe empezar con 2 letras, máximo 34 caracteres).";
            return false;
        }
        return true;
    }

    // Función auxiliar para validar teléfono
    private function validarTelefono($telefono, &$errores) {
        if (!preg_match('/^\+?[0-9]{1,19}$/', $telefono) || strlen($telefono) > 20) {
            $errores[] = "El teléfono no es válido (puede contener '+' al inicio, numérico, máximo 20 caracteres).";
            return false;
        }
        return true;
    }

    // Función auxiliar para validar correo
    private function validarCorreo($correo, &$errores) {

        //filter_var() filtra una variable con el filtro especificado.
        //FILTER_VALIDATE_EMAIL --> valida si la cadena es un correo electrónico válido.
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
            return false;
        }
        return true;
    }

    public function insertar(){
        $errores = [];

        // Recopilar datos del tutor
        $nombre_tutor = $_POST['nombre_tutor'] ?? '';
        $apellidos_tutor = $_POST['apellidos_tutor'] ?? '';
        $dni = $_POST['dni'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $iban = $_POST['iban'] ?? '';
        $titular = $_POST['titular'] ?? '';
        $fechamandato = $_POST['fechamandato'] ?? '';

        // Validar datos del tutor
        $this->validarRequerido($nombre_tutor, 'Nombre del tutor', $errores);
        $this->validarRequerido($apellidos_tutor, 'Apellidos del tutor', $errores);
        $this->validarRequerido($dni, 'DNI', $errores) && $this->validarDocumentoIdentidad($dni, $errores);
        $this->validarRequerido($telefono, 'Teléfono', $errores) && $this->validarTelefono($telefono, $errores);
        $this->validarRequerido($correo, 'Correo', $errores) && $this->validarCorreo($correo, $errores);
        $this->validarRequerido($iban, 'IBAN', $errores) && $this->validarIBAN($iban, $errores);
        $this->validarRequerido($titular, 'Titular de la cuenta', $errores);
        $this->validarRequerido($fechamandato, 'Fecha de mandato', $errores);

        // Recopilar datos del alumno
        $nombre_alumno = $_POST['nombre_alumno'] ?? '';
        $apellidos_alumno = $_POST['apellidos_alumno'] ?? '';
        $clase = $_POST['clase'] ?? '';

        // Validar datos del alumno
        $this->validarRequerido($nombre_alumno, 'Nombre del alumno', $errores);
        $this->validarRequerido($apellidos_alumno, 'Apellidos del alumno', $errores);
        $this->validarRequerido($clase, 'Clase', $errores); // Usar validarRequerido en lugar de noDejarVacío

        // Si hay errores, redirigir de vuelta al formulario con los mensajes de error
        if (!empty($errores)) {
            $this->vista = 'vAltaInscripcion';
            $datos = $this->obj_modelo->listarclases();
            $datos['errores'] = $errores; // Pasar el array de errores dentro de 'datos'
            return $datos;
        }

        // Si no hay errores, preparar los datos para el modelo
        $datos_inscripcion = [
            'nombre_tutor' => $nombre_tutor,
            'apellidos_tutor' => $apellidos_tutor,
            'dni' => $dni,
            'iban' => $iban,
            'titular' => $titular,
            'fechamandato' => $fechamandato,
            'telefono' => $telefono,
            'email' => $correo,
            'nombre_alumno' => $nombre_alumno,
            'apellidos_alumno' => $apellidos_alumno,
            'clase' => $clase
        ];

        // Llamar al modelo para guardar la inscripción
        if ($this->obj_modelo->guardarInscripcion($datos_inscripcion)) {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            $datos['mensaje_exito'] = 'Se ha añadido al alumno correctamente'; // Pasar como array dentro de 'datos'
            return $datos;
        } else {
            $this->vista = 'vAltaInscripcion';
            $datos = $this->obj_modelo->listarclases();
            $datos['errores'] = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
            return $datos;
        }
    }

    public function alumnosinscritos(){
        $this->vista = 'vAlumnosInscritos';
        $datos = $this->obj_modelo->alumnosinscritos();
        if(isset($datos['noalumnos'])){
            return $datos;
        }else{
            return $datos; //si no es un string, es un array con los datos de los alumnos inscritos
        }
    }

    public function consultardatos(){
        $this->vista = 'vConsultarDatos';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
        }
        
        if(is_string($datos)){
            $this->mensajes = $datos;
            return $this->mensajes; 
        }else{
            return $datos; //si no es un string, es un array con los datos del alumno
        }
    }

    public function modificacion(){
        $this->vista = 'vModificarInscripcion';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
            $clases = $this->obj_modelo->listarclases();
        }
        
        if(is_string($datos) && is_string($clases)){
            $this->mensajes = $datos;
            return $this->mensajes; 
        }else{
            return [
                'datos' => $datos,
                'clases' => $clases
            ]; 
        }
    }

    public function modificarInscripcion(){
        print_r($_POST);
        if(isset($_POST)){
            $datos = array(
                'nombre_Padre' => $_POST['nombre_tutor'],
                'apellidos_Padre' => $_POST['apellidos_tutor'],
                'DNI' => $_POST['dni'],
                'IBAN' => $_POST['iban'],
                'titular' => $_POST['titular'],
                'fechamandato' => $_POST['fechamandato'],
                'correo' => $_POST['correo'],
                'nombreAlumno' => $_POST['nombreAlumno'],
                'idclase' => $_POST['clase'],
                'idInscripcion' => $_POST['idInscripcion']
            );        
            
        if ($_POST['accion'] === 'completar') {
            $datos['completada'] = 1;
        } else if ($_POST['accion'] === 'guardar_pendiente') {
            $datos['completada'] = 0;
        } else if ($_POST['accion'] === 'guardar') {
            $datos['completada'] = 1;
        }
        }


    }

    public function inscripcionesincompletas(){
        $this->vista = 'vInscripcionesIncompletas';
        $datos = $this->obj_modelo->inscripcionesincompletas();
        if(is_string($datos)){
            $this->mensajes = $datos;
            return $this->mensajes;
        }else{
            return $datos; //si no es un string, es un array con los datos de los alumnos inscritos
        }
    }
}


?>