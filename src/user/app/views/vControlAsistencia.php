<?php
    /**
     * Vista del panel de control de asistencia
     *
     * Muestra el panel de control de asistencia y la tabla de alumnos con un checkbox para marcar si asiste o no
     * 
     */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor Control Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/img/logoEscuela.png" alt="Logo de la Escuela" class="navbar-logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?c=ControlAsistencia&m=gestionar">CONTROL ASISTENCIA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=Alumnos&m=alta">ALTA ALUMNO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=Alumnos&m=consultar">CONSULTAR ALUMNOS</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php?c=DiasNoLectivos&m=verCalendario">DIAS NO LECTIVOS</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <?php
                    /**
                     * Muestra el panel de asistenca si es un día lectivo
                     * 
                     * Genera una tabla con los nombre de los alumnos y un checkbox para marcar si asiste o no
                     * 
                     */
                    if ($datos['esDiaLectivo'] && !empty($datos['alumnos'])) {
                        echo '<div class="text-center mb-4">';
                        echo '<h3 class="d-inline-block bg-custom-secondary text-white px-4 py-2 rounded w-auto">';

                        $diasSemana = ['DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'];
                        $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

                        date_default_timezone_set('Europe/Madrid');
                        $fecha = new DateTime();
                        echo $diasSemana[$fecha->format('w')] . ' ' . $fecha->format('d') . ' DE ' . $meses[$fecha->format('n') - 1] . ' ' . $fecha->format('Y');

                        echo '</h3>';
                        echo '</div>';

                        echo '<div class="table-responsive">';
                        echo '<table class="table table-sm table-asistencia">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="bg-custom-light pe-0 columna-nombre">NOMBRE DEL ALUMNO</th>';
                        echo '<th class="bg-custom-light text-center ps-2 columna-asiste">ASISTE</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        foreach ($datos['alumnos'] as $alumno) {
                            echo '<tr>';
                            echo '<td class="py-1 pe-0 columna-nombre">' . $alumno['nombreAlumno'] . '</td>';
                            echo '<td class="text-center py-1 ps-2 columna-asiste">';
                            echo '<input type="checkbox" class="form-check-input control-asistencia" data-id="' . $alumno['idAlumno'] . '"';
                            if (in_array($alumno['idAlumno'], $datos['asistencias'])) {
                                echo ' checked';
                            }
                            echo '>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    }

                    if (!$datos['esDiaLectivo'] || empty($datos['alumnos'])) {
                        echo '<div class="alert alert-info text-center">No hay clases hoy</div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/controlAsistencia.js"></script>
</body>
</html>
