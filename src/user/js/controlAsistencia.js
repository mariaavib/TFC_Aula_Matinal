document.addEventListener('DOMContentLoaded', function() {
    // Control de asistencia
    const checkboxes = document.querySelectorAll('.control-asistencia');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const idAlumno = this.dataset.id;
            const asiste = this.checked;
            
            fetch('index.php?c=ControlAsistencia&m=registrarAsistencia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `idAlumno=${idAlumno}&asiste=${asiste}`
            });
        });
    });

});