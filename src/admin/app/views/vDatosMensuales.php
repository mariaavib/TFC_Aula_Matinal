<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel Administrador - Datos Mensuales</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php');?>
    <div class="container datos-mensuales-container">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header">
                DATOS MENSUALES ABRIL 2025
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <a href="" class="btn add-button d-flex align-items-center px-3" style="width: fit-content; font-size: 0.9rem;">
                <i class="bi bi-arrow-left me-2"></i> Ver datos mes anterior
            </a>
            <button class="btn add-button d-flex align-items-center px-3" id="generarRemesa" style="width: fit-content; font-size: 0.9rem;">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Generar Remesa
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th>Nombre y apellidos</th>
                            <th>Clase</th>
                            <th>Dias asistidos</th>
                            <th>Importe</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <td>Miriam López</td>
                            <td>1 EP A</td>
                            <td>5 días</td>
                            <td>20€</td>
                            <td>
                                <a href="#" class="btn btn-sm action-button me-2 ver-detalles" data-id="1">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td>María Vidigal</td>
                            <td>1 EP B</td>
                            <td>10 días</td>
                            <td>40€</td>
                            <td>
                                <a href="#" class="btn btn-sm action-button me-2 ver-detalles" data-id="1">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td>Carlos García</td>
                            <td>2 INF B</td>
                            <td>15 días</td>
                            <td>50€</td>
                            <td>
                                <a href="#" class="btn btn-sm action-button me-2 ver-detalles" data-id="1">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td>Rodrigo Rodriguez</td>
                            <td>2 EP B</td>
                            <td>16 días</td>
                            <td>50€</td>
                            <td>
                                <a href="#" class="btn btn-sm action-button me-2 ver-detalles" data-id="1">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
            <div class="mb-3"><strong>Nombre del Alumno:</strong> Miriam López</div>
            <div class="mb-3"><strong>Nombre del Padre:</strong> Juan López</div>
            <div class="mb-3"><strong>Teléfono:</strong> 612345678</div>
            <div class="mb-3">
                <strong>Días asistidos:</strong>
                <ul class="list-group mt-2">
                    <li class="list-group-item">12 de Mayo de 2025</li>
                    <li class="list-group-item">13 de Mayo de 2025</li>
                    <li class="list-group-item">14 de Mayo de 2025</li>
                    <li class="list-group-item">15 de Mayo de 2025</li>
                    <li class="list-group-item">16 de Mayo de 2025</li>
                </ul>
            </div>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Nueva Remesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Fecha de Remesa</label>
                        <input type="date" class="form-control" id="fechaRemesa">
                    </div>
                    <div class="alert alert-info">
                        Este proceso generará:
                        <ul>
                            <li>Archivo Q19 para el banco</li>
                            <li>Excel con el detalle de los recibos</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarGeneracion">Generar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/consultaAlumnos.js"></script>
</body>
</html>