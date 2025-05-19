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
    }
?>