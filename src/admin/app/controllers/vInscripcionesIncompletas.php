<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inscripciones Incompletas</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--azul-principal); color: white;">
                    <h5 class="modal-title" id="ModalLabel">Aviso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?php if(isset($datos['errores']) && !empty($datos['errores'])): ?>
                        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3" style="color: red;">¡Atención!</h4>
                        <p class="lead"><strong><?php echo $datos['errores']; ?></strong></p>
                    <?php endif; ?>
                    <?php if (isset($datos['mensaje_exito'])): ?>
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <h4 class="mt-3" style="color: green;">¡Éxito!</h4>
                        <p class="lead"><strong><?php echo $datos['mensaje_exito']; ?></strong></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container dias-no-lectivos-container">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header">
                INSCRIPCIONES INCOMPLETAS   
            </div>
        </div>
        <div class="mb-3">
            <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn add-button d-flex align-items-center px-3" style="width: fit-content; font-size: 0.9rem;">
                <i class="bi bi-people me-2"></i> Inscripciones completas
            </a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 text-center">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($datos['noincompletas'])){
                        echo "<tr><td colspan='3'><p class='text-danger fw-bold'>{$datos['noincompletas']}</p></td></tr>";
                    }

                    if (isset($datos['datos'])){
                        foreach($datos['datos'] as $dato){
                        echo '<tr class="align-middle">';
                        echo "<td>{$dato['nombreAlumno']}</td>";
                        echo "<td>{$dato['telefono']}</td>";
                        echo '<td>';
                        echo "<a href='index.php?c=GestionInscripciones&m=completarInscripcion&id={$dato['idInscripcion']}' class='btn btn-sm action-button'>
                                <i class='bi bi-pencil'></i>
                            </a>";
                        echo '</td>';
                        echo '</tr>';
                    }
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($datos['errores']) || isset($datos['mensaje_exito'])): ?>
                let Modal = new bootstrap.Modal(document.getElementById('Modal'));
                Modal.show();
            <?php endif; ?>
        });
    </script>  
</body>
</html>