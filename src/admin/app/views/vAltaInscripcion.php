<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        include_once('layouts/headerAdmin.php');
    ?>

    <div class="container mt-3">
        <div class="mb-3">
            <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn" style="background-color: #006EA4; color: white;">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-4 form-header">
                    AÑADIR ALUMNO
                    <hr>
                </h4>
                <form method="post" action="index.php?c=GestionInscripciones&m=insertar">
                <!-- Datos del tutor -->
                <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL PADRE/MADRE/TUTOR</h5>
                        </div>
                        <div class="card-body" style="background-color:  #bcd7e4;">
                            <div class="mb-3">
                                <label class="form-label">NOMBRE</label>
                                <input type="text" name="nombre_tutor" class="form-control bg-light" placeholder="Nombre del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <input type="text" name="apellidos_tutor" class="form-control bg-light" placeholder="Apellidos del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DNI</label>
                                <input type="text" name="dni" class="form-control bg-light" placeholder="DNI del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TELÉFONO</label>
                                <input type="text" name="telefono" class="form-control bg-light" placeholder="Teléfono del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CORREO</label>
                                <input type="email" name="correo" class="form-control bg-light" placeholder="Email del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IBAN</label>
                                <input type="text" name="iban" class="form-control bg-light" placeholder="IBAN del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TITULAR DE LA CUENTA</label>
                                <input type="text" name="titular" class="form-control bg-light" placeholder="Titular de la cuenta de banco del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FECHA MANDATO</label>
                                <input type="date" name="fechamandato" class="form-control bg-light">
                            </div>
                        </div>
                    </div>

                    <!-- Datos del alumno -->
                    <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #006EA4;">
                            <h5 class="mb-0">DATOS DEL ALUMNO</h5>
                        </div>
                        <div class="card-body" style="background-color: #bcd7e4;">
                            <div class="mb-3">
                                <label class="form-label">NOMBRE</label>
                                <input type="text" name="nombre_alumno" class="form-control bg-light" placeholder="Nombre del alumno">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">APELLIDOS</label>
                                <input type="text" name="apellidos_alumno" class="form-control bg-light" placeholder="Apellidos del alumno">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CLASE</label>
                                <select name="clase" class="form-select bg-light">
                                    <option value="">SELECCIONE UNA CLASE</option>
                                <?php
                                if (isset($datos) && is_array($datos)){
                                        foreach($datos as $dato) {
                                        echo "<option value='{$dato['idClase']}'>{$dato['clase']}</option>";
                                    }
                                }
                                    
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-4">
                        <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                        <button type="submit" class="btn" style="background-color: #006EA4; color: white;">GUARDAR</button>
                    </div>
                </form>                
                <!-- Añadir antes del script de bootstrap -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.querySelector('form');
                        
                        // Función para validar DNI español
                        function validarDNI(dni) {
                            const dniRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
                            return dniRegex.test(dni);
                        }

                        // Función para validar IBAN español
                        function validarIBAN(iban) {
                            const ibanRegex = /^ES\d{22}$/;
                            return ibanRegex.test(iban);
                        }

                        // Función para validar teléfono español
                        function validarTelefono(telefono) {
                            const telefonoRegex = /^[6-9]\d{8}$/;
                            return telefonoRegex.test(telefono);
                        }

                        // Función para mostrar error
                        function mostrarError(input, mensaje) {
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                            const errorDiv = input.nextElementSibling || document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = mensaje;
                            if (!input.nextElementSibling) {
                                input.parentNode.appendChild(errorDiv);
                            }
                        }

                        // Función para mostrar éxito
                        function mostrarExito(input) {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                            const errorDiv = input.nextElementSibling;
                            if (errorDiv && errorDiv.className === 'invalid-feedback') {
                                errorDiv.remove();
                            }
                        }

                        form.addEventListener('submit', function(e) {
                            let formValido = true;
                            
                            // Validar nombre y apellidos del tutor
                            const nombreTutor = form.nombre_apellidos_tutor;
                            if (nombreTutor.value.trim().length == 0) {
                                mostrarError(nombreTutor, 'El nombre del tutor no puede estar vacío');
                                formValido = false;
                            } else {
                                mostrarExito(nombreTutor);
                            }

                            // Validar DNI
                            const dni = form.dni;
                            if (!validarDNI(dni.value.trim())) {
                                mostrarError(dni, 'DNI no válido');
                                formValido = false;
                            } else {
                                mostrarExito(dni);
                            }

                            // Validar teléfono
                            const telefono = form.telefono;
                            if (!validarTelefono(telefono.value.trim())) {
                                mostrarError(telefono, 'Teléfono no válido');
                                formValido = false;
                            } else {
                                mostrarExito(telefono);
                            }

                            // Validar email
                            const email = form.email;
                            if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                                mostrarError(email, 'Email no válido');
                                formValido = false;
                            } else {
                                mostrarExito(email);
                            }

                            // Validar IBAN
                            const iban = form.iban;
                            if (!validarIBAN(iban.value.trim())) {
                                mostrarError(iban, 'IBAN no válido (formato: ES + 22 dígitos)');
                                formValido = false;
                            } else {
                                mostrarExito(iban);
                            }

                            // Validar titular
                            const titular = form.titular;
                            if (titular.value.trim().length == 0) {
                                mostrarError(titular, 'El titular no puede estar vacío');
                                formValido = false;
                            } else {
                                mostrarExito(titular);
                            }

                            // Validar fecha mandato
                            const fechaMandato = form.fechamandato;
                            if (!fechaMandato.value) {
                                mostrarError(fechaMandato, 'La fecha es obligatoria');
                                formValido = false;
                            } else {
                                mostrarExito(fechaMandato);
                            }

                            // Validar nombre y apellidos del alumno
                            const nombreAlumno = form.nombre_apellidos_alumno;
                            if (nombreAlumno.value.trim().length < 5) {
                                mostrarError(nombreAlumno, 'El nombre debe tener al menos 5 caracteres');
                                formValido = false;
                            } else {
                                mostrarExito(nombreAlumno);
                            }

                            // Validar clase
                            const clase = form.clase;
                            if (!clase.value) {
                                mostrarError(clase, 'Debe seleccionar una clase');
                                formValido = false;
                            } else {
                                mostrarExito(clase);
                            }

                            if (!formValido) {
                                e.preventDefault();
                                // Mostrar alerta de Bootstrap
                                const alertaDiv = document.createElement('div');
                                alertaDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
                                alertaDiv.role = 'alert';
                                alertaDiv.innerHTML = `
                                    <strong>Error!</strong> Por favor, corrija los errores en el formulario.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                form.insertBefore(alertaDiv, form.firstChild);
                            }
                        });
                    });
                </script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>