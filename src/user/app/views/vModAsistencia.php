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
    <title>Panel Monitor - Control Asistencia</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerUser.php'); ?>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="text-center">
                    <h4 class="d-inline-block bg-custom-secondary-mod text-white px-4 py-2 rounded w-auto">SELECCIONE FECHA</h4>
                </div>      
                <form class="row g-4 align-items-center justify-content-center" id="formFecha" action="index.php?c=ControlAsistencia&m=obtenerAsistenciaFecha" method="POST">
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo isset($datos['fechaSeleccionada']) ? $datos['fechaSeleccionada'] : ''; ?>">
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

                if (empty($datos['alumnos'])) {
                    echo '<div class="alert alert-info text-center">No hay alumnos registrados para la fecha seleccionada.</div>';
                } else {

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

                    foreach ($datos['alumnos'] as $alumno) {
                        $seleccionado = '';
                        if (isset($datos['asistencias']) && in_array($alumno['idAlumno'], $datos['asistencias'])) {
                            $seleccionado = 'checked';
                        }
                        echo '<tr>';
                        echo '<td class="py-1 pe-0 columna-nombre">'.$alumno['apellidosAlumno'].' , '.$alumno['nombreAlumno'].'</td>';
                        echo '<td class="text-center py-1 ps-2 columna-asiste">';
                        echo '<input type="checkbox" class="form-check-input" data-id="'.$alumno['idAlumno'].'" '.$seleccionado . '>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>';
                    echo '</div>'; 
                }
            }
        ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/views/validacionFecha.js"></script>
    <script src="js/views/modificarAsistencia.js"></script>
</body>
</html>