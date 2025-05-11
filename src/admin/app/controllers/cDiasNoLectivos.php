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

            public function alta(){
                $this->vista = 'vAltaDiasNoLectivos';
                return [];
            }

            public function insertar(){
                if(!empty($_POST['fecha']) && !empty($_POST['motivo'])) {
                    $fecha = $_POST['fecha'];
                    $motivo = $_POST['motivo'];      
                    $resultado = $this->objModelo->altaDias($fecha, $motivo);
                    
                    if($resultado) {
                        $this->vista = 'vDiasNoLectivos';
                        return $this->listar();
                    }
                }

                $this->vista = 'vAltaDiasNoLectivos';
                return ['error' => 'Todos los campos son obligatorios.'];
            }

            public function formEdit(){
                $this->vista = 'vEditDiasNoLectivos';

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $datos = $this->objModelo->obtenerPorId($id);
                    //var_dump($datos);
                    return $datos;
                }

                return [];
            }

            public function editar(){
                if(isset($_POST['id']) && !empty($_POST['fecha']) && !empty($_POST['motivo'])) {
                    $id = $_POST['id'];
                    $fecha = $_POST['fecha'];
                    $motivo = $_POST['motivo'];

                    $resultado = $this->objModelo->updateDias($id, $fecha, $motivo);

                    if($resultado) {
                        $this->vista = 'vDiasNoLectivos';
                        return $this->listar();
                    } 
                }else{
                    $this->vista = 'vEditDiasNoLectivos';
                    return [
                        'error' => 'Todos los campos son obligatorios.',
                        'fecha' => $_POST['fecha'],
                        'motivo' => $_POST['motivo']
                    ];
                } 
            }

            public function eliminar(){
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $resultado = $this->objModelo->eliminarDias($id);
                    if($resultado) {
                        $this->vista = 'vDiasNoLectivos';
                        return $this->listar();
                    }
                }
            }
        
    }