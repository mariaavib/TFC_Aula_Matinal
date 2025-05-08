<?php
    class CDiasNoLectivos{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'DiasNoLectivos.php');
                $this->objModelo = new MDiasNoLectivos(); 
            }
        
            public function listar(){
                $this->vista = 'vDiasNoLectivos';    
                $datos = $this->objModelo->listarDias();
                return $datos;
            }

            public function insertar(){
                if(isset($_POST['fecha']) && isset($_POST['motivo'])) {
                    $fecha = trim($_POST['fecha']);
                    $motivo = trim($_POST['motivo']);      
                    $resultado = $this->objModelo->altaDias($fecha, $motivo);
                    
                    if($resultado) {
                        header('Location: /tfc/TFC_Aula_Matinal/src/index.php?c=DiasNoLectivos&m=listar');
                        exit;
                    }
                }
                $this->vista = 'vDiasNoLectivos';
                return [];
            }
    }