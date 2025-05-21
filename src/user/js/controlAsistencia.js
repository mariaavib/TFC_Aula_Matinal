/**
 * Controla la asistencia de los alumnos mediante checkbox
 * 
 * Cuando se merca el checckbox se envia la asistencia al servidor a través del fetch
 * Necesita que el checkbox tenga el atributo data-id con el id del alumno
 */
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.control-asistencia');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const idAlumno = this.dataset.id;
            const asiste = this.checked ? 1 : 0;
            
            this.disabled = true;
            
            fetch('index.php?c=ControlAsistencia&m=registrarAsistencia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `idAlumno=${idAlumno}&asiste=${asiste}`
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta:', data); 
                if (!data.success) {
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
});