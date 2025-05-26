<?php
    /**
     * Vista del panel de control de asistencia para consultar los alumnos
     *
     * Muestra una tabla con los nombres de los alumnos y un botón para ver los detalles de cada alumno
     * 
     */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor - Consulta Alumnos</title>
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
                                <a class="nav-link" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php?c=Alumnos&m=consultar">CONSULTAR ALUMNOS</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php?c=DiasNoLectivos&m=verCalendario">DIAS NO LECTIVOS</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="text-center mb-4">
                        <h4 class="d-inline-block bg-custom-secondary text-white px-4 py-2 rounded">CONSULTA DE ALUMNOS</h4>
                    </div>
                    <div class="mb-4 d-flex justify-content-end">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-custom-secondary text-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="buscadorAlumnos" placeholder="Buscar alumno por nombre">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>NOMBRE ALUMNO</th>
                                            <th>TELÉFONO PADRE/MADRE O TUTOR</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($datos['alumnos'] as $alumno) {
                                                echo '<tr>';
                                                echo '<td>' . $alumno['nombreAlumno'] . '</td>';
                                                echo '<td>' . $alumno['telefono'] . '</td>';
                                                echo '<td>';
                                                echo '<button class="btn btn-sm btn-detalles ver-detalles" data-id="' . $alumno['idAlumno'] . '">';
                                                echo '<i class="bi bi-eye"></i> Ver Detalles';
                                                echo '</button>';
                                                echo '</td>';
                                                echo '</tr>';
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
        <div class="modal fade" id="detallesModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-custom-secondary text-white">
                        <h5 class="modal-title">Detalles del Alumno</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="detallesAlumno">
                        
                    </div>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/consultaAlumnos.js"></script>
</body>
</html>