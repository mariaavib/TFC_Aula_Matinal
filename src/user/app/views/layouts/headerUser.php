<?php
$controladorActual = isset($_GET['c']) ? $_GET['c'] : '';
$metodoActual = isset($_GET['m']) ? $_GET['m'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <?php
                        $clase = '';
                        if ($controladorActual == 'ControlAsistencia' && $metodoActual == 'gestionar') {
                            $clase = 'active';
                        }
                        ?>
                        <a class="nav-link <?php echo $clase; ?>" href="index.php?c=ControlAsistencia&m=gestionar">CONTROL ASISTENCIA</a>
                    </li>

                    <li class="nav-item">
                        <?php
                        $clase = '';
                        if ($controladorActual == 'Alumnos' && $metodoActual == 'alta') {
                            $clase = 'active';
                        }
                        ?>
                        <a class="nav-link <?php echo $clase; ?>" href="index.php?c=Alumnos&m=alta">ALTA ALUMNO</a>
                    </li>

                    <li class="nav-item">
                        <?php
                        $clase = '';
                        if ($controladorActual == 'ControlAsistencia' && $metodoActual == 'modificar') {
                            $clase = 'active';
                        }
                        ?>
                        <a class="nav-link <?php echo $clase; ?>" href="index.php?c=ControlAsistencia&m=modificar">MODIFICAR ASISTENCIA</a>
                    </li>

                    <li class="nav-item">
                        <?php
                        $clase = '';
                        if ($controladorActual == 'Alumnos' && $metodoActual == 'consultar') {
                            $clase = 'active';
                        }
                        ?>
                        <a class="nav-link <?php echo $clase; ?>" href="index.php?c=Alumnos&m=consultar">CONSULTAR ALUMNOS</a>
                    </li>

                    <li class="nav-item">
                        <?php
                        $clase = '';
                        if ($controladorActual == 'DiasNoLectivos' && $metodoActual == 'verCalendario') {
                            $clase = 'active';
                        }
                        ?>
                        <a class="nav-link <?php echo $clase; ?>" href="index.php?c=DiasNoLectivos&m=verCalendario">DIAS NO LECTIVOS</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
