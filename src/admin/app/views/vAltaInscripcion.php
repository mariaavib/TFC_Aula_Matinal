<!DOCTYPE html>
<html lang="es">
<head>
    <title>Añadir Nuevo Alumno</title>
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
        <?php if (isset($datos['errores']) && !empty($datos['errores'])): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 650px;" role="alert">
                <strong>Por favor, corrija los siguientes errores:</strong>
                <ul>
                    <?php foreach ($datos['errores'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
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
                                <label class="form-label">DNI/NIE/PASAPORTE</label>
                                <input type="text" name="dni" class="form-control bg-light" placeholder="DNI del tutor">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TELÉFONO</label>
                                <input type="number" name="telefono" class="form-control bg-light" placeholder="Teléfono del tutor">
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
                        <button type="submit" class="btn" style="background-color: #006EA4; color: white;">GUARDAR</button>
                        <a href="index.php?c=GestionInscripciones&m=alumnosinscritos" class="btn me-2" style="background-color: #006EA4; color: white;">CANCELAR</a>
                    </div>
                </form>                
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>