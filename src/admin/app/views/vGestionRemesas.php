<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel Administrador - Gestión remesas</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php');?>
    <div class="container datos-mensuales-container">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header">
                HISTORIAL DE REMESAS
            </div>
        </div>
        <div class="mb-4 d-flex justify-content-end">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-custom-secondary text-white icon-personalizado">
                    <i class="bi bi-search icon-personalizado"></i>
                </span>
                <input type="date" class="form-control" id="buscadorAlumnos" placeholder="Buscar por fecha">
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Fecha de generación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <td>Abril 2025</td>
                            <td>03/05/2025</td>
                            <td>
                                <a href="#" class="btn btn-sm action-button me-2">
                                    <i class="bi bi-file-earmark-text"></i> Ver Q19
                                </a>
                                <a href="#" class="btn btn-sm action-button">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Ver Excel
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/consultaAlumnos.js"></script>
</body>
</html>