<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Días no lectivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once('layouts/headerAdmin.php');
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    MODIFICAR DÍA NO LECTIVO
                    <hr>
                </h4>
                <div class="alert alert-danger text-center errorMensaje" style="display:none;"></div>
                <?php 
                    // Muestra el error si está definido
                    if (isset($datos['error'])) {
                        echo '<div class="alert alert-danger text-center">' . $datos['error'] . '</div>';
                    }
                ?>
                <form class="mt-4" method="POST" action="../admin/index.php?c=DiasNoLectivos&m=editar">
                    <div class="mb-4">
                        <label for="dia" class="form-label">DÍA NO LECTIVO</label>
                        <input type="date" class="form-control bg-light" id="dia" name="fecha" 
                               value="<?php echo isset($datos['fecha']) ? $datos['fecha'] : ''; ?>">
                        <input type="hidden" name="id" value="<?php echo isset($datos['idDia']) ? $datos['idDia'] : ''; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="motivo" class="form-label">MOTIVO</label>
                        <input type="text" class="form-control bg-light" id="motivo" name="motivo" 
                               value="<?php echo isset($datos['motivo']) ? $datos['motivo'] : ''; ?>">
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
    <script type="module" src="js/views/vModificarDia.js"></script>
</body>
</html>
