/**
 * Función para obtener los detalles de un alumno a través de una petición fetch.
 *  
 */
export async function obtenerDetallesAlumno(id) {
    try {
        const res = await fetch(`index.php?c=Alumnos&m=obtenerDetalles&id=${id}`);
        if (!res.ok) throw new Error('Error en la respuesta de la red');
        return await res.json();
    } catch (error) {
        console.error('Error al obtener detalles:', error);
        return { success: false };
    }
}
