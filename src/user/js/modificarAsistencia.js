/**
 * Gestiona la busqueda de asistencias y la modificación de las mismas.
 */

document.addEventListener('DOMContentLoaded', function(){
    const btnBuscar = document.getElementById('btnBuscar');
    const checkboxes = document.querySelectorAll('.form-check-input');

    if (btnBuscar) {
        btnBuscar.addEventListener('click', buscarAsistencias);
    }

    if (checkboxes) {
        checkboxes.forEach(checkbox =>{
            checkbox.addEventListener('change', modificarAsistencia);
        });
    }
});

/**
 * Valida la fecha seleccionada y muestra las asistencias correspondientes.
 * 
 */
function buscarAsistencias(){
    const dia = document.getElementById('dia').value;
    const mes = document.getElementById('mes').value;
    const anio = document.getElementById('anio').value;
    
    if(!dia || !mes || !anio) {
        alert('Por favor, seleccione una fecha completa');
        return;
    }

    window.location.href = `index.php?c=ControlAsistencia&m=modificar&dia=${dia}&mes=${mes}&anio=${anio}`;
}

/**
 * Modifica la asistencia de un alumno en una fecha específica.
 */
function modificarAsistencia(){
    const idAlumno = this.dataset.id;
    const fecha = document.getElementById('fechaSeleccionada').value;
    const asiste = this.checked ? 1 : 0;

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
            alert('Error al modificar la asistencia');
            this.checked = !this.checked;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al modificar la asistencia');
        this.checked = !this.checked;
    });
}