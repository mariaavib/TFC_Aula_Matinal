/**
 * Función para validar los datos de un alumno.
 */
export class AlumnoModelo {
    static validar(datos) {
        const errores = [];

        if (!datos.nombreAlumno) errores.push("El nombre del alumno es obligatorio");
        if (!datos.apellidosAlumno) errores.push("Los apellidos del alumno son obligatorios");
        if (!datos.nombrePadre) errores.push("El nombre del padre/madre/tutor es obligatorio");
        if (!datos.apellidosPadre) errores.push("Los apellidos del padre/madre/tutor son obligatorios");
        if (!datos.telefono) {
            errores.push("El teléfono es obligatorio");
        } else if (!/^\+?[1-9][0-9]{7,14}$/.test(datos.telefono)) {
            errores.push("El teléfono no es válido (puede contener '+' al inicio, código país de 1 a 3 dígitos y número nacional de 4 a 14 dígitos)");
        }
        if (!datos.idClase) errores.push("Debe seleccionar una clase");

        return errores;
    }
}