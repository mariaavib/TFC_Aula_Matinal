document.addEventListener('DOMContentLoaded', function(){
    const checkboxes = document.querySelectorAll('.form-check-input');
    const formFecha = document.getElementById('formFecha');

    // Obtener la fecha del input hidden o del input date
    function obtenerFecha() {
        const fechaInput = document.getElementById('fecha');
        const fechaHidden = document.getElementById('fechaSQL'); // Añadiremos este input hidden
        return fechaHidden ? fechaHidden.value : fechaInput.value;
    }

    if(checkboxes){
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const fecha = obtenerFecha();
                if(!fecha) {
                    alert('Por favor, seleccione una fecha y haga clic en ACEPTAR');
                    this.checked = !this.checked;
                    return;
                }
                
                const idAlumno = this.dataset.id;
                const asiste = this.checked ? 1 : 0;

                console.log('Enviando datos:', { idAlumno, fecha, asiste });

                fetch('index.php?c=ControlAsistencia&m=modificarAsistencia', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `idAlumno=${idAlumno}&fecha=${fecha}&asiste=${asiste}`
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.error || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al modificar la asistencia: ' + error.message);
                    this.checked = !this.checked;
                });
            });
        });
    }
});
