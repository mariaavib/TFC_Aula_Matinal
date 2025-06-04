/**
 * Inicializa y muestra el calendario con los días no lectivos.
 * Obtiene los días no lectivos del controlador DiasNoLectivos y los muestra en el calendario.
 */
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText: {
            today: 'Hoy'
        },
        selectable: false,
        events: 'index.php?c=DiasNoLectivos&m=obtenerDiasNoLectivos',
        eventColor: '#006EA4',

        eventClick: function(info) {
            info.jsEvent.preventDefault();

            // Obtener modal y elementos dentro de él
            var modalEl = document.getElementById('detalleDiaModal');
            var motivoEl = document.getElementById('detalleMotivo');
            var fechaEl = document.getElementById('detalleFecha');

            // Poner contenido dinámico
            motivoEl.textContent = info.event.title;

            // Formatear la fecha del evento para mostrarla bonita
            var fecha = info.event.start;
            fechaEl.textContent = fecha.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Mostrar el modal usando Bootstrap 5 JS API
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
    calendar.render();
});

