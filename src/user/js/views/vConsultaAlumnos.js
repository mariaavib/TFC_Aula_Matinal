/**
 * Vista para mostrar en el modal los detalles del alumno seleccionado
 * 
 */
export function mostrarModalDetalles(alumno) {
    const modal = new bootstrap.Modal(document.getElementById('detallesModal'));
    const contenedor = document.getElementById('detallesAlumno');
    contenedor.innerHTML = `
        <div><strong>Nombre del Alumno:</strong> ${alumno.nombreAlumno} ${alumno.apellidosAlumno}</div>
        <div><strong>Clase:</strong> ${alumno.clase}</div>
        <div><strong>Nombre del Padre:</strong> ${alumno.nombrePadre || 'Por determinar'} ${alumno.apellidosPadre || ''}</div>
        <div><strong>Teléfono:</strong> ${alumno.telefono}</div>
    `;
    modal.show();
}