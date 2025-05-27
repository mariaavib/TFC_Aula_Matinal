<?php
    class CFechaCurso{

            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'FechaCurso.php');
                $this->objModelo = new MFechaCurso(); 
            }

            /**
             * Carga la vista de las fechas del curso haciéndola dinámica 
             * si hay datos en la bbdd.
             * @return array $datos
             */
            public function fechaCurso(){
                $this->vista = 'vFechaCurso';
                $datos = $this->objModelo->listarFechaCurso();

                return $datos;
            }

            /**
             * Valida los datos insertados desde el formulario, 
             * controla los errores de bbdd y llama para la inserción/modificación de las fechas.
             * --Retorna mensajes de validación y/o de éxito de la inserción/modificación.
             * @return mixed $datos  
             */
            public function insertarFechaCurso(){
                $inicioCurso = $_POST['fecha_ini'];
                $finCurso = $_POST['fecha_fin'];

                $erroresValidacion = [];

                // Primero, verificar si los campos están vacíos
                if (empty($inicioCurso)) {
                    $erroresValidacion[] = "La 'Fecha de Inicio' no puede estar vacía.";
                }
                if (empty($finCurso)) {
                    $erroresValidacion[] = "La 'Fecha de Fin' no puede estar vacía.";
                }

                // Si hay errores de campos vacíos, retornar inmediatamente
                if (!empty($erroresValidacion)) {
                    $this->vista = 'vFechaCurso';
                    $datos = $this->objModelo->listarFechaCurso(); // Cargar datos existentes para la vista
                    $datos['errores'] = $erroresValidacion;
                    return $datos;
                }

                if (!empty($inicioCurso) && !empty($finCurso)) {
                    // Convertimos las fechas a timestamps para una comparación segura
                    $date_ini = strtotime($inicioCurso);
                    $date_fin = strtotime($finCurso);

                    // Verificamos si las conversiones fueron exitosas (strtotime devuelve false en caso de error)
                    if ($date_ini === false || $date_fin === false) {
                        $erroresValidacion[] = "Formato de fecha inválido.";
                    } elseif ($date_ini > $date_fin) {
                        $erroresValidacion[] = "La 'Fecha de Inicio' no puede ser posterior a la 'Fecha de Fin'.";
                    }

                $datos = $this->objModelo->listarFechaCurso();

                //Si hay errores de validación, se añaden al array para retornarlo y mostrarlos en la vista.
                if (!empty($erroresValidacion)) {
                    $this->vista = 'vFechaCurso';
                    $datos['errores'] = $erroresValidacion;
                    return $datos;
                }

                $resultado = $this->objModelo->insertarFechaCurso($inicioCurso, $finCurso);
                
                $datos = $this->objModelo->listarFechaCurso();

                //$resultado devuelve true o false según el resultado de la inserción/modificación en la bbdd
                if ($resultado) {
                    $datos['mensaje_exito'] = "Fechas del curso guardadas correctamente.";
                } else {
                    $datos['errores_guardado'] = ["Hubo un problema al guardar las fechas del curso."];
                }
                
                $this->vista = 'vFechaCurso';
                
                return $datos; 
            }
        }
    }