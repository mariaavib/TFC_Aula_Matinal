<?php
class MDiasNoLectivos {
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }

    public function getDiasFestivos(){
        $sql = "SELECT fecha, motivo FROM dias_no_lectivos";
        $resultado = $this->conexion->query($sql);

        $festivos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $festivos[] = [
                'title' => $fila['motivo'],
                'start' => $fila['fecha'],
                'color' => '#ff4d4d'
            ];
        }
        return $festivos;
    }
}