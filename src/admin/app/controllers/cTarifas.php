<?php
    class CTarifas{
            private $objModelo;
            public $vista;    
    
            function __construct(){
                require_once(RUTA_MODELOS.'Tarifas.php');
                $this->objModelo = new MTarifas(); 
            }

            /**
             * Carga la vista de las fechas del curso haciéndola dinámica 
             * si hay datos en la bbdd.
             * @return array $datos
             */
            public function tarifas(){
                $this->vista = 'vModTarifas';
                $datos = $this->objModelo->listarTarifas();

                return $datos;
            }

            /**
             * Valida los datos insertados desde el formulario, 
             * controla los errores de bbdd y llama para la inserción/modificación de las tarifas.
             * --Retorna mensajes de validación y/o de éxito de la inserción/modificación.
             * @return mixed $datos  
             */
            public function insertarTarifas(){
                $numDias = trim($_POST['numDias']);
                $precioDia = trim($_POST['precioDia']);
                $precioMes = trim($_POST['precioMes']);

                $erroresValidacion = [];

                if (empty($precioDia)) {
                    $erroresValidacion[] = "El campo 'Precio por día' no puede estar vacío.";
                } elseif (!is_numeric($precioDia) || $precioDia < 0) {
                    $erroresValidacion[] = "El campo 'Precio por día' debe ser un número positivo.";
                }

                if (empty($precioMes)) {
                    $erroresValidacion[] = "El campo 'Precio por mes' no puede estar vacío.";
                } elseif (!is_numeric($precioMes) || $precioMes < 0) {
                    $erroresValidacion[] = "El campo 'Precio por mes' debe ser un número positivo.";
                }

                if (empty($numDias)) {
                    $erroresValidacion[] = "El campo 'Número de días' no puede estar vacío.";
                } elseif (!is_numeric($numDias) || $numDias < 1 || $numDias > 31) {
                    $erroresValidacion[] = "El campo 'Número de días' debe ser un número entre 1 y 31.";
                }

                $datos = $this->objModelo->listarTarifas();

                //Si hay errores de validación, se añaden al array para retornarlo y mostrarlos en la vista.
                if (!empty($erroresValidacion)) {
                    $this->vista = 'vModTarifas';
                    $datos['errores'] = $erroresValidacion;
                    return $datos;
                }

                $resultado = $this->objModelo->insertarTarifas($numDias, $precioDia, $precioMes);
                
                //Se llama al método para listar las tarifas para mostrar el mensaje de éxito o error.
                $datos = $this->objModelo->listarTarifas();

                //$resultado devuelve true o false según el resultado de la inserción/modificación en la bbdd
                if ($resultado) {
                    $datos['mensaje_exito'] = "Tarifas guardadas correctamente.";
                } else {
                    $datos['errores_guardado'] = ["Hubo un problema al guardar las tarifas."];
                }
                
                $this->vista = 'vModTarifas';
                
                return $datos; 
                
            }
        
        
    }