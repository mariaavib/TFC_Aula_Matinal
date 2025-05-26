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
        session_start();
        include_once('layouts/headerAdmin.php');

        if(isset($_GET['origen'])) {
            $_SESSION['vista_origen'] = $_GET['origen'];
            
            $urlCancelar = $_SESSION['vista_origen'] === 'inscritos' 
            ? 'index.php?c=GestionInscripciones&m=alumnosinscritos'
            : 'index.php?c=GestionInscripciones&m=inscripcionesincompletas';
        }        
    ?>

    <div class="container mt-3">
        <div class="mb-3">
            <a href="<?php echo $urlCancelar; ?>" class="btn" style="background-color: #006EA4; color: white;">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    MODIFICAR DATOS DE INSCRIPCIÓN
                    <hr>
                </h4>
                <form action="index.php?c=GestionInscripciones&m=modificarInscripcion" method="post">
                <!-- Datos del tutor -->
                <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL PADRE/MADRE/TUTOR</h5>
                        </div>
                        <div class="card-body" style="background-color:  #d9ebf5;">
                            <div class="mb-3">
                                <label class="form-label">NOMBRE</label>
                                <?php echo "<input type='text' name='nombre_tutor' value='{$datos['datos']['nombrePadre']}' placeholder='Nombre del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <?php echo "<input type='text' name='apellidos_tutor' value='{$datos['datos']['apellidosPadre']}' placeholder='Apellidos del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DNI</label>
                                <?php echo "<input type='text' name='dni' value='{$datos['datos']['DNI']}' placeholder='DNI del tutor' class='form-control bg-light'>" ?>
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
                                <?php echo "<input type='text' name='iban' value='{$datos['datos']['IBAN']}' placeholder='IBAN del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TITULAR DE LA CUENTA</label>
                                <?php echo "<input type='text' name='titular' value='{$datos['datos']['titularCuenta']}' placeholder='Titular de la cuenta de banco del tutor' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FECHA MANDATO</label>
                                <?php echo "<input type='date' name='fechamandato' value='{$datos['datos']['fechaMandato']}' class='form-control bg-light'>" ?>
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
                                <?php echo "<input type='text' name='nombre_alumno' value='{$datos['datos']['nombreAlumno']}' placeholder='Nombre del alumno' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <?php echo "<input type='text' name='apellidos_alumno' value='{$datos['datos']['apellidosAlumno']}' placeholder='Apellidos del alumno' class='form-control bg-light'>" ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CLASE</label>
                                <select name='clase' class="form-select bg-light">
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
                        <?php if(isset($_SESSION['vista_origen']) && $_SESSION['vista_origen'] === 'inscritos'): ?>
                            <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                            <button type="submit" name="accion" value="guardar" class="btn" style="background-color: #006EA4; color: white;">GUARDAR CAMBIOS</button>
                        <?php else: ?>
                            <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                            <button type="submit" name="accion" value="completar" class="btn me-2" style="background-color: #006EA4; color: white;">COMPLETAR INSCRIPCIÓN</button>
                            <button type="submit" name="accion" value="guardar_pendiente" class="btn" style="background-color: #006EA4; color: white;">GUARDAR CON DATOS PENDIENTES</button>
                        <?php endif; ?>
                    </div>
                </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>