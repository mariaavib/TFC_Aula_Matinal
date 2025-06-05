<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio - Bienvenida</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>
    
    <div class="modal fade" id="inscripcionesPendientesModal" tabindex="-1" aria-labelledby="inscripcionesPendientesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--azul-principal); color: white;">
                    <h5 class="modal-title" id="inscripcionesPendientesModalLabel">Aviso de Inscripciones</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?php if(isset($datos['total']) && $datos['total'] > 0): ?>
                        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3" style="color: red;">¡Atención!</h4>
                        <p class="lead">Hay <strong><?php echo $datos['total']; ?></strong> inscripción(es) incompleta(s).</p>
                        <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn mt-3" style="background-color: var(--azul-principal); color: white;">
                            <i class="bi bi-clipboard-check me-2"></i>Ver inscripciones pendientes
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body text-center p-5">
                        <h1 class="mb-4" style="color: var(--azul-principal);">¡Bienvenida, Pilar!</h1>
                        <p class="lead mb-5">Selecciona una de las siguientes opciones para gestionar el Aula Matinal</p>
                        
                        <div class="row justify-content-center g-4">
                            <div class="col-md-6">
                                <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn btn-lg w-100 py-3" style="background-color: var(--azul-principal); color: white;">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                    Inscripciones Incompletas
                                    <?php if(isset($datos['total']) && $datos['total'] > 0): ?>
                                        <span class="badge bg-danger ms-2"><?php echo $datos['total']; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn btn-lg w-100 py-3" style="background-color: var(--azul-principal); color: white;">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                    Inscripciones Completas
                                </a>
                            </div>
                            <div class="col-md-6 mt-4">
                                <a href="index.php?c=GestionInscripciones&m=alta" class="btn btn-lg w-100 py-3" style="background-color: var(--azul-principal); color: white;">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Añadir Alumno
                                </a>
                            </div>
                            <div class="col-md-6 mt-4">
                                <a href="index.php?c=Remesas&m=datosMensuales" class="btn btn-lg w-100 py-3" style="background-color: var(--azul-principal); color: white;">
                                    <i class="bi bi-calendar-date me-2"></i>
                                    Generar Remesas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar el modal automáticamente al cargar la página si hay inscripciones pendientes
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($datos['total']) && $datos['total'] > 0): ?>
                let inscripcionesModal = new bootstrap.Modal(document.getElementById('inscripcionesPendientesModal'));
                inscripcionesModal.show();
            <?php endif; ?>
        });
    </script>
</body>
</html>