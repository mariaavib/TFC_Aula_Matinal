<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Administrador - Editar Día no lectivo</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php require_once('layouts/headerAdmin.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    MODIFICAR DÍA NO LECTIVO
                    <hr>
                </h4>
                <div class="alert alert-danger text-center errorMensaje" style="display:none;"></div>
                <?php 
                    if (isset($datos['error'])) {
                        echo '<div class="alert alert-danger text-center">' . $datos['error'] . '</div>';
                    }
                ?>
                <form class="mt-4" method="POST" action="index.php?c=DiasNoLectivos&m=editar">
                    <div class="mb-4">
                        <label for="dia" class="form-label">DÍA NO LECTIVO</label>
                        <input type="date" class="form-control bg-light" id="dia" name="fecha" 
                                value="<?php echo $datos['fecha']; ?>"> 
                        <input type="hidden" name="id" value="<?php echo $datos['idDia']; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="motivo" class="form-label">MOTIVO</label>
                        <input type="text" class="form-control bg-light" id="motivo" name="motivo" 
                               value="<?php echo $datos['motivo']; ?>">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn form-button">MODIFICAR</button>
                        <a href="../admin/index.php?c=DiasNoLectivos&m=listar" class="btn form-button me-2">CANCELAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/views/vModificarDia.js"></script>
</body>
</html>
