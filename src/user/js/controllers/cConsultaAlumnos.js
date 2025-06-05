/**
 * Función para configurar eventos para los botones de ver detalles.
 */
import { obtenerDetallesAlumno } from "../models/mConsultaAlumnos.js";
import { mostrarModalDetalles } from "../views/vConsultaAlumnos.js";

function configurarEventosDetalles() {
    const botonesVer = document.querySelectorAll('.ver-detalles');
    console.log('Botones encontrados:', botonesVer.length);

    botonesVer.forEach(boton => {
        boton.addEventListener('click', async function () {
            const id = this.getAttribute('data-id');
            console.log('Botón clicado, id:', id);
            const data = await obtenerDetallesAlumno(id);
            console.log('Datos recibidos:', data);
            if (data.success) {
                mostrarModalDetalles(data.alumno);
            } else {
                console.warn('No se recibió éxito en la respuesta');
            }
        });
    });
}

function configurarBuscadorAlumnos() {
    const inputBuscador = document.getElementById('buscadorAlumnos');
    const filas = document.querySelectorAll('table tbody tr');

    inputBuscador.addEventListener('input', function () {
        const filtro = this.value.toLowerCase();

        filas.forEach(fila => {
            const nombre = fila.querySelector('td')?.textContent.toLowerCase();
            if (nombre.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado, configurando eventos...');
    configurarEventosDetalles();
    configurarBuscadorAlumnos();
});
