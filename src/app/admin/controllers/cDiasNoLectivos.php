<?php
    class CDiasNoLectivos{
            private $objModelo;
            public $vistas;
    
            function __construct(){
                require_once(RUTA_MODELOS.'DiasNoLectivos.php');
                $this->objModelo = new MDiasNoLectivos();
            }
        
            public function listar(){
                $this -> vistas = 'vDiasNoLectivos';
                $datos = $this -> objModelo -> listarDias();
                return $datos;
            }

    
            
    }