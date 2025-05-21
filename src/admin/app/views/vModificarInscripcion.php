<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Inscripciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
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
                    MODIFICAR DATOS DE INSCRIPCIÓN
                    <hr>
                </h4>
                <form action="">
                <!-- Datos del tutor -->
                <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL PADRE/MADRE/TUTOR</h5>
                        </div>
                        <div class="card-body" style="background-color:  #d9ebf5;">
                        <div class="mb-3">
                                <label class="form-label">NOMBRE Y APELLIDOS</label>
                                <?php echo "<input type='text' value='{$datos['datos']['nombrePadre']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DNI</label>
                                <?php echo "<input type='text' value='{$datos['datos']['DNI']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CORREO</label>
                                <?php echo "<input type='text' value='{$datos['datos']['correo']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IBAN</label>
                                <?php echo "<input type='text' value='{$datos['datos']['IBAN']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TITULAR DE LA CUENTA</label>
                                <?php echo "<input type='text' value='{$datos['datos']['titularCuenta']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FECHA MANDATO</label>
                                <?php echo "<input type='date' value='{$datos['datos']['fechaMandato']}' class='form-control bg-light'>" ?>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del alumno -->
                    <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL ALUMNO</h5>
                        </div>
                        <div class="card-body" style="background-color:  #d9ebf5;">
                        <div class="mb-3">
                                <label class="form-label">NOMBRE Y APELLIDOS</label>
                                <?php echo "<input type='text' value='{$datos['datos']['nombreAlumno']}' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CLASE</label>
                                <select class="form-select bg-light">
                                    <option>SELECCIONE UNA CLASE</option>
                                    <?php 
                                    foreach($datos['clases'] as $clase) {
                                        $selected = ($clase['idClase'] == $datos['datos']['idClase']) ? 'selected' : '';
                                        echo "<option value='{$clase['idClase']}' {$selected}>{$clase['clase']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-4">
                        <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                        <button type="submit" class="btn" style="background-color: #006EA4; color: white;">GUARDAR</button>
                    </div>
                </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>