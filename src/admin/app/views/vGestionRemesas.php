<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador - Gestión remesas</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php'); ?>
    <div class="container datos-mensuales-container">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header">HISTORIAL DE REMESAS</div>
        </div>
        <div class="mb-4 d-flex justify-content-end">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-custom-secondary text-white icon-personalizado">
                    <i class="bi bi-search icon-personalizado"></i>
                </span>
                <input type="text" class="form-control" id="buscadorRemesas" placeholder="Buscar remesa">
            </div>
        </div>
        <?php 
           $remesas = [];
           if (isset($datos['remesas'])) {
               $remesas = $datos['remesas'];
           }           
            $meses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo',
                6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
                10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];
            if (isset($_GET['msg'])){
                $mensajes = [
                    'ok' => 'Remesa borrada correctamente.',
                    'error_bd' => 'Hubo un error al eliminar la remesa.',
                    'error_id' => 'ID de remesa no válido.'
                ];
                $error = ($_GET['msg'] === 'ok') ? 'success' : 'danger';
                echo '<div class="alert alert-'.$error.' alert-dismissible fade show" role="alert">' . $mensajes[$_GET['msg']] .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
            }
        ?>
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
                <?php
                    if (!empty($remesas)) {
                        for ($i = 0; $i < count($remesas); $i++) {
                            $remesa = $remesas[$i];
                            $mesNumero = (int)$remesa['mes'];
                            $periodo = $meses[$mesNumero].' '.$remesa['anio'];
                            $fechaGenerada = date_format(date_create($remesa['fechaGenerada']), 'd/m/Y');
                            echo '
                                <tr class="align-middle">
                                    <td>'.$periodo .'</td>
                                    <td>'.$fechaGenerada.'</td>
                                    <td>
                                        <a href="index.php?c=Remesas&m=descargarQ19&mes='.$mesNumero.'&anio='.$remesa['anio'].'" class="btn btn-sm action-button me-2">
                                            <i class="bi bi-file-earmark-text"></i> Descargar Q19
                                        </a>
                                        <a href="#" class="btn btn-sm action-button" data-bs-toggle="modal" data-bs-target="#modalBorrarRemesa"data-id="'.$remesa['idRemesa'].'">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No hay remesas generadas.</td></tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para pedir confirmacion al borrar-->
    <div class="modal" tabindex="-1" id="modalBorrarRemesa">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/vRemesas.js"></script>
</body>
</html>
