<?php
    /**
     * Controlador cDiasNoLectivos
     * 
     * Controla la gestión de dias no lectivos, permitiendo mostrar la vista de los días no lectivos,
     * mostrar el formulario de alta de días no lectivos, insertar un nuevo día no lectivo,
     * mostrar el formulario de edición de días no lectivos, editar un día no lectivo y eliminar un día no lectivo.
     */
    class CDiasNoLectivos{
            private $objModelo;
            public $vista;    

            function __construct(){
                require_once(RUTA_MODELOS.'DiasNoLectivos.php');
                $this->objModelo = new MDiasNoLectivos(); 
            }
            /**
             * Muestra la vista de los días no lectivos.
             *
             * @return array Los datos de los días no lectivos.
             */
            public function listar() {
                $this->vista = 'vDiasNoLectivos';
                $hoy = date('m-d');
                $dias = $this->objModelo->listarDias();
                $datos = [
                    'datos' => $dias,
                    'status' => '',
                    'message' => ''
                ];
            
                if (isset($_GET['status'])){
                    $datos['status'] = $_GET['status'];
                }
            
                if (isset($_GET['message'])){
                    $datos['message'] = $_GET['message'];
                }
                
                if (isset($_GET['msg'])){
                    if ($_GET['msg'] === 'ok') {
                        $datos['message'] = 'Día no lectivo eliminado correctamente.';
                    } elseif ($_GET['msg'] === 'error') {
                        $datos['message'] = 'Error al eliminar el día no lectivo.';
                    }
                }
            
                return $datos;
            }
            /**
             * Muestra el formulario de alta de días no lectivos.
             *
             * @return array Los datos iniciales para el formulario de alta.
             */
            public function alta(){
                $this->vista = 'vAltaDiasNoLectivos';
                return [
                    'fecha' => '',
                    'motivo' => ''
                ];
            }
            /**
             * Inserta un nuevo día no lectivo.
             *
             * @return array Los datos resultantes después de la inserción.
             */
            public function insertar() {
                header('Content-Type: application/json');
            
                if (!empty($_POST['fecha']) && !empty($_POST['motivo'])) {
                    $fecha = $_POST['fecha'];
                    $motivo = $_POST['motivo'];

                    if ($this->objModelo->comprobar($fecha)) {
                        echo json_encode([
                            "error" => "Ya existe un día no lectivo con esa fecha."
                        ]);
                        exit;
                    }
            
                    $resultado = $this->objModelo->altaDias($fecha, $motivo);
            
                    if ($resultado) {
                        echo json_encode([
                            'status' => 'ok',
                            'message' => 'Día no lectivo insertado correctamente.'
                        ]);
                        exit;
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error al insertar el día no lectivo.'
                        ]);
                        exit;
                    }
                }
            
                echo json_encode([
                    'error' => 'Todos los campos son obligatorios.',
                    'fecha' => $_POST['fecha'],
                    'motivo' => $_POST['motivo']
                ]);
                exit;
            }            
            /**
             * Muestra el formulario de modificar de días no lectivos.
             * 
             * @return array Los datos del día no lectivo a editar.
             */
            public function formEdit(){
                $this->vista = 'vEditDiasNoLectivos';
                $datos = [];

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $datos = $this->objModelo->obtenerPorId($id);
                    
                    if(isset($_GET['error'])) {
                        if ($_GET['error'] == 1){
                            $datos['error'] = 'Error al actualizar el registro.';
                        }else{
                            $datos['error'] = 'Todos los campos son obligatorios.';
                        }
                    }
                }

                return $datos;
            }
            /**
             * Edita un día no lectivo.
             *
             * @return array El resultado después de la edición.
             */
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
            
                if ($this->objModelo->comprobar($fecha, $id)) { 
                    return [
                        'error' => 'Ya existe un día no lectivo con esa fecha.',
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
            
            /** 
             * Elimina un día no lectivo.
             *
             * @return array El resultado después de eliminar.
             */
            public function eliminar(){
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $resultado = $this->objModelo->eliminarDias($id);
            
                    if ($resultado) {
                        $this->vista = 'vDiasNoLectivos';
                        return $this->listar();
                    }
                }
            }
            
            public function eliminarTodos(){
                $resultado = $this->objModelo->eliminarTodosDias();
                if ($resultado) {
                    header('Location: index.php?c=DiasNoLectivos&m=listar&status=ok&message=Se han borrado correctamente todos los días no lectivos.');
                } else {
                    header('Location: index.php?c=DiasNoLectivos&m=listar&status=error&message=Error al borrar los días no lectivos.');
                }
                exit; 
            }
    }