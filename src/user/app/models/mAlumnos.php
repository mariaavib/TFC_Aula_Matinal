<?php
<<<<<<< HEAD
=======
/**
 * Modelo MAlumnos
 * 
 * Modelo para gestionar alumnos, se encarga de insertar, modificar, eliminar y consultar alumnos 
 * e información relacionada con ellos.
 * 
 */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    class MAlumnos{
        private $conexion;

        public function __construct(){
            require_once('conexion.php');
            $objConexion = new Conexion();
            $this->conexion = $objConexion->conexion;
        }

<<<<<<< HEAD
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

=======
        /**
         * Metodo para obtener todas las clases disponibles.
         *
         * @return array Lista de clases.
         * 
         */
        public function obtenerClases() {
            $sql = "SELECT idClase, clase FROM clases ORDER BY clase";
            $resultado = $this->conexion->query($sql);
            if (!$resultado) {
                return [];
            }
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
    
        /**
         * Metodo para insertar un nuevo alumno en la base de datos.
         *
         * @param string $nombreAlumno Nombre del alumno.
         * @param string $apellidosAlumno Apellidos del alumno.
         * @param string $nombrePadre Nombre del padre del alumno.
         * @param string $apellidosPadre Apellidos del padre del alumno.
         * @param string $telefono Telefono del padre del alumno.
         * @param int $idClase ID de la clase a la que pertenece el alumno.
         * @return bool true si la insercion fue exitosa, false en caso contrario.
         */
        public function insertarAlumno($nombreAlumno, $apellidosAlumno, $nombrePadre, $apellidosPadre, $telefono, $idClase) {
            $sql = "INSERT INTO inscripciones (nombrePadre, apellidosPadre, telefono, completada) VALUES (?, ?, ?, 0)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sss", $nombrePadre, $apellidosPadre, $telefono);
            $stmt->execute();
            $idInscripcion = $this->conexion->insert_id; // Obtener el ID de la inscripción recién insertada
    
            $sql = "INSERT INTO alumno (nombreAlumno, apellidosAlumno, idInscripcion, idClase) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssii", $nombreAlumno, $apellidosAlumno, $idInscripcion, $idClase);
            return $stmt->execute();
        }
        /**
         * Metodo para obtener todos los alumnos de la base de datos.
         * 
         *
         * @param int $idAlumno ID del alumno.
         * @return array Lista de alumnos.
         */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
        public function obtenerAlumnos(){
            $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, 
                           inscripciones.telefono 
                    FROM alumno 
                    INNER JOIN inscripciones ON alumno.idInscripcion = inscripciones.idInscripcion 
                    ORDER BY alumno.nombreAlumno";
            
            $resultado = $this->conexion->query($sql);
<<<<<<< HEAD
            if ($resultado === false) {
=======
            if (!$resultado){
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
                return [];
            }
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
<<<<<<< HEAD

        public function obtenerDetallesAlumno($idAlumno){
            $sql = "SELECT inscripciones.nombrePadre, inscripciones.telefono, 
                           alumno.nombreAlumno
                    FROM inscripciones 
                    INNER JOIN alumno ON inscripciones.idInscripcion = alumno.idInscripcion 
                    WHERE alumno.idAlumno = ?";
            
=======
        /**
         * Metodo para obtener detalles de un alumno especifico.
         * 
         * @param int $idAlumno ID del alumno.
         * @return array Detalles del alumno.
         */
        public function obtenerDetallesAlumno($idAlumno){
            $sql = "SELECT inscripciones.nombrePadre, inscripciones.telefono, inscripciones.apellidosPadre,
                           alumno.nombreAlumno, clases.clase
                    FROM inscripciones 
                    INNER JOIN alumno ON inscripciones.idInscripcion = alumno.idInscripcion 
                    INNER JOIN clases ON alumno.idClase = clases.idClase
                    WHERE alumno.idAlumno = ? ";
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $idAlumno);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
<<<<<<< HEAD

        public function obtenerDetallesAlumnos($idAlumno){
            $sql = "SELECT inscripciones.nombrePadre, inscripciones.telefono, alumno.no mbreAlumno, clases.clase FROM inscripciones INNER JOIN alumno ON inscripciones.idInscripcion = alumno.idInscripcion INNER JOIN clases ON alumno.idClase = clases.idClase WHERE alumno.idAlumno = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $idAlumno);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
=======
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    }