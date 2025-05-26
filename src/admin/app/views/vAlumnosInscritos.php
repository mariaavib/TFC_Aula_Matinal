<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos Inscritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>

    <div class="container dias-no-lectivos-container">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="section-header">
                ALUMNOS INSCRITOS
            </div>
        </div>
    <div class="mb-3 d-flex justify-content-between">
        <a href="index.php?c=GestionInscripciones&m=alta" class="btn add-button d-flex align-items-center px-3" style="width: fit-content; font-size: 0.9rem;">
            <i class="bi bi-person-plus me-2"></i> Añadir nuevo alumno
        </a>
        <a href="index.php?c=GestionInscripciones&m=inscripcionesincompletas" class="btn add-button d-flex align-items-center px-3" style="width: fit-content; font-size: 0.9rem;">
            <i class="bi bi-clipboard-check me-2"></i> Completar Inscripciones
        </a>
    </div>
    <div class="table-responsive">

        <div class="table-responsive">
            <table class="table mb-0 text-center">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clase</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_string($datos)){
                        echo "<tr><td colspan='3'><p class='text-danger fw-bold'>{$datos}</p></td></tr>";
                    }else{
                        foreach($datos as $dato){
                        echo '<tr class="align-middle">';
                        echo "<td>{$dato['nombreAlumno']}</td>";
                        echo "<td>{$dato['clase']}</td>";
                        echo '<td>';
                        echo "<a href='index.php?c=GestionInscripciones&m=consultardatos&id={$dato['idInscripcion']}' class='btn btn-sm action-button me-2'>
                                <i class='bi bi-info-circle'></i>
                            </a>";
                        echo "<a href='index.php?c=GestionInscripciones&m=modificacion&id={$dato['idInscripcion']}&origen=inscritos' class='btn btn-sm action-button'>
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
</body>
</html>