<?php
/**
 * Controlador CDiasNoLectivos
 * Este controlador se encarga de manejar los días no lectivos o festivos.
 * Se comunica con el modelo para obtener la información de los días festivos
 * y preparar la vista del calendario.
 */
class CDiasNoLectivos {
    private $modelo;
    public $vista;

    public function __construct(){
        require_once(RUTA_MODELOS . 'DiasNoLectivos.php');
        $this->modelo = new MDiasNoLectivos();
    }

    /**
     * Obtiene los días no lectivos en formato JSON para el calendario.
     */
    public function obtenerDiasNoLectivos(){
        header('Content-Type: application/json');
        $eventos = $this->modelo->getDiasFestivos();
        echo json_encode($eventos);
        exit;
    }
    /**
     * Prepara la vista del calendario.
     */
    public function verCalendario(){
        $this->vista = 'vCalendario';
        return [];
    }
}
