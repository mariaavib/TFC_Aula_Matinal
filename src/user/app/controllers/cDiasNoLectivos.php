<?php
<<<<<<< HEAD
=======
/**
 * Controlador CDiasNoLectivos
 * Este controlador se encarga de manejar los días no lectivos o festivos.
 * Se comunica con el modelo para obtener la información de los días festivos
 * y preparar la vista del calendario.
 */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
class CDiasNoLectivos {
    private $modelo;
    public $vista;

    public function __construct(){
        require_once(RUTA_MODELOS . 'DiasNoLectivos.php');
        $this->modelo = new MDiasNoLectivos();
    }

<<<<<<< HEAD
    // Método para obtener los días festivos en formato JSON
    public function diasFestivos(){
=======
    /**
     * Obtiene los días no lectivos en formato JSON para el calendario.
     */
    public function obtenerDiasNoLectivos(){
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
        header('Content-Type: application/json');
        $eventos = $this->modelo->getDiasFestivos();
        echo json_encode($eventos);
        exit;
    }
<<<<<<< HEAD
=======
    /**
     * Prepara la vista del calendario.
     */
>>>>>>> b4d2b36cb88c356ef6feddce79abd2a29cdcaa71
    public function verCalendario(){
        $this->vista = 'vCalendario';
        return [];
    }
}
