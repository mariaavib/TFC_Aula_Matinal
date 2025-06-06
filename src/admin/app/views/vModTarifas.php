<!DOCTYPE html>
<html lang="es">
<head>
    <title>Modificar Tarifas</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php   
        require_once('layouts/headerAdmin.php');
    ?>  
    <div class="container-sm mt-5">
        <?php if (isset($datos['mensaje_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show mx-auto" style="max-width: 650px;" role="alert">
                <?php echo htmlspecialchars($datos['mensaje_exito']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($datos['errores']) && !empty($datos['errores'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-auto" style="max-width: 650px;" role="alert">
                <strong>Por favor, corrija los siguientes errores:</strong>
                <ul>
                    <?php foreach ($datos['errores'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    MODIFICAR TARIFAS
                    <hr>
                </h4>
                <form action="index.php?c=Tarifas&m=insertarTarifas" method="post" class="mt-4">
                    <div class="mb-4">
                        <label for="precioDia" class="form-label">PRECIO POR DÍA</label>
                        <input type="text" name="precioDia" value="<?php echo isset($datos['precioDia']) ? $datos['precioDia'] : ''; ?>" class="form-control bg-light" id="precioDia" placeholder="Precio por día del aula matinal">
                    </div>
                    <div class="mb-4">
                        <label for="precioMes" class="form-label">PRECIO POR MES</label>
                        <input type="text" name="precioMes" value="<?php echo isset($datos['precioMes']) ? $datos['precioMes'] : ''; ?>"  class="form-control bg-light" id="precioMes" placeholder="Precio por mes del aula matinal">
                    </div>
                    <div class="mb-4">
                        <label for="diasMes" class="form-label">A PARTIR DE CUANTOS DÍAS SE COBRA EL MES (inclusive)</label>
                        <input type="text" name="numDias" value="<?php echo isset($datos['numDias']) ? $datos['numDias'] : ''; ?>" class="form-control bg-light" id="diasMes" placeholder="Día a partir del cual, (este inclusive), se cobra la tarifa mensual">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" style="background-color: #006EA4; color: white;" class="btn form-button">MODIFICAR</button>
                        <a href="index.php?c=PanelAdmin&m=inicio" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>    
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/views/vModificarTarifas.js"></script>
</body>
</html>
