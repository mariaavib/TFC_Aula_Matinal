<?php
    /**
     * Vista del panel de control de asistencia para dar de alta a un alumno
     *
     * Muestra un formulario para dar de alta a un nuevo alumno
     * 
     */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor Control Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="assets/img/logoEscuela.png" alt="Logo Escuela" class="navbar-logo">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?c=ControlAsistencia&m=gestionar">CONTROL ASISTENCIA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php?c=Alumnos&m=alta">ALTA ALUMNO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?c=Alumnos&m=consultar">CONSULTAR ALUMNOS</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php?c=DiasNoLectivos&m=verCalendario">DIAS NO LECTIVOS</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>
    <div class="container mt-3"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    NUEVO ALUMNO
                    <hr>
                </h4>
                <div class="alert alert-danger" style="display: none;"></div>
                <form action="index.php?c=Alumnos&m=insertar" method="POST">
                    <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL ALUMNO</h5>
                        </div>
                        <div class="card-body" style="background-color:  #bcd7e4;">
                            <div class="mb-3">
                                <label class="form-label">NOMBRE Y APELLIDOS</label>
                                <input type="text" name="nombreAlumno" class="form-control bg-light">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TELÉFONO PADRE/MADRE O TUTOR LEGAL</label>
                                <input type="text" name="telefono" class="form-control bg-light">
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <a href="index.php?c=ControlASistencia&m=gestionar" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                        <button type="submit" class="btn" style="background-color: #006EA4; color: white;">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/altaAlumno.js"></script>
</body>
</html>
