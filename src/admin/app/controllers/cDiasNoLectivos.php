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
                $datos = [];

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $datos = $this->objModelo->obtenerPorId($id);
                    
                    if(isset($_GET['error'])) {
                        $datos['error'] = ($_GET['error'] == 1) ? 
                            'Error al actualizar el registro.' : 
                            'Todos los campos son obligatorios.';
                    }
                }

                return $datos;
            }

            public function editar(){
                $this->vista = 'vEditDiasNoLectivos';

                if(!isset($_POST['id']) || !isset($_POST['fecha']) || !isset($_POST['motivo'])) {
                    $this->vista = 'vDiasNoLectivos';
                    return $this->listar();
                }
            
                $id = $_POST['id'];
                $fecha = $_POST['fecha'];
                $motivo = $_POST['motivo'];
            
                if(empty($fecha) || empty($motivo)) {
                    return [
                        'error' => 'Todos los campos son obligatorios.',
                        'fecha' => $fecha,
                        'motivo' => $motivo,
                        'idDia' => $id
                    ];
                }
            
                $resultado = $this->objModelo->updateDias($id, $fecha, $motivo);
                
                if($resultado) {
                    $this->vista = 'vDiasNoLectivos';
                    return $this->listar();
                } else {
                    return [
                        'error' => 'Error al actualizar el registro.',
                        'fecha' => $fecha,
                        'motivo' => $motivo,
                        'idDia' => $id
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