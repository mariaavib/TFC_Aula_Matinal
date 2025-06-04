<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/img/logoEscuela.png" alt="Logo Escuela" class="navbar-logo">
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="inicioCursoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INSCRIPCIONES
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="inicioCursoDropdown">
                                <li><a class="dropdown-item" href="index.php?c=GestionInscripciones&m=alta">AÑADIR ALUMNO</a></li>
                                <li><a class="dropdown-item" href="index.php?c=GestionInscripciones&m=alumnosinscritos">ALUMNOS INSCRITOS</a></li>
                                <li><a class="dropdown-item" href="index.php?c=GestionInscripciones&m=inscripcionesincompletas">INSCRIPCIONES INCOMPLETAS</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../user/index.php?c=ControlAsistencia&m=gestionar">GESTIÓN DÍA A DÍA</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="index.php?c=Remesas&m=listarRemesas" id="gestionRemesasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               GESTIÓN REMESAS
                           </a>
                           <ul class="dropdown-menu" aria-labelledby="gestionRemesasDropdown">
                                <li><a class="dropdown-item" href="index.php?c=Remesas&m=listarRemesas">REMESAS</a></li>
                                <li><a class="dropdown-item" href="index.php?c=Remesas&m=datosMensuales">DATOS MENSUALES</a></li>
                           </ul>
                       </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=Tarifas&m=tarifas">TARIFAS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="inicioCursoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INICIO CURSO
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="inicioCursoDropdown">
                                <li><a class="dropdown-item" href="index.php?c=DiasNoLectivos&m=listar">DÍAS NO LECTIVOS</a></li>
                                <li><a class="dropdown-item" href="index.php?c=FechaCurso&m=fechaCurso">FECHA CURSO</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    