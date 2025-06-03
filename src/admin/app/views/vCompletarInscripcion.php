<!DOCTYPE html>
<html lang="es">
<head>
    <title>Modificar Inscripciones</title>
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>

    <div class="container mt-3">
        <div class="mb-3">
            <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn" style="background-color: #006EA4; color: white;">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>
        </div>
        <?php if (isset($datos['errores']) && !empty($datos['errores'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-auto" style="max-width: 650px;" role="alert">
                <strong>Por favor, corrija los siguientes errores:</strong>
                <ul>
                    <?php foreach ($datos['errores'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    MODIFICAR DATOS DE INSCRIPCIÓN
                    <hr>
                </h4>
                <form action="index.php?c=GestionInscripciones&m=procesosCompletado&id=<?php echo $datos['id_inscripcion']; ?>" method="post">
                <!-- Datos del tutor -->
                <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL PADRE/MADRE/TUTOR</h5>
                        </div>
                        <div class="card-body" style="background-color:  #d9ebf5;">
                            <div class="mb-3">
                                <label class="form-label">NOMBRE</label>
                                <?php echo "<input type='text' name='nombrePadre' value='{$datos['datos']['nombrePadre']}' placeholder='Nombre del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <?php echo "<input type='text' name='apellidosPadre' value='{$datos['datos']['apellidosPadre']}' placeholder='Apellidos del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DNI</label>
                                <?php echo "<input type='text' name='DNI' value='{$datos['datos']['DNI']}' placeholder='DNI del tutor' class='form-control bg-light'>" ?>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">TELÉFONO</label>
                                <?php echo "<input type='text' name='telefono' value='{$datos['datos']['telefono']}' placeholder='Teléfono del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CORREO</label>
                                <?php echo "<input type='text' name='correo' value='{$datos['datos']['correo']}' placeholder='Correo del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IBAN</label>
                                <?php echo "<input type='text' name='IBAN' value='{$datos['datos']['IBAN']}' placeholder='IBAN del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TITULAR DE LA CUENTA</label>
                                <?php echo "<input type='text' name='titularCuenta' value='{$datos['datos']['titularCuenta']}' placeholder='Titular de la cuenta de banco del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FECHA MANDATO</label>
                                <?php echo "<input type='date' name='fechaMandato' value='{$datos['datos']['fechaMandato']}' class='form-control bg-light'>" ?>
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
                                <label class="form-label">NOMBRE</label>
                                <?php echo "<input type='text' name='nombreAlumno' value='{$datos['datos']['nombreAlumno']}' placeholder='Nombre del alumno' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <?php echo "<input type='text' name='apellidosAlumno' value='{$datos['datos']['apellidosAlumno']}' placeholder='Apellidos del alumno' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CLASE</label>
                                <select name='idClase' class="form-select bg-light">
                                    <option>SELECCIONE UNA CLASE</option>
                                    <?php 
                                    foreach($datos['clases'] as $clase){
                                        $selected = (isset($datos['datos']['idClase']) && $datos['datos']['idClase'] == $clase['idClase']) ? 'selected' : '';
                                        echo "<option value='{$clase['idClase']}' $selected>{$clase['clase']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                        <button type="submit" name="accion" value="completar" class="btn me-2" style="background-color: #006EA4; color: white;">COMPLETAR INSCRIPCIÓN</button>
                        <button type="submit" name="accion" value="guardar_pendiente" class="btn" style="background-color: #006EA4; color: white;">GUARDAR CON DATOS PENDIENTES</button>
                    </div>
                </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>