<?php
class MGestionInscripciones{
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }

    public function listarclases(){
        $sql = "SELECT * FROM clases";
        $resultado = $this->conexion->query($sql);

        $clases = [];
        while($fila = $resultado->fetch_assoc()){
            $clases[] = $fila;
        }

        return $clases;
    }

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

    public function modificarInscripcion($datos){
    // Iniciar transacción
    $this->conexion->begin_transaction();
    
    try {
        // Actualizar tabla inscripciones
        $sqlInscripcion = "UPDATE inscripciones 
                            SET nombrePadre = ?, 
                                DNI = ?, 
                                IBAN = ?, 
                                titularCuenta = ?, 
                                fechaMandato = ?, 
                                correo = ?
                            WHERE idInscripcion = ?";
        
        $stmtInscripcion = $this->conexion->prepare($sqlInscripcion);
        $stmtInscripcion->bind_param("ssssssi", 
            $datos['nombrePadre'],
            $datos['DNI'],
            $datos['IBAN'],
            $datos['titularCuenta'],
            $datos['fechaMandato'],
            $datos['correo'],
            $datos['idInscripcion']
        );
        
        $stmtInscripcion->execute();
        $stmtInscripcion->close();
        
        // Actualizar tabla alumno
        $sqlAlumno = "UPDATE alumno 
                        SET nombreAlumno = ?, 
                            idClase = ?
                        WHERE idInscripcion = ?";
        
        $stmtAlumno = $this->conexion->prepare($sqlAlumno);
        $stmtAlumno->bind_param("sii", 
            $datos['nombreAlumno'],
            $datos['idClase'],
            $datos['idInscripcion']
        );
        
        $stmtAlumno->execute();
        $stmtAlumno->close();
        
        // Confirmar transacción
        $this->conexion->commit();
        return true;
        
    } catch (Exception $e) {
        // Revertir en caso de error
        $this->conexion->rollback();
        return false;
    }
}

    public function alumnosinscritos(){
        $sql = "SELECT a.idAlumno,
                    a.nombreAlumno,
                    c.clase,
                    i.idInscripcion
                FROM alumno a
                INNER JOIN clases c ON a.idClase = c.idClase
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE i.completada = 1;";
        $resultado = $this->conexion->query($sql);

        if ($resultado->num_rows === 0) {
            $datos['noalumnos'] = 'No hay alumnos inscritos';
            return $datos;
        }else{
            $alumnos = [];
            while($fila = $resultado->fetch_assoc()){
                $alumnos[] = $fila;
            }

            return $alumnos;
        }
    }
    
    public function datosAlumnosinscritos($id){
        $sql = "SELECT *
                FROM alumno a
                INNER JOIN clases c ON a.idClase = c.idClase
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE a.idAlumno = ?;";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            $stmt->close();
            return 'Error en la base de datos';
        }

        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            $stmt->close();
            return 'Alumno no encontrado';
        }else{
            $fila = $resultado->fetch_assoc();
            $stmt->close();
        
            return $fila;
        }
    }

    

    public function inscripcionesincompletas(){
        $sql = "SELECT a.idAlumno,
                    a.nombreAlumno,
                    i.telefono,
                    i.idInscripcion
                FROM alumno a
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE i.completada = 0;";
        $resultado = $this->conexion->query($sql);

        if ($resultado->num_rows === 0) {
            return 'No hay inscripciones por completar';
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