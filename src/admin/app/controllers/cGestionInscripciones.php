<?php
class CGestionInscripciones{
    private $obj_modelo;
    public $vista;

    public $mensajes;

    public function __construct(){
        require_once(RUTA_MODELOS.'GestionInscripciones.php');
        $this->obj_modelo = new MGestionInscripciones();
    }

    /**
     * Método que comprueba los campos del formulario de alta de inscripciones
     * @return array
     */
    public function alta(){
        $this->vista = 'vAltaInscripcion';
        $clases = $this->obj_modelo->listarclases();

        return ['clases' => $clases];
    }

    public function alumnosinscritos(){
        $this->vista = 'vAlumnosInscritos';
        $datos = $this->obj_modelo->alumnosinscritos();
        if(isset($datos['noalumnos'])){
            return $datos;
        }else{
            $datos['datos'] = $datos;
            return $datos;
        }   
    }
    public function inscripcionesincompletas(){
        $this->vista = 'vInscripcionesIncompletas';
        $datos = $this->obj_modelo->inscripcionesincompletas();
        if(isset($datos['noincompletas'])){
            return $datos;
        }else{
            $datos['datos'] = $datos;
            return $datos; //si no es un string, es un array con los datos de los alumnos inscritos
        }
    }

    public function consultardatos(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
        }
        if(isset($datos['errores'])){
            $this->vista = 'vAlumnosInscritos';
            $datos['datos'] = $this->obj_modelo->alumnosinscritos();
            return ['datos'=> $datos['datos'], 'errores'=> $datos['errores']];
        }else{
            $this->vista = 'vConsultarDatos';
            return $datos;
        }
    }

    public function completarInscripcion(){
        $this->vista = 'vCompletarInscripcion';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
            $clases = $this->obj_modelo->listarclases();
        }
        
        if(isset($datos['errores'])){
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->listarclases();
            $datos['errores'] = 'Alumno no encontrado'; // Pasar como array dentro de 'datos'
            return $datos;
        }else{
            return [
                'datos' => $datos,
                'clases' => $clases,
                'id_inscripcion' => $id
            ]; 
        }
    }

    public function modificacionInscripcion(){
        $this->vista = 'vModificarInscripcion';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
            $clases = $this->obj_modelo->listarclases();
        }
        
        if(is_string($datos) && is_string($clases)){
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->listarclases();
            $datos['errores'] = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
            return $datos;
        }else{
            return [
                'datos' => $datos,
                'clases' => $clases,
                'id_inscripcion' => $id
            ]; 
        }
    }



    public function insertar(){
        $errores = [];
        $datos = $_POST;

        $errores = $this->validarcampos_completarinscripcion();
        // Si hay errores, redirigir de vuelta al formulario con los mensajes de error
        if (!empty($errores)) {
            $this->vista = 'vAltaInscripcion';
            $clases = $this->obj_modelo->listarclases();
            $datos['errores'] = $errores; // Pasar el array de errores dentro de 'datos'
            return [
                'datos' => $datos,
                'clases' => $clases,
                'errores' => $errores
            ];
        }else{
            $datos_inscripcion = [
                'nombre_tutor' => $_POST['nombrePadre'],
                'apellidos_tutor' => $_POST['apellidosPadre'],
                'dni' => $_POST['DNI'],
                'iban' => $_POST['IBAN'],
                'titular' => $_POST['titularCuenta'],
                'fechamandato' => $_POST['fechaMandato'],
                'telefono' => $_POST['telefono'],
                'email' => $_POST['correo'],
                'nombre_alumno' => $_POST['nombreAlumno'],
                'apellidos_alumno' => $_POST['apellidosAlumno'],
                'clase' => $_POST['idClase'],
            ];

        if ($this->obj_modelo->guardarInscripcion($datos_inscripcion)) {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            if(isset($datos['noalumnos'])){
                return $datos;
            }else{
                return ['datos' => $datos, 
                        'mensaje_exito' => 'Se ha añadido al alumno correctamente'];
            }
        } else {
            $this->vista = 'vAltaInscripcion';
            $datos = $this->obj_modelo->listarclases();
            $datos['errores'] = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
            return $datos;
        }
    }
}

    public function procesosCompletado(){
        $id = $_GET['id'];
        $datos = $_POST;
    
        if(isset($_POST['accion']) && $_POST['accion'] == 'completar'){

            $errores = $this->validarcampos_completarinscripcion();

            if (!empty($errores)) {
                $this->vista = 'vCompletarInscripcion';
                $clases = $this->obj_modelo->listarclases();

                return [
                    'datos' => $datos,
                    'clases' => $clases,
                    'errores' => $errores,
                    'id_inscripcion' => $id
                ]; 
            }else{
                $datos_inscripcion = [
                    'id' => $id,
                    'nombre_tutor' => $_POST['nombrePadre'],
                    'apellidos_tutor' => $_POST['apellidosPadre'],
                    'dni' => $_POST['DNI'],
                    'iban' => $_POST['IBAN'],
                    'titular' => $_POST['titularCuenta'],
                    'fechamandato' => $_POST['fechaMandato'],
                    'telefono' => $_POST['telefono'],
                    'email' => $_POST['correo'],
                    'nombre_alumno' => $_POST['nombreAlumno'],
                    'apellidos_alumno' => $_POST['apellidosAlumno'],
                    'clase' => $_POST['idClase'],
                    'completada' =>1
                ];

                if ($this->obj_modelo->modificarInscripcion($datos_inscripcion)) {
                    $this->vista = 'vInscripcionesIncompletas';
                    $datos = $this->obj_modelo->inscripcionesincompletas();
                    return ['datos' => $datos, 'mensaje_exito' => "Se ha completado correctamente la inscripción de {$datos_inscripcion['nombre_alumno']}"];
                } else {
                    $this->vista = 'vInscripcionesIncompletas';
                    $datos = $this->obj_modelo->inscripcionesincompletas();
                    $clases = $this->obj_modelo->listarclases();
                    $errores = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
                    return [
                        'datos' => $datos,
                        'clases' => $clases,
                        'errores' => $errores
                    ]; 
                }
            }
        }

        if(isset($_POST['accion']) && $_POST['accion'] == 'guardar_pendiente'){
            $errores = $this->validarcampos_guardarpendiente();

            if (!empty($errores)) {
                $this->vista = 'vCompletarInscripcion';
                $clases = $this->obj_modelo->listarclases();

                return [
                    'datos' => $datos,
                    'clases' => $clases,
                    'errores' => $errores,
                    'id_inscripcion' => $id
                ]; 
            }else{
                $datos_inscripcion = [
                    'id' => $id,
                    'nombre_tutor' => $_POST['nombrePadre'],
                    'apellidos_tutor' => $_POST['apellidosPadre'],
                    'dni' => $_POST['DNI'],
                    'iban' => $_POST['IBAN'],
                    'titular' => $_POST['titularCuenta'],
                    'fechamandato' => $_POST['fechaMandato'],
                    'telefono' => $_POST['telefono'],
                    'email' => $_POST['correo'],
                    'nombre_alumno' => $_POST['nombreAlumno'],
                    'apellidos_alumno' => $_POST['apellidosAlumno'],
                    'clase' => $_POST['idClase'],
                    'completada' =>0
                ];

                if ($this->obj_modelo->modificarInscripcion($datos_inscripcion)) {
                    $this->vista = 'vInscripcionesIncompletas';
                    $datos = $this->obj_modelo->inscripcionesincompletas();
                    return ['datos' => $datos, 'mensaje_exito' => "Se ha guardado con datos pendientes la inscripción de {$datos_inscripcion['nombre_alumno']}"];
                } else {
                    $this->vista = 'vInscripcionesIncompletas';
                    $datos = $this->obj_modelo->inscripcionesincompletas();
                    $clases = $this->obj_modelo->listarclases();
                    $errores = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
                    return [
                        'datos' => $datos,
                        'clases' => $clases,
                        'errores' => $errores
                    ]; 
                }
            }
        }
    }

    public function modificarinscripcion_completa(){
        $id = $_GET['id'];
        $datos = $_POST;

        $errores = $this->validarcampos_completarinscripcion();
        
        // Si hay errores, redirigir de vuelta al formulario con los mensajes de error
        if (!empty($errores)) {
            $this->vista = 'vModificarInscripcion';
            $clases = $this->obj_modelo->listarclases();

            return [
                'datos' => $datos,
                'clases' => $clases,
                'errores' => $errores,
                'id_inscripcion' => $id
            ]; 
        }else{
            $datos_inscripcion = [
                'id' => $id,
                'nombre_tutor' => $_POST['nombrePadre'],
                'apellidos_tutor' => $_POST['apellidosPadre'],
                'dni' => $_POST['DNI'],
                'iban' => $_POST['IBAN'],
                'titular' => $_POST['titularCuenta'],
                'fechamandato' => $_POST['fechaMandato'],
                'telefono' => $_POST['telefono'],
                'email' => $_POST['correo'],
                'nombre_alumno' => $_POST['nombreAlumno'],
                'apellidos_alumno' => $_POST['apellidosAlumno'],
                'clase' => $_POST['idClase'],
                'completada' =>1
            ];

        if ($this->obj_modelo->modificarInscripcion($datos_inscripcion)) {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            return ['datos' => $datos, 'mensaje_exito' => "Se ha modificado correctamente los datos del alumno/a {$datos_inscripcion['nombre_alumno']}"];
        } else {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            $clases = $this->obj_modelo->listarclases();
            $errores = 'Error al guardar la inscripción en la base de datos.'; // Pasar como array dentro de 'datos'
            return [
                'datos' => $datos,
                'clases' => $clases,
                'errores' => $errores
            ]; 
        }
    }
}
    public function validarcampos_guardarpendiente(){
        $errores = [];

        $nombre_tutor = $_POST['nombrePadre'] ?? '';
        $apellidos_tutor = $_POST['apellidosPadre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $nombre_alumno = $_POST['nombreAlumno'] ?? '';
        $apellidos_alumno = $_POST['apellidosAlumno'] ?? '';
        $clase = $_POST['idClase'] ?? '';

        $this->validarRequerido($nombre_tutor, 'Nombre del tutor', $errores);
        $this->validarRequerido($apellidos_tutor, 'Apellidos del tutor', $errores);
        $this->validarRequerido($telefono, 'Teléfono', $errores) && $this->validarTelefono($telefono, $errores);
        $this->validarRequerido($nombre_alumno, 'Nombre del alumno', $errores);
        $this->validarRequerido($apellidos_alumno, 'Apellidos del alumno', $errores);
        $this->validarRequerido($clase, 'Clase', $errores);

        if(!empty($_POST['DNI'])){
            $dni = $_POST['DNI'];
            $this->validarDocumentoIdentidad($dni, $errores);
        }

        if(!empty($_POST['correo'])){
            $correo = $_POST['correo'];
            $this->validarCorreo($correo, $errores);
        }

        if (!empty($_POST['IBAN'])) {
            $iban = $_POST['IBAN'];
            $this->validarIBAN($iban, $errores);
        }

        return $errores;
    }
    

    private function validarRequerido($campo, $nombreCampo, &$errores) {
        if (empty(trim($campo)) || ($nombreCampo === 'Clase' && trim($campo) === 'SELECCIONE UNA CLASE')) {
            
            $errores[] = "El campo '{$nombreCampo}' es obligatorio.";
            return false;
        }
        return true;
    }

    private function validarDocumentoIdentidad($documento, &$errores) {
        // Valida tanto DNI como NIE
        $dniNieRegex = '/^([0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]|[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE])$/i';
        // Valida pasaporte
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

    private function validarIBAN($iban, &$errores) {

        //str_replace() --> elimina los espacios en blanco del IBAN antes de validar con la expresión regular
        $iban_limpio = str_replace(' ', '', $iban);
        // Validación estricta: 2 letras + 2 dígitos + 1-30 caracteres alfanuméricos
         if (!preg_match('/^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/i', $iban_limpio) || strlen($iban_limpio) > 34) {
            $errores[] = "El IBAN no es válido (debe empezar con 2 letras, 2 dígitos de control,  máximo 34 caracteres).";
            return false;
        }
        return true;
    }

    private function validarTelefono($telefono, &$errores) {
        if (!preg_match('/^\+?[1-9][0-9]{7,14}$/', $telefono) || strlen($telefono) > 24) {
            $errores[] = "El teléfono no es válido (puede contener '+' al inicio, de 1 a 3 dígitos del código del país, 4 a 14 dígitos de número nacional, SIN espacios).";
            return false;   
        }
        return true;
    }

    private function validarCorreo($correo, &$errores) {
        //filter_var() filtra una variable con el filtro especificado.
        //FILTER_VALIDATE_EMAIL --> valida si la cadena es un correo electrónico válido.
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
            return false;
        }
        return true;
    }
    public function validarcampos_completarinscripcion(){
        $errores = [];
            
        // Recopilar datos del tutor
        $nombre_tutor = $_POST['nombrePadre'] ?? '';
        $apellidos_tutor = $_POST['apellidosPadre'] ?? '';
        $dni = $_POST['DNI'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $iban = $_POST['IBAN'] ?? '';
        $titular = $_POST['titularCuenta'] ?? '';
        $fechamandato = $_POST['fechaMandato'] ?? '';

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
        $nombre_alumno = $_POST['nombreAlumno'] ?? '';
        $apellidos_alumno = $_POST['apellidosAlumno'] ?? '';
        $clase = $_POST['idClase'] ?? '';

        // Validar datos del alumno
        $this->validarRequerido($nombre_alumno, 'Nombre del alumno', $errores);
        $this->validarRequerido($apellidos_alumno, 'Apellidos del alumno', $errores);
        $this->validarRequerido($clase, 'Clase', $errores);

        return $errores;
    }   
}
?>