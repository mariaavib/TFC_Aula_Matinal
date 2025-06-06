<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Administrador - Alta Día no lectivo</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
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
                <div class="alert alert-danger alert-dismissible fade show" style="display: none;" role="alert">
                    <span id="mensaje-error"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php 
                    if (isset($datos['error'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">'. $datos['error'] .
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                ?>
                <form class="mt-4" method="POST" action="../admin/index.php?c=DiasNoLectivos&m=insertar">
                    <div class="mb-4">
                        <label for="dia" class="form-label">DÍA NO LECTIVO</label>
                        <input type="date" class="form-control bg-light" id="dia" name="fecha" value="<?php echo $datos['fecha']; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="motivo" class="form-label">MOTIVO</label>
                        <input type="text" class="form-control bg-light" id="motivo" name="motivo" value="<?php echo $datos['motivo']; ?>">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn form-button">GUARDAR</button>
                        <a href="../admin/index.php?c=DiasNoLectivos&m=listar" class="btn form-button me-2">CANCELAR</a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/vAltaDiasNoLectivos.js"></script>
</body>
</html>