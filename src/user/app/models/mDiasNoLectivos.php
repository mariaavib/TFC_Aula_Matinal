<?php
/**
 * Modelo MDiasNoLectivos
 * 
 * Este modelo se encarga de gestionar los días festivos en la base de datos.
 */
class MDiasNoLectivos {
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }
    /**
     * Selecciona todos los días festivos de la base de datos.
     *
     * @return array Un array de arrays asociativos con los datos de los días festivos.
     */
    public function getDiasFestivos(){
        $sql = "SELECT fecha, motivo FROM dias_no_lectivos";
        $resultado = $this->conexion->query($sql);

        $festivos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $festivos[] = [
                'title' => $fila['motivo'],
                'start' => $fila['fecha'],
                'allDay' => true
            ];
        }
        return $festivos;
    }
}