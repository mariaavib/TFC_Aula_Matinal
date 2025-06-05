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
    <title>Panel Monitor - Control Asistencia</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerUser.php'); ?>
    <div class="container">
        <?php
            if (isset($_GET['mens']) && $_GET['mens'] === 'b') {
                echo '<div class="alert alert-success alert-dismissible fade show w-50 mx-auto" role="alert">'
                    .'Alumno insertado correctamente.'
                    . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                    . '</div>';
            }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <?php
                    if ($datos['esDiaLectivo']) {
                        if (!empty($datos['alumnos'])) {
                ?>
                <div class="text-center mb-4">
                    <h3 class="d-inline-block bg-custom-secondary text-white px-4 py-2 rounded w-auto">
                        <?php
                            $diasSemana = ['DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'];
                            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                            $fecha = new DateTime();
                            echo $diasSemana[$fecha->format('w')].' '.$fecha->format('d').' DE '.$meses[$fecha->format('n') - 1].' '. $fecha->format('Y');
                        ?>
                    </h3>
                </div>
                <!-- Tabla de asistencia -->
                <div class="table-responsive">
                    <table class="table table-sm table-asistencia">
                        <thead>
                            <tr>
                                <th class="bg-custom-light pe-0 columna-nombre">NOMBRE DEL ALUMNO</th>
                                <th class="bg-custom-light text-center ps-2 columna-asiste">ASISTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($datos['alumnos'] as $alumno) {
                                echo '<tr>';
                                echo '<td class="py-1 pe-0 columna-nombre">'.$alumno['apellidosAlumno'].' , '.$alumno['nombreAlumno'].'</td>';
                                echo '<td class="text-center py-1 ps-2 columna-asiste">';
                                echo '<input type="checkbox" class="form-check-input control-asistencia"';
                                echo ' data-id="' . $alumno['idAlumno'] . '"';
                                echo in_array($alumno['idAlumno'], $datos['asistencias']) ? ' checked' : '';
                                echo '>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                        } else {
                            echo '<div class="alert alert-warning text-center">No hay alumnos registrados para mostrar.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info text-center">Hoy no es un día lectivo.</div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/views/controlAsistencia.js"></script>
</body>
</html>