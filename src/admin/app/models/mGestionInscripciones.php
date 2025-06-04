<?php
class MGestionInscripciones{
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }

    /**
     * Método que devuelve las clases para los selects de los formularios de inscripción
     * @return array
     */
    public function listarclases(){
        $sql = "SELECT * FROM clases";
        $resultado = $this->conexion->query($sql);

        $clases = [];
        while($fila = $resultado->fetch_assoc()){
            $clases[] = $fila;
        }

        return $clases;
    }

    /**
     * Inserta los datos de la inscripciones que se realicen en el formulario de inscripción
     * @param mixed $datos
     * @return bool
     */
    public function guardarInscripcion($datos){
        // Iniciar transacción
        $this->conexion->begin_transaction();
        
        try {
            // Primero insertamos en la tabla inscripciones
            $sqlInscripcion = "INSERT INTO inscripciones (nombrePadre,apellidosPadre, DNI, IBAN, titularCuenta, 
                              fechaMandato, telefono, correo,completada) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
            
            $stmtInscripcion = $this->conexion->prepare($sqlInscripcion);
            $stmtInscripcion->bind_param("ssssssss", 
                $datos['nombre_tutor'],
                $datos['apellidos_tutor'],
                $datos['dni'],
                $datos['iban'],
                $datos['titular'],
                $datos['fechamandato'],
                $datos['telefono'],
                $datos['email']
            );
            
            $stmtInscripcion->execute();
            // Obtener el id de la inscripción
            $idInscripcion = $this->conexion->insert_id;
            $stmtInscripcion->close();
            
            // Luego insertamos en la tabla alumno
            $sqlAlumno = "INSERT INTO alumno (nombreAlumno, apellidosAlumno, idClase, idInscripcion) 
                         VALUES (?, ?, ?, ?)";
            
            $stmtAlumno = $this->conexion->prepare($sqlAlumno);
            $stmtAlumno->bind_param("ssii", 
                $datos['nombre_alumno'],
                $datos['apellidos_alumno'],
                $datos['clase'],
                $idInscripcion
            );
            
            $stmtAlumno->execute();
            $stmtAlumno->close();
            
            // Si todo va bien, confirmar la transacción
            $this->conexion->commit();
            return true;
            
        } catch (Exception $e) {
            // Si hay error, revertir la transacción
            $this->conexion->rollback();
            return false;
        }
    }

    /**
     * Método que modifica inscripciones
     * @param mixed $datos
     * @throws \Exception
     * @return bool
     */
    public function modificarInscripcion($datos){
        // Iniciar transacción
        $this->conexion->begin_transaction();
        
        try {
            // Actualizar tabla inscripciones
            $sqlInscripcion = "UPDATE inscripciones 
                            SET nombrePadre = ?, 
                                apellidosPadre = ?, 
                                DNI = ?, 
                                IBAN = ?, 
                                titularCuenta = ?, 
                                fechaMandato = ?, 
                                telefono = ?, 
                                correo = ?, 
                                completada = ? 
                            WHERE idInscripcion = ?";
            
            $stmtInscripcion = $this->conexion->prepare($sqlInscripcion);
            if(!$stmtInscripcion) {
                throw new Exception($this->conexion->error);
            }
            // Si no se ha introducido fecha de mandato, se pone null, para evitar errores de bbdd
            $fechaMandato = !empty($datos['fechamandato']) ? $datos['fechamandato'] : null;

            $stmtInscripcion->bind_param("ssssssssii",
                $datos['nombre_tutor'],
                $datos['apellidos_tutor'],
                $datos['dni'],
                $datos['iban'],
                $datos['titular'],
                $fechaMandato,
                $datos['telefono'],
                $datos['email'],
                $datos['completada'],
                $datos['id']
            );
            
            $stmtInscripcion->execute();
            if ($stmtInscripcion->errno) {
                throw new Exception($stmtInscripcion->error);
            }
            $stmtInscripcion->close();
            // Actualizar tabla alumno
            $sqlAlumno = "UPDATE alumno 
                            SET nombreAlumno = ?,
                                apellidosAlumno =?, 
                                idClase = ?
                            WHERE idInscripcion = ?";
            
            $stmtAlumno = $this->conexion->prepare($sqlAlumno);
            $stmtAlumno->bind_param("ssii", 
                $datos['nombre_alumno'],
                $datos['apellidos_alumno'],
                $datos['clase'],
                $datos['id']
            );
            
            $stmtAlumno->execute();
            
            // Confirmar transacción
            $this->conexion->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conexion->rollback();
            return false;
        }
    }

    /**
     * Método que devuelve los alumnos con inscripciones completadas
     * @return array
     */
    public function alumnosinscritos(){
        $sql = "SELECT a.idAlumno,
                    a.nombreAlumno,
                    a.apellidosAlumno,
                    c.clase,
                    i.idInscripcion
                FROM alumno a
                INNER JOIN clases c ON a.idClase = c.idClase
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE i.completada = 1;";
        $resultado = $this->conexion->query($sql);

        //Si no hay alumnos inscritos, devolver un array con el mensaje de error
        if ($resultado->num_rows === 0) {
            $datos['noalumnos'] = 'No hay alumnos inscritos';
            return $datos;

        //Si hay alumnos inscritos, devolver un array con los datos de los alumnos
        }else{
            $alumnos = [];
            while($fila = $resultado->fetch_assoc()){
                $alumnos[] = $fila;
            }
            return $alumnos;
        }
    }
    
    /**
     * Método que devuelve los datos de un alumno con un id en concreto.
     * @param mixed $id
     */
    public function datosAlumnosinscritos($id){
        $sql = "SELECT *
                FROM alumno a
                INNER JOIN clases c ON a.idClase = c.idClase
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE a.idInscripcion = ?;";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            $stmt->close();
            $datos['errores'] = 'Error en la base de datos';
            return $datos;
        }

        $resultado = $stmt->get_result();
        
        //Si no se encuentra al alumno, devolver un array con el mensaje de error
        if ($resultado->num_rows === 0) {
            $stmt->close();
            $datos['errores'] = 'Alumno no encontrado';
            return $datos;
        
        //Si se encuentra al alumno, devolver un array con los datos del alumno
        }else{
            $fila = $resultado->fetch_assoc();
            $stmt->close();
            return $fila;
        }
    }

    /**
     * Método que devuelve los alumnos con inscripciones incompletas
     * @return array
     */
    public function inscripcionesincompletas(){
        $sql = "SELECT a.idAlumno,
                    a.nombreAlumno,
                    i.telefono,
                    i.idInscripcion
                FROM alumno a
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE i.completada = 0;";
        $resultado = $this->conexion->query($sql);

        //Si no hay inscripciones incompletas, devolver un array con el mensaje de error
        if ($resultado->num_rows === 0) {
            $datos['noincompletas'] = 'No hay inscripciones incompletas';
            return $datos;

        //Si hay inscripciones incompletas, devolver un array con los datos de los alumnos
        }else{
            $alumnos = [];
            while($fila = $resultado->fetch_assoc()){
                $alumnos[] = $fila;
            }

            return $alumnos;
        }
    }
}
?>