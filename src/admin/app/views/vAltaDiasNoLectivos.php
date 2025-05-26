<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Días no lectivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    ALTA DÍA NO LECTIVO
                    <hr>
                </h4>
                <div class="alert alert-danger" style="display: none;"></div>
                <?php 
                    if (isset($datos['error'])) {
                        echo '<div class="alert alert-danger text-center">'.$datos['error'].'</div>';
                    }
                    if(isset($datos['correcto'])) {
                        echo '<div class="alert alert-success text-center">'.$datos['correcto'].'</div>';
                    }
                ?>
                <form class="mt-4" method="POST" action="../admin/index.php?c=DiasNoLectivos&m=insertar">
                    <div class="mb-4">
                        <label for="dia" class="form-label">DÍA NO LECTIVO</label>
                        <input type="date" class="form-control bg-light" id="dia" name="fecha" value="<?php echo $valorFecha; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="motivo" class="form-label">MOTIVO</label>
                        <input type="text" class="form-control bg-light" id="motivo" name="motivo" value="<?php echo $valorMotivo; ?>">
                    </div>
                    <div class="text-center mt-5">
                        <a href="../admin/index.php?c=DiasNoLectivos&m=listar" class="btn form-button me-2">CANCELAR</a>
                        <button type="submit" class="btn form-button">GUARDAR</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/vAltaDiasNoLectivos.js"></script>
</body>
</html>