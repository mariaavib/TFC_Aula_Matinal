document.addEventListener('DOMContentLoaded', function() {
    // Control de asistencia
    const checkboxes = document.querySelectorAll('.control-asistencia');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const idAlumno = this.dataset.id;
            const asiste = this.checked;
            const originalState = this.checked;
            
            fetch('index.php?c=ControlAsistencia&m=registrarAsistencia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `idAlumno=${idAlumno}&asiste=${asiste}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // If there's an error, revert the checkbox
                    this.checked = !this.checked;
                    alert('Error al actualizar la asistencia');
                }
            })
            .catch(error => {
                // If there's an error, revert the checkbox
                this.checked = originalState;
                alert('Error de conexión');
            });
        });
    });
});