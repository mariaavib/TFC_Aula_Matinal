CREATE DATABASE IF NOT EXISTS aula_matinal;
USE aula_matinal;

CREATE TABLE dias_no_lectivos(
    idDia smallint unsigned not null auto_increment,
    fecha date not null,
    motivo varchar(100) not null,
    CONSTRAINT pk_dias_no_lectivos PRIMARY KEY(idDia)
);

-- Tabla: CLASES
CREATE TABLE clases (
    idClase TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    clase CHAR(10) NOT NULL,
    PRIMARY KEY (idClase)
) ENGINE=InnoDB;

-- Tabla: INSCRIPCIONES
CREATE TABLE inscripciones (
    idInscripcion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombrePadre VARCHAR(50),
    apellidosPadre VARCHAR(100),
    DNI CHAR(9),
    IBAN CHAR(34),
    titularCuenta VARCHAR(100),
    fechaMandato DATE NOT NULL,
    telefono CHAR(9) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    completada BIT NOT NULL,
    PRIMARY KEY (idInscripcion)
) ENGINE=InnoDB;

-- Tabla: ALUMNO
CREATE TABLE alumno (
    idAlumno SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombreAlumno VARCHAR(50) NOT NULL,
    apellidosAlumno VARCHAR(100) NOT NULL,
    idClase TINYINT UNSIGNED NOT NULL,
    idInscripcion SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idAlumno),
    CONSTRAINT fk_clase FOREIGN KEY (idClase) REFERENCES clases(idClase) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_inscripcion FOREIGN KEY (idInscripcion) REFERENCES inscripciones(idInscripcion) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Inserciones de clases de Educación Infantil
INSERT INTO clases (clase) VALUES
('1º EI A'),
('1º EI B'),
('2º EI A'),
('2º EI B'),
('3º EI A'),
('3º EI B');

-- Inserciones de clases de Educación Primaria
INSERT INTO clases (clase) VALUES
('1º EP A'),
('1º EP B'),
('2º EP A'),
('2º EP B'),
('3º EP A'),
('3º EP B'),
('4º EP A'),
('4º EP B'),
('5º EP A'),
('5º EP B'),
('6º EP A'),
('6º EP B');


-- Inscripciones completadas
INSERT INTO inscripciones (nombrePadre, apellidosPadre, DNI, IBAN, titularCuenta, fechaMandato, telefono, correo, completada) VALUES
('Juan', 'Pérez Gómez', '11111111A', 'ES7620770024003102575766', 'Juan Pérez Gómez', '2025-06-01', '+34600111221', 'juan.perez@example.com', 1),
('Laura', 'Martínez Ruiz', '22222222B', 'ES1200491500052712345678', 'Laura Martínez Ruiz', '2025-06-02', '+34600111222', 'laura.martinez@example.com', 1),
('Carlos', 'López Morales', '33333333C', 'ES3200190020945312345678', 'Carlos López Morales', '2025-06-03', '+34600111223', 'carlos.lopez@example.com', 1),
('Marta', 'Sánchez Vega', '44444444D', 'ES2100750066890123456789', 'Marta Sánchez Vega', '2025-06-04', '+34600111224', 'marta.sanchez@example.com', 1),
('Luis', 'García Torres', '55555555E', 'ES4800491500052812345678', 'Luis García Torres', '2025-06-05', '+34600111225', 'luis.garcia@example.com', 1),
('Elena', 'Ramírez Díaz', '66666666F', 'ES1400750066890223456789', 'Elena Ramírez Díaz', '2025-06-06', '+34600111226', 'elena.ramirez@example.com', 1),
('Pedro', 'Hernández León', '77777777G', 'ES8600750066890323456789', 'Pedro Hernández León', '2025-06-07', '+34600111227', 'pedro.hernandez@example.com', 1),
('Ana', 'Castro Lozano', '88888888H', 'ES7300491500052912345678', 'Ana Castro Lozano', '2025-06-08', '+34600111228', 'ana.castro@example.com', 1),
('Javier', 'Suárez Ortega', '99999999I', 'ES6100491500053012345678', 'Javier Suárez Ortega', '2025-06-09', '+34600111229', 'javier.suarez@example.com', 1),
('Lucía', 'Gómez Romero', '10101010J', 'ES4400750066890423456789', 'Lucía Gómez Romero', '2025-06-10', '+34600111230', 'lucia.gomez@example.com', 1),
('Raúl', 'Jiménez Martín', '12121212K', 'ES5500750066890523456789', 'Raúl Jiménez Martín', '2025-06-11', '+34600111231', 'raul.jimenez@example.com', 1),
('Beatriz', 'Cano Muñoz', '13131313L', 'ES8600491500053112345678', 'Beatriz Cano Muñoz', '2025-06-12', '+34600111232', 'beatriz.cano@example.com', 1),
('Fernando', 'Nieto Alba', '14141414M', 'ES2200750066890623456789', 'Fernando Nieto Alba', '2025-06-13', '+34600111233', 'fernando.nieto@example.com', 1),
('Carmen', 'Delgado Gil', '15151515N', 'ES9500491500053212345678', 'Carmen Delgado Gil', '2025-06-14', '+34600111234', 'carmen.delgado@example.com', 1),
('Andrés', 'Rey Blanco', '16161616O', 'ES0700750066890723456789', 'Andrés Rey Blanco', '2025-06-15', '+34600111235', 'andres.rey@example.com', 1),
('Silvia', 'Ramos Serrano', '17171717P', 'ES3600491500053312345678', 'Silvia Ramos Serrano', '2025-06-16', '+34600111236', 'silvia.ramos@example.com', 1),
('Alberto', 'Luna Herrera', '18181818Q', 'ES1700750066890823456789', 'Alberto Luna Herrera', '2025-06-17', '+34600111237', 'alberto.luna@example.com', 1),
('Nuria', 'Ibáñez Cano', '19191919R', 'ES8200491500053412345678', 'Nuria Ibáñez Cano', '2025-06-18', '+34600111238', 'nuria.ibanez@example.com', 1),
('Víctor', 'Ruiz Bravo', '20202020S', 'ES0600750066890923456789', 'Víctor Ruiz Bravo', '2025-06-19', '+34600111239', 'victor.ruiz@example.com', 1),
('Sonia', 'Peña Lozano', '21212121T', 'ES4900491500053512345678', 'Sonia Peña Lozano', '2025-06-20', '+34600111240', 'sonia.pena@example.com', 1);

