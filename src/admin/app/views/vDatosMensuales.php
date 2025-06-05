<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Administrador - Datos Mensuales</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php');?>
    <div id="datosMesAnio" data-mes="<?php echo isset($datos['mes']) ? $datos['mes'] : '' ?>" data-anio="<?php echo isset($datos['anio']) ? $datos['anio'] : '' ?>"></div>
    <div class="container datos-mensuales-container mt-4">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header h4 fw-bold">
                DATOS MENSUALES <?php 
                    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                    if (!empty($datos['mes']) && !empty($datos['anio'])) {
                        echo $meses[$datos['mes'] - 1]." ".$datos['anio'];
                    }
                ?>
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <?php
                $mesActual = $datos['mes'] ?? date('m');
                $anioActual = $datos['anio'] ?? date('Y');

                if ($mesActual == 1) {
                    $mesAnterior = 12;
                    $anioAnterior = $anioActual - 1;
                } else {
                    $mesAnterior = $mesActual - 1;
                    $anioAnterior = $anioActual;
                }

                if ($mesActual == 12) {
                    $mesSiguiente = 1;
                    $anioSiguiente = $anioActual + 1;
                } else {
                    $mesSiguiente = $mesActual + 1;
                    $anioSiguiente = $anioActual;
                }
            ?>
            <div class="mb-3 d-flex justify-content-between align-items-center w-100">
                <div class="d-flex">
                    <a href="index.php?c=Remesas&m=cambiarMes&dir=-1&mes=<?= $mesActual ?>&anio=<?= $anioActual ?>" class="btn btn-outline-azul me-2 d-inline-flex align-items-center px-3" style="font-size: 0.9rem;">
                        <i class="bi bi-arrow-left me-2"></i> Ver datos mes anterior
                    </a>
                    <a href="index.php?c=Remesas&m=cambiarMes&dir=1&mes=<?= $mesActual ?>&anio=<?= $anioActual ?>" class="btn btn-outline-azul d-flex align-items-center px-3" style="width: fit-content; font-size: 0.9rem;">
                        Ver datos mes siguiente <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-azul d-inline-flex align-items-center px-3" id="abrirGenerarRemesa" style="font-size: 0.9rem;">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Generar Remesa
                    </button>
                </div>
            </div>
        </div>
        <?php
            if (!empty($datos['status']) && $datos['status'] === 'error') {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo $datos['message'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>';
                echo '</div>';
            }
            if (!empty($datos['status']) && $datos['status'] === 'ok') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo $datos['message'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>';
                echo '</div>';
            }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombre y apellidos</th>
                        <th>Clase</th>
                        <th>Días asistidos</th>
                        <th>Importe (€)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaDatosMensuales">
                <?php
                    if (!empty($datos['alumnos']) && is_array($datos['alumnos'])) {
                        foreach ($datos['alumnos'] as $alumno) {
                            echo '
                                <tr>
                                    <td>'.$alumno['nombre'].'</td>
                                    <td>'.$alumno['clase']. '</td>
                                    <td>'.$alumno['diasAsistidos']. '</td>
                                    <td>'.$alumno['importe'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-detalles" onclick="mostrarDetallesAlumno('.$alumno['idAlumno'].')">Ver detalles</button>
                                    </td>
                                </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para ver detalles -->
    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles del Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="detallesAlumno">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para generar nueva remesa -->
    <div class="modal fade" id="generarRemesaModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="formGenerarRemesa" method="post" action="index.php?c=Remesas&m=generarRemesa" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Nueva Remesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fechaRemesa" class="form-label">Fecha de Remesa</label>
                        <input type="date" class="form-control" id="fechaRemesa" name="fechaRemesa" required>
                    </div>
                    <div class="alert alert-info">
                        Este proceso generará:
                        <ul>
                            <li>La remesa del mes anterior a la fecha seleccionada</li>
                            <li>Archivo Q19 para el banco</li>
                        </ul>
                    </div>
                    <?php
                        if (!empty($datos['status']) && $datos['status'] === 'error') {
                            echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                '.$datos['message'].'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                        if (!empty($datos['status']) && $datos['status'] === 'ok') {
                            echo '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                '.$datos['message'].'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="generarRemesa" class="btn btn-generar">Generar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/views/consultaAlumnos.js"></script>
</body>
</html>
