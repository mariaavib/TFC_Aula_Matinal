<?php

class mGenerarPdf{
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }

    public function listar_alumnosinscritos(){
        $sql = "SELECT a.nombreAlumno,
                    a.apellidosAlumno,
                    c.clase,
                    i.nombrePadre,
                    i.apellidosPadre,
                    i.nombrePadre,
                    i.DNI,
                    i.IBAN,
                    i.titularCuenta,
                    i.fechaMandato,
                    i.telefono,
                    i.correo
                FROM alumno a
                INNER JOIN clases c ON a.idClase = c.idClase
                INNER JOIN inscripciones i ON a.idInscripcion = i.idInscripcion
                WHERE i.completada = 1
                ORDER BY a.nombreAlumno ASC;";
        $resultado = $this->conexion->query($sql);

        if ($resultado->num_rows === 0) {
            return false;
        }else{
            $alumnos = [];
            while($fila = $resultado->fetch_assoc()){
                $alumnos[] = $fila;
            }

            return $alumnos;
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
        $datos['noalumnos']="No hay alumnos inscritos";
        return $datos;
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