-- Alumnos correspondientes (asume ID inscripción correlativo del 1 al 20 y clases válidas del 1 al 12)
INSERT INTO alumno (nombreAlumno, apellidosAlumno, idClase, idInscripcion) VALUES
('Carlos', 'Pérez Fernández', 1, 1),
('Lucía', 'Martínez López', 2, 2),
('Hugo', 'López Ríos', 3, 3),
('Clara', 'Sánchez Molina', 4, 4),
('Diego', 'García Vargas', 5, 5),
('Inés', 'Ramírez Soto', 6, 6),
('Jorge', 'Hernández Cid', 7, 7),
('Eva', 'Castro Ramos', 8, 8),
('Samuel', 'Suárez Linares', 9, 9),
('Lola', 'Gómez Salas', 10, 10),
('David', 'Jiménez Rico', 11, 11),
('Paula', 'Cano Valle', 12, 12),
('Daniel', 'Nieto Prieto', 1, 13),
('María', 'Delgado Sánchez', 2, 14),
('Rubén', 'Rey Bravo', 3, 15),
('Isabel', 'Ramos Muñoz', 4, 16),
('Tomás', 'Luna Herrera', 5, 17),
('Nerea', 'Ibáñez Morales', 6, 18),
('Álvaro', 'Ruiz Marín', 7, 19),
('Sofía', 'Peña López', 8, 20);



---------------------VACIAR LAS TABLAS INSCRIPCIONES Y ALUMNOS-------------

-- Primero desactivamos temporalmente la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminamos los registros de ambas tablas
DELETE FROM alumno;
DELETE FROM inscripciones;

-- Volvemos a activar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE inscripciones (
    idInscripcion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombrePadre VARCHAR(50) NOT NULL,
    apellidosPadre VARCHAR(100) NULL,
    DNI CHAR(20) NULL,
    IBAN CHAR(34) NULL,
    titularCuenta VARCHAR(100) NULL,
    fechaMandato DATE NULL,
    telefono CHAR(24) NULL,
    correo VARCHAR(100) NULL,
    completada BIT NOT NULL,
    CONSTRAINT pk_idInscripcion PRIMARY KEY (idInscripcion)
);

CREATE TABLE alumno(
    idAlumno smallint unsigned null auto_increment,
    nombreAlumno varchar(50) null,
    apellidosAlumno varchar(100) null,
    idClase tinyint unsigned null,
    idInscripcion smallint unsigned null,
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
