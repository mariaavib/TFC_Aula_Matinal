/**
 * Controla la asistencia de los alumnos mediante checkbox
 * 
 * Cuando se merca el checckbox se envia la asistencia al servidor a través del fetch
 * Necesita que el checkbox tenga el atributo data-id con el id del alumno
 */
document.addEventListener('DOMContentLoaded', function(){
    const checkbox = document.querySelectorAll('.control-asistencia');
    checkbox.forEach(checkbox => {
        checkbox.addEventListener('change', function(){
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
            .then(response => response.text()) 
            .then(text => {
                console.log('Respuesta cruda:', text); 
                try {
                    const data = JSON.parse(text);
                    if (!data.success) {
                        checkbox.checked = !checkbox.checked;
                    }
                } catch (e) {
                    console.error('No es JSON válido:', e);
                    checkbox.checked = !checkbox.checked;
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                checkbox.checked = !checkbox.checked;
            })
            .finally(() => {
                checkbox.disabled = false;
            });            
        });
    });
});