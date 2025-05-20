<?php
    class MAlumnos{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

        public function insertarAlumno($nombreAlumno, $telefono, $fechaMandato){
            $sql = "INSERT INTO inscripciones (telefono, fechaMandato, completada) VALUES (?, ?, 0)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $telefono, $fechaMandato);
            $stmt->execute();
            $idInscripcion = $this->conexion->insert_id; //devuelve el id de la ultima insercion

            $sql = "INSERT INTO alumno (nombreAlumno, idInscripcion) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("si", $nombreAlumno, $idInscripcion);
            return $stmt->execute();
        }

        public function obtenerAlumnos(){
            $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, 
                           inscripciones.telefono 
                    FROM alumno 
                    INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion 
                    ORDER BY alumno.nombreAlumno";
            
            $resultado = $this->conexion->query($sql);
            if ($resultado === false) {
                return [];
            }
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerDetallesAlumno($idAlumno){
            $sql = "SELECT inscripciones.nombrePadre, inscripciones.telefono, 
                           alumno.nombreAlumno
                    FROM inscripciones 
                    INNER JOIN alumno ON inscripciones.idInscripcion = alumno.idInscripcion 
                    WHERE alumno.idAlumno = ?";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $idAlumno);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function obtenerDetallesAlumnos($idAlumno){
            $sql = "SELECT inscripciones.nombrePadre, inscripciones.telefono, alumno.no mbreAlumno, clases.clase FROM inscripciones INNER JOIN alumno ON inscripciones.idInscripcion = alumno.idInscripcion INNER JOIN clases ON alumno.idClase = clases.idClase WHERE alumno.idAlumno = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $idAlumno);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }