<!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Panel Administrador - Días no lectivos</title>
        <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
    </head>
    <body>   
        <?php
            require_once('layouts/headerAdmin.php');
        ?>
        <!-- Modal para borrar un solo día -->
        <div class="modal" tabindex="-1" id="modalBorrado">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Borrar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que quieres borrarlo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="#" class="btn btn-danger" id="btnConfirmarBorrado">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para borrar todos los días -->
        <div class="modal" tabindex="-1" id="modalBorradoTodos">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Borrar todos los días no lectivos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que quieres borrar <strong>todos</strong> los días no lectivos?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="index.php?c=DiasNoLectivos&m=eliminarTodos" class="btn btn-danger" id="btnConfirmarBorradoTodos">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container dias-no-lectivos-container">
            <div class="d-flex flex-column align-items-center mb-4">
                <div class="section-header">
                    DÍAS NO LECTIVOS
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="../admin/index.php?c=DiasNoLectivos&m=alta" class="btn d-flex align-items-center justify-content-center add-button">
                    <i class="bi bi-plus"></i>
                </a>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalBorradoTodos">
                    <i class="bi bi-trash"></i> Borrar todos los días no lectivos
                </a>
            </div>
            <?php
                if (!empty($datos['status']) && $datos['status'] === 'ok') {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                        . $datos['message'] .
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                if (!empty($datos['status']) && $datos['status'] === 'error') {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                        . $datos['message'] .
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            ?>
            <div class="table-responsive">
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th class="border-bottom text-center">Día</th>
                            <th class="border-bottom text-center">Motivo</th>
                            <th class="border-bottom text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($datos['datos'] as $valor)  {
                                $fechaModificada = date('d-m-Y', strtotime($valor['fecha']));
                                echo '<tr class="align-middle">
                                    <td class="border-bottom">' . $fechaModificada . '</td>
                                    <td class="border-bottom">' . $valor['motivo'] . '</td>
                                    <td class="border-bottom">
                                        <a href="index.php?c=DiasNoLectivos&m=formEdit&id='.$valor['idDia'].'" class="btn btn-sm me-2 action-button">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="btn btn-sm action-button" data-bs-toggle="modal" data-bs-target="#modalBorrado" data-id="'.$valor['idDia'].'">
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
        <script>
            const modalElement = document.getElementById('modalBorrado');
            const btnConfirmar = document.getElementById('btnConfirmarBorrado');
            modalElement.addEventListener('show.bs.modal', function (event) {
                const triggerButton = event.relatedTarget;
                const idDia = triggerButton.getAttribute('data-id');
                
                btnConfirmar.href = `index.php?c=DiasNoLectivos&m=eliminar&id=${idDia}`;
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>