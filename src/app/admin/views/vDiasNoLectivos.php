<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel Administrador - Días no lectivos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="/tfc/TFC_Aula_Matinal/src/app/admin/assets/css/style.css" rel="stylesheet">
    </head>
    <body>   
        <?php
            require_once('layouts/headerAdmin.php');
        ?>
                <div class="container dias-no-lectivos-container">
                    <div class="d-flex flex-column align-items-center mb-4">
                        <div class="section-header">
                            DÍAS NO LECTIVOS
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="/tfc/TFC_Aula_Matinal/src/app/admin/views/vAltaDiasNoLectivos.php" class="btn rounded-circle d-flex align-items-center justify-content-center add-button">
                            <i class="bi bi-plus"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom">Día</th>
                                    <th class="border-bottom">Motivo</th>
                                    <th class="border-bottom">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($datos as $valor)  {
                                        echo '<tr class="align-middle">
                                            <td class="border-bottom">' . $valor['fecha'] . '</td>
                                            <td class="border-bottom">' . $valor['motivo'] . '</td>
                                            <td class="border-bottom">
                                                <a href="vEditDiasNoLectivos.php?id='.$valor['idDia'] .'" class="btn btn-sm me-2 action-button">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm action-button">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>