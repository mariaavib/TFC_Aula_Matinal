<?php
/**
 * Modelo MAlumnos
 * 
 * Modelo para gestionar alumnos, se encarga de insertar, modificar, eliminar y consultar alumnos 
 * e información relacionada con ellos.
 * 
 */
    class MAlumnos{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }
        /**
         * Metodo para insertar un nuevo alumno en la base de datos.
         * Primero inserta en la tabla inscripciones y luego en la tabla alumno.
         * 
         * @param string $nombreAlumno Nombre del alumno.
         * @param string $telefono Teléfono del alumno.
         * @param string $fechaMandato Fecha de en la que se hace la inscripción.
         */
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
        /**
         * Metodo para obtener todos los alumnos de la base de datos.
         * 
         *
         * @param int $idAlumno ID del alumno.
         * @return array Lista de alumnos.
         */
        public function obtenerAlumnos(){
            $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, 
                           inscripciones.telefono 
                    FROM alumno 
                    INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion 
                    ORDER BY alumno.nombreAlumno";
            
            $resultado = $this->conexion->query($sql);
            if (!$resultado){
                return [];
            }
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        /**
         * Metodo para obtener detalles de un alumno especifico.
         * 
         * @param int $idAlumno ID del alumno.
         * @return array Detalles del alumno.
         */
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
    }