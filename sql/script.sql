CREATE DATABASE IF NOT EXISTS aula_matinal;
USE aula_matinal;

CREATE TABLE dias_no_lectivos(
    idDia smallint unsigned not null auto_increment,
    fecha date not null,
    motivo varchar(100) not null,
    CONSTRAINT pk_dias_no_lectivos PRIMARY KEY(idDia)
);

CREATE TABLE inscripciones (
    idInscripcion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombrePadre VARCHAR(100) NOT NULL,
    DNI CHAR(9) NULL,
    IBAN CHAR(34) NULL,
    titularCuenta VARCHAR(100) NULL,
    fechaMandato DATE NOT NULL,
    telefono CHAR(9) NOT NULL,
    correo VARCHAR(255) NULL,
    completada BIT NOT NULL,
    CONSTRAINT pk_idInscripcion PRIMARY KEY (idInscripcion)
);

CREATE TABLE alumno(
    idAlumno smallint unsigned not null auto_increment,
    nombreAlumno varchar(100) not null,
    idClase tinyint unsigned not null,
    idInscripcion smallint unsigned not null,
    CONSTRAINT pk_idAlumno PRIMARY KEY(idAlumno),
    CONSTRAINT fk_idClases FOREIGN KEY(idClase) REFERENCES clases(idClase),
    CONSTRAINT fk_idInscripciones FOREIGN KEY(idInscripcion) REFERENCES inscripciones(idInscripcion)
);

CREATE TABLE asistencia(
    idAsistencia smallint unsigned not null auto_increment,
    fecha date not null,
    pagado bit not null,
    idAlumno smallint unsigned not null,
    CONSTRAINT pk_idAsistencia PRIMARY KEY(idAsistencia),
    CONSTRAINT fk_idAlumno FOREIGN KEY(idAlumno) REFERENCES alumno(idAlumno)
);

