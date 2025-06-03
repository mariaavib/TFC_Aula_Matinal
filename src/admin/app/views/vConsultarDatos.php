<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consultar Datos</title>
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>

        <div class="container mt-3">
        <div class="mb-3">
            <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn" style="background-color: #006EA4; color: white;">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    CONSULTAR DATOS DE INSCRIPCIÓN
                    <hr>
                </h4>

                <!-- Datos del tutor -->
                <div class="card mb-4">
                    <div class="card-header text-white" style="background-color: #006EA4;">
                        <h5 class="mb-0">DATOS DEL PADRE/MADRE/TUTOR</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="form-label fw-bold mb-1">NOMBRE Y APELLIDOS</p>
                            <?php echo "<p class='ps-2'>{$datos['nombrePadre']} {$datos['apellidosPadre']}</p>"; ?>
                            
                        </div>
                        <div class="mb-3">
                            <p class="form-label fw-bold mb-1">TELÉFONO</p>
                            <?php echo "<p class='ps-2'>{$datos['telefono']}</p>" ?>
                        </div>
                        <div class="mb-3">
                            <p class="form-label fw-bold mb-1">CORREO</p>
                            <?php echo "<p class='ps-2'>{$datos['correo']}</p>" ?>
                        </div>
                        
                    </div>
                </div>

                <!-- Datos del alumno -->
                <div class="card mb-4">
                    <div class="card-header text-white" style="background-color: #006EA4;">
                        <h5 class="mb-0">DATOS DEL ALUMNO</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="form-label fw-bold mb-1">NOMBRE Y APELLIDOS</p>
                            <?php echo "<p class='ps-2'>{$datos['nombreAlumno']} {$datos['apellidosAlumno']}</p>" ?>
                        </div>
                        <div class="mb-3">
                            <p class="form-label fw-bold mb-1">CLASE</p>
                            <?php echo "<p class='ps-2'>{$datos['clase']}</p>" ?>

                        </div>
                    </div>
                </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>