<?php
    /**
     * Vista del panel de control de asistencia para ver los dias festivos
     *
     * Muestra un calendario por meses y salen los dias festivos, el calendario se genera con la libreria fullcalendar
     * 
     */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor - Días No Lectivos</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet'>
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
                                <a class="nav-link" href="index.php?c=Alumnos&m=alta">ALTA ALUMNO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?c=Alumnos&m=consultar">CONSULTAR ALUMNOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php?c=DiasNoLectivos&m=verCalendario">DIAS NO LECTIVOS</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    <div class="container mt-4">
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <h4 class="bg-custom-secondary-mod text-white px-4 py-2 rounded">
                    Calendario Escolar
                </h4>
            </div>
        </div>
        <div id='calendar'></div>
    </div>
    <script src="js/diasNoLectivos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
