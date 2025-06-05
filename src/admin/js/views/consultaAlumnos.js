/**
 * Modal para generar la remesa y para mostrar detalles del alumno
 */
document.addEventListener('DOMContentLoaded', function () {
    const abrirModalBtn = document.getElementById('abrirGenerarRemesa');
    const generarModal = new bootstrap.Modal(document.getElementById('generarRemesaModal'));

    abrirModalBtn?.addEventListener('click', () => {
        generarModal.show();
    });

    const fechaRemesa = document.getElementById('fechaRemesa');
    if (fechaRemesa) {
        const hoy = new Date();
        fechaRemesa.value = hoy.toISOString().split('T')[0];
    }

    const form = document.getElementById('formGenerarRemesa');
    if (form) {
        form.addEventListener('submit', function () {
            
            setTimeout(() => {
                generarModal.hide();
            }, 3000);
        });
    }
});

function mostrarDetallesAlumno(idAlumno) {
    console.log("mostrarDetallesAlumno id:", idAlumno);
    const datosMesAnio = document.getElementById('datosMesAnio');
    const mes = parseInt(datosMesAnio.getAttribute('data-mes'));
    const anio = parseInt(datosMesAnio.getAttribute('data-anio'));

    fetch(`index.php?c=Remesas&m=obtenerDetallesAlumno&id=${idAlumno}&mes=${mes}&anio=${anio}`)
        .then(res => {
            if (!res.ok) {
                throw new Error('Error HTTP: ' + res.status);
            }
            return res.text(); 
        })
        .then(text => {
            try {
                const data = JSON.parse(text); // Intentar parsear a JSON
                if (!Array.isArray(data) || data.length === 0) {
                    document.getElementById('detallesAlumno').innerHTML = '<p>No hay detalles disponibles.</p>';
                } else {
                    const alumno = data[0];
                    const listaDias = data.map(dia => `<li class="list-group-item">${new Date(dia.fecha).toLocaleDateString('es-ES')}</li>`).join('');
                    document.getElementById('detallesAlumno').innerHTML = `
                        <div><strong>Nombre del Alumno:</strong> ${alumno.nombreAlumno} ${alumno.apellidosAlumno}</div>
                        <div><strong>Nombre del Padre:</strong> ${alumno.nombrePadre} ${alumno.apellidosPadre}</div>
                        <div><strong>Teléfono:</strong> ${alumno.telefono}</div>
                        <div class="mt-2"><strong>Días asistidos:</strong>
                            <ul class="list-group mt-2">${listaDias}</ul>
                        </div>`;
                }
                const detallesModal = new bootstrap.Modal(document.getElementById('detallesModal'));
                detallesModal.show();
            } catch (error) {
                console.error('Respuesta no es JSON válido:', text);
                alert('Error: la respuesta del servidor no es válida.');
            }
        })
        .catch(err => {
            console.error('Error al obtener detalles:', err);
            alert('Error al obtener detalles del alumno.');
        });
}
