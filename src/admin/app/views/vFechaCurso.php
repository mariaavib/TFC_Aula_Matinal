<!DOCTYPE html>
<html lang="es">
<head>
    <title>Fecha del Curso</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php   
        require_once('layouts/headerAdmin.php');
    ?>
    <div class="container-sm mt-5">
        <?php if (isset($datos['mensaje_exito'])): ?>
            <div class="alert alert-success mx-auto" style="max-width: 650px;" role="alert">
                <?php echo htmlspecialchars($datos['mensaje_exito']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($datos['errores']) && !empty($datos['errores'])): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 650px;" role="alert">
                <strong>Por favor, corrija los siguientes errores:</strong>
                <ul>
                    <?php foreach ($datos['errores'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($datos['errores_guardado']) && !empty($datos['errores_guardado'])): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 650px;" role="alert">
                <strong>Error al guardar:</strong>
                <ul>
                    <?php foreach ($datos['errores_guardado'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    FECHA DEL CURSO
                    <hr>
                </h4>
                <form action="index.php?c=FechaCurso&m=insertarFechaCurso" method="post" class="mt-4">
                    <div class="mb-4">
                        <label for="fecha_ini" class="form-label">FECHA DE INICIO</label>
                        <input type="date" value="<?php echo isset($datos['inicioCurso']) ? $datos['inicioCurso'] : ''; ?>" name="fecha_ini" class="form-control bg-light" id="fecha_ini" >
                    </div>
                    <div class="mb-4">
                        <label for="fecha_fin" class="form-label">FECHA DE FIN</label>
                        <input type="date" value="<?php echo isset($datos['finCurso']) ? $datos['finCurso'] : ''; ?>" name="fecha_fin" class="form-control bg-light" id="fecha_fin">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn form-button">MODIFICAR FECHAS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
