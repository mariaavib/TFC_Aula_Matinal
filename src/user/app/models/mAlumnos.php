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
        
    }