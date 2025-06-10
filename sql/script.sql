CREATE DATABASE aula_matinal;
USE aula_matinal;

-- =========================================
-- Tabla: clases
-- =========================================
CREATE TABLE clases (
    idClase TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    clase CHAR(10) NOT NULL,
    CONSTRAINT pk_clases PRIMARY KEY (idClase)
);

-- =========================================
-- Tabla: inscripciones
-- =========================================
CREATE TABLE inscripciones (
    idInscripcion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombrePadre VARCHAR(50) NULL,
    apellidosPadre VARCHAR(100) NULL,
    DNI CHAR(20) NULL,
    IBAN CHAR(34) NULL,
    titularCuenta VARCHAR(100) NULL,
    fechaMandato DATE NULL,
    telefono CHAR(24) NOT NULL,
    correo VARCHAR(254) NULL,
    completada BIT NOT NULL,
    CONSTRAINT pk_idInscripcion PRIMARY KEY (idInscripcion)
);

-- =========================================
-- Tabla: alumno
-- =========================================
CREATE TABLE alumno (
    idAlumno SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombreAlumno VARCHAR(50) NOT NULL,
    apellidosAlumno VARCHAR(100) NOT NULL,
    idClase TINYINT UNSIGNED NOT NULL,
    idInscripcion SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_idAlumno PRIMARY KEY (idAlumno),
    CONSTRAINT fk_idClases FOREIGN KEY (idClase) REFERENCES clases(idClase)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_idInscripciones FOREIGN KEY (idInscripcion) REFERENCES inscripciones(idInscripcion)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =========================================
-- Tabla: asistencia
-- =========================================
CREATE TABLE asistencia (
    idAsistencia SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL,
    reciboEmitido BIT(1) NOT NULL,
    idAlumno SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_idAsistencia PRIMARY KEY (idAsistencia),
    CONSTRAINT fk_idAlumno FOREIGN KEY (idAlumno) REFERENCES alumno(idAlumno)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =========================================
-- Tabla: remesas
-- =========================================
CREATE TABLE remesas (
    idRemesa INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fechaGenerada DATE NOT NULL,
    mes TINYINT UNSIGNED NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_idRemesa PRIMARY KEY (idRemesa),
    CONSTRAINT csu_mes_anio UNIQUE (mes, anio)
);

-- =========================================
-- Tabla: recibos
-- =========================================
CREATE TABLE recibos (
    idRecibo INT UNSIGNED NOT NULL AUTO_INCREMENT,
    diasAsistidos TINYINT UNSIGNED NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    mes TINYINT UNSIGNED NOT NULL,
    totalDias TINYINT UNSIGNED NOT NULL,
    totalPrecio DECIMAL(10,2) NOT NULL,
    idAlumno SMALLINT UNSIGNED NOT NULL,
    idRemesa INT UNSIGNED NOT NULL,
    CONSTRAINT pk_idRecibo PRIMARY KEY (idRecibo),
    CONSTRAINT fk_idAlumnoRecibos FOREIGN KEY (idAlumno) REFERENCES alumno(idAlumno)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_idRemesa FOREIGN KEY (idRemesa) REFERENCES remesas(idRemesa)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- =========================================
-- Tabla: dias_no_lectivos
-- =========================================
CREATE TABLE dias_no_lectivos (
    idDia SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL,
    motivo VARCHAR(100) NOT NULL,
    CONSTRAINT pk_idDia PRIMARY KEY (idDia)
);

-- =========================================
-- Tabla: datos_aplicaion
-- =========================================
CREATE TABLE datos_aplicaion (
    inicioCurso DATE NULL,
    finCurso DATE NULL,
    numDias SMALLINT UNSIGNED NULL,
    precioDia DECIMAL(10,2) NULL,
    precioMes DECIMAL(10,2) NULL
);
