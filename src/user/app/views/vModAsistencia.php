<?php
    /**
     * Vista del panel de control de asistencia para modificar asistencia
     *
     * Muestra 3 selects para seleccionar la fecha y un botón para buscar
     *
     * Muestra la tabla de asistencia del dia seleccionado 
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
                <div class="row justify-content-center">
                    <form class="row g-4 align-items-center justify-content-center" action="index.php?c=ControlAsistencia&m=obtenerAsistenciaFecha" method="POST">
                        <div class="col-md-2">
                            <select class="form-select form-select-lg" id="dia" name="dia" required>
                                <option value="">DÍA</option>
                                <?php 
                                    for($i = 1; $i <= 31; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-lg" id="mes" name="mes" required>
                                <option value="">MES</option>
                                <?php
                                    $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                                            'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                    foreach($meses as $i => $mes){
                                        echo "<option value='".($i+1)."'>$mes</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-lg" id="anio" name="anio" required>
                                <option value="">AÑO</option>
                                <?php
                                    $anioActual = date('Y');
                                    for($i = $anioActual; $i <= $anioActual + 1; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" id="btnBuscar" class="btn btn-lg bg-custom-secondary text-white">ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 mt-5">
                <div class="text-center mb-4">
                    <h4 class="d-inline-block bg-custom-secondary-mod text-white px-4 py-2 rounded w-auto">
                        <?php 
                            if(isset($datos['fecha'])){
                                echo htmlspecialchars($datos['fecha']);
                            }
                        ?>
                    </h4>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
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
                                            if(isset($datos['alumnos']) && is_array($datos['alumnos'])){ 
                                                foreach($datos['alumnos'] as $alumno){ 
                                                    echo "<tr>
                                                        <td class='py-1 pe-0 columna-nombre'>" . 
                                                            htmlspecialchars($alumno['nombreAlumno']) . 
                                                        "</td>
                                                        <td class='text-center py-1 ps-2 columna-asiste'>
                                                            <input type='checkbox' class='form-check-input' 
                                                                data-id='" . htmlspecialchars($alumno['idAlumno']) . "'
                                                                " . ((isset($datos['asistencias']) && in_array($alumno['idAlumno'], $datos['asistencias'])) ? 'checked' : '') . ">
                                                        </td>
                                                    </tr>";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="fechaSeleccionada" value="<?php echo isset($_GET['anio']) ? $_GET['anio'].'-'.$_GET['mes'].'-'.$_GET['dia'] : ''; ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/modificarAsistencia.js"></script>
</body>
</html>

