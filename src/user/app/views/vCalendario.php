
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
    <title>Panel Monitor - Días No Lectivos</title>
    <link rel="icon" href="assets/img/favicon-img.png" type="image/x-icon">
    <!-- FullCalendar Bundle libreria para mostrar el calendario-->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet'>
</head>
<body>
    <?php require_once('layouts/headerUser.php'); ?>
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
    <!-- Modal para mostrar detalles del día no lectivo -->
    <div class="modal fade" id="detalleDiaModal" tabindex="-1" aria-labelledby="detalleDiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom text-white">
                    <h5 class="modal-title" id="detalleDiaModalLabel">Detalle Día No Lectivo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p id="detalleMotivo"></p>
                    <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/views/diasNoLectivos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
