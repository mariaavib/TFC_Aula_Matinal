<?php
class CDiasNoLectivos {
    private $modelo;
    public $vista;

    public function __construct(){
        require_once(RUTA_MODELOS . 'DiasNoLectivos.php');
        $this->modelo = new MDiasNoLectivos();
    }

    // Método para obtener los días festivos en formato JSON
    public function diasFestivos(){
        header('Content-Type: application/json');
        $eventos = $this->modelo->getDiasFestivos();
        echo json_encode($eventos);
        exit;
    }
    public function verCalendario(){
        $this->vista = 'vCalendario';
        return [];
    }
}
