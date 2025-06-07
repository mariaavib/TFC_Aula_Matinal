<?php

require_once 'assets/fpdf/fpdf.php';

/**
 * Clase para generar el PDF de alumnos inscritos
 * Extiende la clase FPDF para personalizar el encabezado y pie de página
 */
class PDFAlumnosInscritos extends FPDF
{
    function Header()
    {
        // Logo 
        $this->Image(__DIR__ . '/../../assets/img/logoEscuela.png', 10, 8, 25);
        // Título
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'Listado de Alumnos Inscritos', 0, 1, 'C');
        $this->SetFont('Times', 'U', 18);
        $this->Cell(0, 10, 'Aula Matinal', 0, 1, 'C');
        $this->Ln(2);
        // Cabecera de la tabla
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(173, 200, 230);
        $this->Cell(41, 8, 'Nombre Alumno', 1, 0, 'C', true);
        $this->Cell(41, 8, 'Nombre Tutor', 1, 0, 'C', true);
        $this->Cell(13, 8, 'Clase', 1, 0, 'C', true);
        $this->Cell(20, 8, 'DNI', 1, 0, 'C', true);
        $this->Cell(43, 8, 'IBAN', 1, 0, 'C', true);
        $this->Cell(41, 8, 'Titular Cuenta', 1, 0, 'C', true);
        $this->Cell(18, 8, 'Fecha', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Telefono', 1, 0, 'C', true);
        $this->Cell(43, 8, 'Correo', 1, 0, 'C', true);
        $this->Ln();
    }
    function Footer(){
        // Posición a 15 mm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

    
/**
 * Controlador para generar el PDF de alumnos inscritos
 */
class CGenerarPdf
{
    public $obj_modelo;
    public $vista;

    public function __construct()
    {
        require_once(RUTA_MODELOS . 'GenerarPdf.php');
        $this->obj_modelo = new MGenerarPdf();
    }

    /**
     * Método para generar el PDF de alumnos inscritos
     * @return void
     */
    public function generarpdf()
    {
        $resultado = $this->obj_modelo->listar_alumnosinscritos();

        if (!$resultado) {
            $this->vista = 'vAlumnosInscritos';
            $datos = $this->obj_modelo->alumnosinscritos();
            if (isset($datos['noalumnos'])) {
                $datos['errores'] = 'No hay alumnos inscritos, para generar el pdf';
                print_r($datos);
                return $datos;
            }
        }

        if (is_array($resultado)) {
            $pdf = new PDFAlumnosInscritos('L', 'mm', 'A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetAutoPageBreak(true, 15);

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