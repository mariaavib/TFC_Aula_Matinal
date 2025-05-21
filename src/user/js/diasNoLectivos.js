document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        selectable: true,
        select: function(info) {
            // Manejo de selección de días
            const fecha = info.start;
            if (confirm('¿Desea marcar este día como no lectivo?')) {
                marcarDiaNoLectivo(fecha);
            }
        },
        events: 'index.php?c=DiasNoLectivos&m=obtenerDiasNoLectivos',
        eventColor: '#006EA4'
    });
    calendar.render();
});

function marcarDiaNoLectivo(fecha) {
    const formattedDate = fecha.toISOString().split('T')[0];
    fetch('index.php?c=DiasNoLectivos&m=marcarDiaNoLectivo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'fecha=' + formattedDate
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            calendar.refetchEvents();
        } else {
            alert('Error al marcar el día como no lectivo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
}
