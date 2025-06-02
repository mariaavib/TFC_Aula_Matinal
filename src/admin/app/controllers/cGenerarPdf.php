<?php

class CGenerarPdf{

    public $obj_modelo;
    public $vista;

    public function __construct(){
        require_once(RUTA_MODELOS.'GenerarPdf.php');
        require_once 'assets/fpdf/fpdf.php';
        $this->obj_modelo = new MGenerarPdf();
    }

    public function generarpdf(){
        $resultado =$this->obj_modelo->listar_alumnosinscritos();

        if (!$resultado) {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            if(isset($datos['noalumnos'])){
                $datos['errores'] = 'No hay alumnos inscritos, para generar el pdf'; // Pasar como array dentro de 'datos'
                print_r($datos);
                return $datos;
            }
            
        }
    
        if (is_array($resultado)) {
            $pdf = new FPDF('L', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->SetFont('Times', 'B', 20);
            $pdf->Image('assets/img/logoEscuela.png', 10, 8, 25);
            $pdf->Cell(0, 10, 'Listado de Alumnos Inscritos', 0, 1, 'C');
            $pdf->SetFont('Times', 'U', 18);
            $pdf->Cell(0, 10, 'Aula Matinal', 0, 1, 'C');

            // Table header
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(173, 200, 230); 
            $pdf->Cell(41, 8, 'Nombre Alumno', 1, 0,'C',true);
            $pdf->Cell(41, 8, 'Nombre Tutor', 1,0,'C',true);
            $pdf->Cell(13, 8, 'Clase', 1,0,'C',true);
            $pdf->Cell(20, 8, 'DNI', 1,0,'C',true);
            $pdf->Cell(43, 8, 'IBAN', 1,0,'C',true);
            $pdf->Cell(41, 8, 'Titular Cuenta', 1,0,'C',true);
            $pdf->Cell(18, 8, 'Fecha', 1,0,'C',true);
            $pdf->Cell(20, 8, 'Telefono', 1,0,'C', true);
            $pdf->Cell(43, 8, 'Correo', 1,0,'C', true);
            $pdf->Ln();
        
            // Table body
            $pdf->SetFont('Arial', '', 8);
            foreach ($resultado as $alumno) {
                $pdf->Cell(41, 8, mb_convert_encoding($alumno['nombreAlumno'] . ' ' . $alumno['apellidosAlumno'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(41, 8, mb_convert_encoding($alumno['nombrePadre'] . ' ' . $alumno['apellidosPadre'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(13, 8, mb_convert_encoding($alumno['clase'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(20, 8, mb_convert_encoding($alumno['DNI'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(43, 8, mb_convert_encoding($alumno['IBAN'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(41, 8, mb_convert_encoding($alumno['titularCuenta'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(18, 8, mb_convert_encoding($alumno['fechaMandato'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(20, 8, mb_convert_encoding($alumno['telefono'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Cell(43, 8, mb_convert_encoding($alumno['correo'], 'ISO-8859-1', 'UTF-8'), 1);
                $pdf->Ln();
            }
    
            $pdf->Output('', 'alumnosinscritos_AulaMatinal.pdf');
        }
        
    }
}
?>