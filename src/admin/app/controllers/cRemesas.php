<?php
/***
 * Controlador que gestiona las remesas
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
class CRemesas {
    private $objModelo;
    public $vista;

    public function __construct() {
        require_once(RUTA_MODELOS . 'Remesas.php');
        $this->objModelo = new MRemesas();
    }
    /**
     * Metodo que muestra la vista de los datos mensuales y los alumnos que pertenecen a cada uno de ellos
     */
    public function datosMensuales() {
        $this->vista = 'vDatosMensuales';
    
        $hoy = new DateTime();
        $hoy->setDate((int)$hoy->format('Y'), (int)$hoy->format('m'), 1); // Primer día del mes actual
        $mes = (int)$hoy->format('m');
        $anio = (int)$hoy->format('Y');
    
        $alumnos = $this->objModelo->obtenerDatosMensuales($mes, $anio);
        return [
            'alumnos' => $alumnos,
            'mes' => $mes,
            'anio' => $anio
        ];
    }
    
    /**
     * Metodo que muestra la vista de la lista de remesas
     */
    public function listarRemesas() {
        $this->vista = 'vGestionRemesas';
        $remesas = $this->objModelo->listarRemesas();
        return ['remesas' => $remesas];
    }
    /**
     * Metodo genera la remesa y el excel
     */
    public function generarRemesa() {
        $this->vista = 'vDatosMensuales';

        if (isset($_POST['fechaRemesa']) && !empty($_POST['fechaRemesa'])) {
            $fechaRemesa = $_POST['fechaRemesa'];
            $resultado = $this->objModelo->generarNuevaRemesa($fechaRemesa);

            $fecha = DateTime::createFromFormat('Y-m-d', $fechaRemesa);
            if (!$fecha) {
                $fecha = new DateTime();
            }
            $fecha->modify('first day of last month'); 
            $mes = (int)$fecha->format('m');
            $anio = (int)$fecha->format('Y');

            $alumnos = $this->objModelo->obtenerDatosMensuales($mes, $anio);
            /////////////////////////////////////////////////////////////////
            if(!$this->cogerDatosExcelRemesas($mes, $anio)){
                // No hay datos, retornamos error para mostrar mensaje en la vista
                return array_merge($resultado, [
                    'status' => 'error',
                    'message' => 'No hay datos para generar la remesa en ese periodo.',
                    'mes' => $mes,
                    'anio' => $anio,
                    'alumnos' => $alumnos
                ]);
            }
            /////////////////////////////////////////////////////////////////
            return array_merge($resultado, [
                'status' => 'ok',
                'message' => 'La remesa se ha generado correctamente y el archivo Q19 se ha descargado.',
                'mes' => $mes,
                'anio' => $anio,
                'alumnos' => $alumnos
            ]);
        }

        $hoy = new DateTime();
        return [
            'status' => 'error',
            'message' => 'Debes indicar una fecha para generar la remesa.',
            'mes' => (int)$hoy->format('m'),
            'anio' => (int)$hoy->format('Y'),
            'alumnos' => []
        ];
    }
    
    /**
     * Metodo que muestra la vista de los datos mensuales y los alumnos que pertenecen a cada uno de ellos
     */
    public function cambiarMes() {
        $this->vista = 'vDatosMensuales';
        if (isset($_GET['dir'])) {
            $direccion = (int)$_GET['dir'];
        } else {
            $direccion = 0;
        }
        if (isset($_GET['mes'])) {
            $mes = (int)$_GET['mes'];
        } else {
            $mes = (int)date('m');
        }
        if (isset($_GET['anio'])) {
            $anio = (int)$_GET['anio'];
        } else {
            $anio = (int)date('Y');
        }
        
        if ($direccion === 0) {
            $alumnos = $this->objModelo->obtenerDatosMensuales($mes, $anio);
            return [
                'mes' => $mes,
                'anio' => $anio,
                'alumnos' => $alumnos,
            ];
        }
    
        $fecha = DateTime::createFromFormat('Y-m-d', "$anio-$mes-01");
        if (!$fecha) {
            $fecha = new DateTime();
        }
    
        $fecha->modify(($direccion > 0 ? '+' : '').$direccion.' month');
    
        $nuevoMes = (int)$fecha->format('m');
        $nuevoAnio = (int)$fecha->format('Y');
    
        $alumnos = $this->objModelo->obtenerDatosMensuales($nuevoMes, $nuevoAnio);
    
        return [
            'mes' => $nuevoMes,
            'anio' => $nuevoAnio,
            'alumnos' => $alumnos,
        ];
    }

    /**
     * Metodo que muestra los detalles de un alumno en concreto
     */
    public function obtenerDetallesAlumno() {
        if (isset($_GET['id'], $_GET['mes'], $_GET['anio'])) {
            header('Content-Type: application/json');
            $id = $_GET['id'];
            $mes = $_GET['mes'];
            $anio = $_GET['anio'];

            $datos = $this->objModelo->obtenerDetallesAlumno($id, $mes, $anio);
            echo json_encode($datos);
            exit;
        }

        $this->vista = 'vDatosMensuales';
        return [
            'status' => 'error',
            'message' => 'Faltan parámetros para obtener detalles del alumno.'
        ];
    }
    /**
     * Metodo que elimina una remesa
     */
    public function eliminarRemesa() {
        $idRemesa = $_GET['id'];
    
        if (!isset($idRemesa)) {
            header('Location: index.php?c=Remesas&m=listarRemesas&msg=error_id');
            exit;
        }
    
        $resultado = $this->objModelo->eliminarRemesa($idRemesa);
    
        if ($resultado['status'] === 'ok') {
            header('Location: index.php?c=Remesas&m=listarRemesas&msg=ok');
        } else {
            header('Location: index.php?c=Remesas&m=listarRemesas&msg=error_bd');
        }
        exit;
    }
    /**
     * Metodo que coge los datos de la base de datos y los pasa al metodo crearRemesas para crear el excel
     */
    private function cogerDatosExcelRemesas($mes, $anio) {
        $datos = $this->objModelo->cogerDatosExcelRemesas($mes, $anio);
        //var_dump($datos);
        if (empty($datos)) {
            return false;
        }

        $this->crearRemesas($datos, $mes, $anio);
    
        return true;
    }
    /**
     * Metodo privado que crea el excel con los datos de la base de datos
     */
    private function crearRemesas(array $datos, $mes, $anio) {
        require '../../vendor/autoload.php';
    
        $spreadsheet = IOFactory::load('assets/excel/remesa_Excel_CSP_es.xlsx');    
        $sheet = $spreadsheet->getActiveSheet();
    
         // Array para obtener el nombre del mes en español
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        // Obtener nombre del mes o usar texto por defecto si no está en rango
        $nombreMes = $meses[$mes];

        // Construir concepto con mes y año recibidos
        $concepto = "Aula Matinal $nombreMes $anio";
    
        $fila = 12;
        $contador = 1;
    
        foreach ($datos as $registro) {
            $sheet->setCellValue("A{$fila}", $registro['titularCuenta']);        
            $sheet->setCellValue("B{$fila}", $registro['IBAN']);                 
            $sheet->setCellValue("C{$fila}", $registro['DNI']);                               
            $sheet->setCellValue("D{$fila}", $registro['fechaMandato']);         
            $sheet->setCellValue("E{$fila}", "RCUR");   
            $sheet->setCellValue("F{$fila}", (int)$contador);
            $sheet->getStyle("F{$fila}")->getNumberFormat()->setFormatCode('0');
            $sheet->setCellValue("G{$fila}", $registro['totalPrecio']);
            $sheet->setCellValue("H{$fila}", $concepto);                          
            
            $contador++;
            $fila++;
        }
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="remesa_'.$mes.'_'.$anio.'.xlsx"');
        header('Cache-Control: max-age=0');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('assets/excel/remesa_'.$mes.'_'.$anio.'.xlsx');  
        $writer->save('php://output');  
    
        exit; 
    }
    /**
     * Metodo que descarga el excel de la remesa
     */
    public function descargarQ19() {
        require '../../vendor/autoload.php';
        $mes = $_GET['mes'];
        $anio = $_GET['anio'];
        $spreadsheet = IOFactory::load('assets/excel/remesa_'.$mes.'_'.$anio.'.xlsx');
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="remesa_'.$mes.'_'.$anio.'.xlsx"');
        header('Cache-Control: max-age=0');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    
       return $this->listarRemesas();
    }
}
