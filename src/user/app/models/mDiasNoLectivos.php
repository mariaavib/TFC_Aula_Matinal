<?php
<<<<<<< HEAD
=======
/**
 * Modelo MDiasNoLectivos
 * 
 * Este modelo se encarga de gestionar los días festivos en la base de datos.
 */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
class MDiasNoLectivos {
    private $conexion;

    public function __construct(){
        require_once('conexion.php');
        $objConexion = new Conexion();
        $this->conexion = $objConexion->conexion;
    }
<<<<<<< HEAD

=======
    /**
     * Selecciona todos los días festivos de la base de datos.
     *
     * @return array Un array de arrays asociativos con los datos de los días festivos.
     */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    public function getDiasFestivos(){
        $sql = "SELECT fecha, motivo FROM dias_no_lectivos";
        $resultado = $this->conexion->query($sql);

        $festivos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $festivos[] = [
                'title' => $fila['motivo'],
                'start' => $fila['fecha'],
<<<<<<< HEAD
                'color' => '#ff4d4d'
=======
                'allDay' => true
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
            ];
        }
        return $festivos;
    }
}