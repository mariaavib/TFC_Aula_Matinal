<?php

class MPanelAdmin{
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }

    /**
     * Obtiene el número de inscripciones completadas
     * @return array
     */
    public function num_inscripcionespendientes(){
        $sql = "SELECT COUNT(*) AS total 
                FROM inscripciones
                WHERE completada = 0;";

        $resultado = $this->conexion->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila;
    }
}


?>