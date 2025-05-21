/**
 * Inicializa y muestra el calendario con los días no lectivos.
 * Obtiene los días no lectivos del controlador DiasNoLectivos y los muestra en el calendario.
 */
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl,{
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar:{
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText:{
            today: 'Hoy'
        },
        selectable: false, 
        events: 'index.php?c=DiasNoLectivos&m=obtenerDiasNoLectivos',
        eventColor: '#006EA4',
    });
    calendar.render();
});
