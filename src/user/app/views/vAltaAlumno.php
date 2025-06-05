<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Monitor - Control Asistencia</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon" />
</head>
<body>
<?php require_once('layouts/headerUser.php'); ?>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="text-center mb-4 form-header" style="color: #006EA4;">
                NUEVO ALUMNO
                <hr style="color: #006EA4;"/>
            </h4>
            <?php
                if (!empty($datos['error'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $datos['error'];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>';
                    echo '</div>';
                }
            ?>
            <div class="alert alert-danger d-none" role="alert"></div>
            <form action="index.php?c=Alumnos&m=insertar" method="POST">
                <div class="card mb-4">
                    <div class="card-header text-white" style="background-color: #006EA4;">
                        <h5 class="mb-0">DATOS DEL ALUMNO</h5>
                    </div>
                    <div class="card-body" style="background-color:  #bcd7e4;">
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151);">NOMBRE DEL ALUMNO</label>
                            <input type="text" name="nombreAlumno" class="form-control bg-light" value="<?php echo (isset($datos['datosForm']['nombreAlumno'])) ? $datos['datosForm']['nombreAlumno'] : '';?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151)">APELLIDOS DEL ALUMNO</label>
                            <input type="text" name="apellidosAlumno" class="form-control bg-light" value="<?php echo (isset($datos['datosForm']['apellidosAlumno'])) ? $datos['datosForm']['apellidosAlumno'] : '';?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151)">NOMBRE PADRE/MADRE O TUTOR LEGAL</label>
                            <input type="text" name="nombrePadre" class="form-control bg-light" value="<?php echo (isset($datos['datosForm']['nombrePadre'])) ? $datos['datosForm']['nombrePadre'] : '';?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151)">APELLIDOS PADRE/MADRE O TUTOR LEGAL</label>
                            <input type="text" name="apellidosPadre" class="form-control bg-light" value="<?php echo (isset($datos['datosForm']['apellidosPadre'])) ? $datos['datosForm']['apellidosPadre'] : '';?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151)">TELÉFONO PADRE/MADRE O TUTOR LEGAL</label>
                            <input type="text" name="telefono" class="form-control bg-light" value="<?php echo (isset($datos['datosForm']['telefono'])) ? $datos['datosForm']['telefono'] : ''; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color:rgb(44, 100, 151)">CLASE</label>
                            <select name="idClase" class="form-control bg-light">
                                <option value="" disabled <?php echo (!isset($datos['datosForm']['idClase'])) ? 'selected' : ''; ?>>Seleccione una clase</option>
                                <?php
                                if (!empty($datos['clases'])) {
                                    foreach ($datos['clases'] as $clase) {
                                        $selected = (isset($datos['datosForm']['idClase']) && $datos['datosForm']['idClase'] == $clase['idClase']) ? 'selected' : '';
                                        echo '<option value="' . $clase['idClase'] . '" ' . $selected . '>' . $clase['clase'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 mb-4">
                    <button type="submit" class="btn" style="background-color: #006EA4; color: white;">GUARDAR</button>
                    <a href="index.php?c=ControlAsistencia&m=gestionar" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="js/views/vAltaAlumnos.js"></script>
</body>
</html>
