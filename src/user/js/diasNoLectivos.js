document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        buttonText: {
            today: 'Hoy'
        },
        firstDay: 1,
        events: 'index.php?c=DiasNoLectivos&m=diasFestivos',
        eventDidMount: function(info) {
            info.el.title = info.event.title;
        },
        displayEventTime: false,
        height: 'auto',
        eventClick: function(info) {
            alert('Día no lectivo: ' + info.event.title);
        }
    });
    calendar.render();
});