<?php

class CPanelAdmin{

    public $obj_modelo;
    public $vista;

    public function __construct(){
        require_once(RUTA_MODELOS.'PanelAdmin.php');
        $this->obj_modelo = new MPanelAdmin();
    }

    /**
     * Devolvemos la vista con el número de inscripciones pendientes
     * @return array resultado de la consulta a la base de datos
     * @return string mensaje de error si no hay inscripciones pendientes
     */
    public function inicio(){
        $this->vista = 'vPanelAdmin';
        $resultado = $this->obj_modelo->num_inscripcionespendientes();
        return $resultado;
    }
}
?>