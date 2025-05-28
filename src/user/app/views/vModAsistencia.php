<?php
    /**
     * Vista del panel de control de asistencia para modificar asistencia
     *
     * Muestra 3 selects para seleccionar la fecha y un botón para buscar
     *
     * Muestra la tabla de asistencia del día seleccionado 
     *
     */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor - Control Asistencia</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/img/logoEscuela.png" alt="Logo Escuela" class="navbar-logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=ControlAsistencia&m=gestionar">CONTROL ASISTENCIA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=Alumnos&m=alta">ALTA ALUMNO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
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
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="text-center">
                    <h4 class="d-inline-block bg-custom-secondary-mod text-white px-4 py-2 rounded w-auto">SELECCIONE FECHA</h4>
                </div>      
                <form class="row g-4 align-items-center justify-content-center" id="formFecha" action="index.php?c=ControlAsistencia&m=obtenerAsistenciaFecha" method="POST">
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="fecha" name="fecha" 
                            value="<?php echo isset($datos['fechaSeleccionada']) ? $datos['fechaSeleccionada'] : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="btnBuscar" class="btn bg-custom-secondary text-white">ACEPTAR</button>
                    </div>
                </form>
                <div id="mensajeError" class="alert alert-danger mt-3" style="display: none;"></div>
            </div>
        </div>

        <div class="col-md-8 mt-5 mx-auto">
            <?php
                if (isset($datos['fecha']) && !empty($datos['fecha'])) {
                    echo '<div class="text-center mb-4">';
                    echo '<h4 class="d-inline-block bg-custom-secondary-mod text-white px-4 py-2 rounded w-auto">';
                    echo $datos['fecha'];
                    echo '</h4>';
                    echo '</div>';

                    echo '<div class="container p-0">';
                    echo '<div class="row justify-content-center m-0">';
                    echo '<div class="col-md-8 col-sm-12 p-0">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-sm table-asistencia mb-0">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="bg-custom-light pe-0 columna-nombre">NOMBRE DEL ALUMNO</th>';
                    echo '<th class="bg-custom-light text-center ps-2 columna-asiste">ASISTE</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    if (isset($datos['alumnos']) && is_array($datos['alumnos'])) {
                        foreach ($datos['alumnos'] as $alumno) {
                            $seleccionado = '';
                            if (isset($datos['asistencias']) && in_array($alumno['idAlumno'], $datos['asistencias'])) {
                                $seleccionado = 'checked';
                            }

                            echo '<tr>';
                            echo '<td class="py-1 pe-0 columna-nombre">' . $alumno['nombreAlumno'] . '</td>';
                            echo '<td class="text-center py-1 ps-2 columna-asiste">';
                            echo '<input type="checkbox" class="form-check-input" data-id="' . $alumno['idAlumno'] . '" ' . $seleccionado . '>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>'; 
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/validacionFecha.js"></script>
    <script src="js/modificarAsistencia.js"></script>
</body>
</html>
