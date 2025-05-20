document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad del buscador
    const buscador = document.getElementById('buscadorAlumnos');
    if (buscador) {
        buscador.addEventListener('input', function() {
            const textoBusqueda = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll('.table tbody tr');

            filas.forEach(fila => {
                const nombreAlumno = fila.querySelector('td:first-child').textContent.toLowerCase();
                if (nombreAlumno.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }

    const botonesVer = document.querySelectorAll('.ver-detalles');
    const modalDetalles = new bootstrap.Modal(document.getElementById('detallesModal'));
    
    botonesVer.forEach(boton => {
        boton.addEventListener('click', async function() {
            const idAlumno = this.getAttribute('data-id');
            try {
                const response = await fetch(`index.php?c=Alumnos&m=obtenerDetalles&id=${idAlumno}`);
                const data = await response.json();
                
                if (data.success) {
                    const alumno = data.alumno;
                    document.getElementById('detallesAlumno').innerHTML = `
                        <div class="mb-3">
                            <strong>Nombre del Alumno:</strong> ${alumno.nombreAlumno}
                        </div>
                        <div class="mb-3">
                            <strong>Teléfono:</strong> ${alumno.telefono}
                        </div>
                        <div class="mb-3">
                            <strong>Nombre del Padre:</strong> ${alumno.nombrePadre || 'No especificado'}
                        </div>
                    `;
                    modalDetalles.show();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});