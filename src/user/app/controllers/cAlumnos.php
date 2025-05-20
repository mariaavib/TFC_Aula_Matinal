<?php
    class CAlumnos {
            private $objModelo;
            public $vista;    

            function __construct(){
                require_once(RUTA_MODELOS.'Alumnos.php');
                $this->objModelo = new MAlumnos(); 
            }

            public function alta() {
                $this->vista = 'vAltaAlumno';
                return [];
            }

            public function insertar(){
                $nombreAlumno = $_POST['nombreAlumno'];
                $telefono = $_POST['telefono'];
                $fechaMandato = date('Y-m-d');

                $resultado = $this->objModelo->insertarAlumno($nombreAlumno, $telefono, $fechaMandato);

                if($resultado){
                    header('Location: index.php?c=ControlAsistencia&m=gestionar');  
                }else{
                    $this->vista = 'vAltaAlumno';
                    return ['error' => 'Error al insertar el alumno'];
                }
            }

            public function consultar() {
                $this->vista = 'vConsultaAlumnos';
                $datos['alumnos'] = $this->objModelo->obtenerAlumnos();
                return $datos;
            }

            public function obtenerDetalles() {
                header('Content-Type: application/json');
                
                $idAlumno = isset($_GET['id']) ? $_GET['id'] : 0;
                $alumno = $this->objModelo->obtenerDetallesAlumno($idAlumno);
                
                if ($alumno) {
                    echo json_encode([
                        'success' => true,
                        'alumno' => $alumno
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Alumno no encontrado'
                    ]);
                }
                exit;
            }
    }
?>