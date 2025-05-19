document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.control-asistencia');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', registrarAsistencia);
    });
});

function registrarAsistencia() {
    const idAlumno = this.dataset.id;
    const asiste = this.checked ? 1 : 0;
    
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
            alert('Error al procesar la asistencia');
            this.checked = !this.checked;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la asistencia');
        this.checked = !this.checked;
    });
}