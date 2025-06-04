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
    <title>Panel Monitor - Consulta Alumnos</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerUser.php'); ?>
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
                                            echo '<td>'.$alumno['nombreAlumno'].' '.$alumno['apellidosAlumno'].'</td>';
                                            echo '<td>'.$alumno['telefono'].'</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-sm btn-detalles ver-detalles" data-id="'.$alumno['idAlumno'].'">';
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
    <script type="module" src="js/controllers/cConsultaAlumnos.js"></script>
</body>
</html>