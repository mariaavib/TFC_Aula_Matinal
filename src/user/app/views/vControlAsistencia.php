
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

                <?php if ($datos['esDiaLectivo'] && !empty($datos['alumnos'])): ?>
                    <div class="text-center mb-4">
                        <h3 class="d-inline-block bg-custom-secondary text-white px-4 py-2 rounded w-auto">
                            <?php 
                                $diasSemana = ['DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'];
                                $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                $fecha = new DateTime();
                                echo $diasSemana[$fecha->format('w')] . ' ' . $fecha->format('d') . ' DE ' . $meses[$fecha->format('n') - 1] . ' ' . $fecha->format('Y');
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
                                <?php foreach ($datos['alumnos'] as $alumno): ?>
                                    <tr>
                                        <td class="py-1 pe-0 columna-nombre"><?= htmlspecialchars($alumno['nombreAlumno']) ?></td>
                                        <td class="text-center py-1 ps-2 columna-asiste">
                                            <input type="checkbox" class="form-check-input control-asistencia"
                                                data-id="<?= $alumno['idAlumno'] ?>"
                                                <?= in_array($alumno['idAlumno'], $datos['asistencias']) ? 'checked' : '' ?>>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">No hay clases hoy</div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/controlAsistencia.js"></script>
</body>
</html>
