<?php
    class CRemesas{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'Remesas.php'); // Asegúrate que el nombre del archivo del modelo es mRemesas.php
                $this->objModelo = new MRemesas(); 
            }

            public function datosMensuales(){
                $this->vista = 'vDatosMensuales';
                return [];
            }

            public function listarRemesas(){
                $this->vista = 'vGestionRemesas';
                return [];
            }

            public function generarRemesa(){
                // Se espera que la fecha venga en formato YYYY-MM-DD
                if (isset($_POST['fechaRemesa']) && !empty($_POST['fechaRemesa'])) {
                    $fechaRemesa = $_POST['fechaRemesa'];
                    $resultado = $this->objModelo->generarNuevaRemesa($fechaRemesa);
                } else {
                    $resultado = ['status' => 'error', 'message' => 'Fecha de remesa no proporcionada.'];
                }

                header('Content-Type: application/json');
                echo json_encode($resultado);
                exit;
            }
    }