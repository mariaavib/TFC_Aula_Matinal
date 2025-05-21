

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/img/logoEscuela.png" alt="Logo Escuela" class="navbar-logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                            <a class="nav-link" href="#">GESTIÓN DÍA A DÍA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">DATOS MENSUALES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">TARIFAS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="inicioCursoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INICIO CURSO
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="inicioCursoDropdown">
                                <li><a class="dropdown-item" href="app/views/vDiasNoLectivos.php">DÍAS NO LECTIVOS</a></li>
                                <li><a class="dropdown-item" href="app/views/vFechaCurso.php">FECHA CURSO</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>