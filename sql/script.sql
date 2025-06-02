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

---------------------------INSERCIONES DE PRUEBA EN LA TABLA INSCRIPCIONES------------

-- Inserciones completas
INSERT INTO inscripciones (idInscripcion, nombrePadre, DNI, IBAN, titularCuenta, fechaMandato, telefono, email, completada) 
VALUES 
(1, 'Juan Pérez García', '12345678A', 'ES1234567890123456789012', 'Juan Pérez García', '2024-03-15', '666111222', 'juan.perez@email.com', 1),
(2, 'María López Sánchez', '87654321B', 'ES9876543210987654321098', 'María López Sánchez', '2024-03-15', '666333444', 'maria.lopez@email.com', 1),
(3, 'Carlos Ruiz Martín', '11223344C', 'ES5544332211009988776655', 'Carlos Ruiz Martín', '2024-03-15', '666555666', 'carlos.ruiz@email.com', 1),
(4, 'Antonio Martín Vega', '22334455D', 'ES6677889900112233445566', 'Antonio Martín Vega', '2024-03-16', '666123456', 'antonio.martin@email.com', 1),
(5, 'Laura Sánchez Ruiz', '33445566E', 'ES7788990011223344556677', 'Laura Sánchez Ruiz', '2024-03-16', '666234567', 'laura.sanchez@email.com', 1);

INSERT INTO alumno (idAlumno, nombreAlumno, idClase, idInscripcion)
VALUES 
(1, 'Ana Pérez López', 1, 1),
(2, 'Luis López Ruiz', 2, 2),
(3, 'Sara Ruiz García', 3, 3),
(4, 'Pablo Martín Sánchez', 1, 4),
(5, 'Elena Sánchez Torres', 2, 5);

-- Inserciones incompletas
INSERT INTO inscripciones (idInscripcion, telefono, fechaMandato, email, completada) 
VALUES 
(6, '666777888', '2024-03-17', 'padre6@email.com', 0),
(7, '666999000', '2024-03-17', 'padre7@email.com', 0),
(8, '666888777', '2024-03-17', 'padre8@email.com', 0);

INSERT INTO alumno (idAlumno, nombreAlumno, idClase, idInscripcion)
VALUES 
(6, 'Pedro Martínez Silva', 1, 6),
(7, 'Laura García Pérez', 2, 7),
(8, 'Mario Ruiz López', 3, 8);



-----MÁS INSERCIONES---
-- Inserciones completas
INSERT INTO inscripciones (idInscripcion, nombrePadre, DNI, IBAN, titularCuenta, fechaMandato, telefono, correo, completada) 
VALUES 
(12, 'Manuel García Torres', '44556677F', 'ES1122334455667788990011', 'Manuel García Torres', '2024-03-18', '666112233', 'manuel.garcia@email.com', 1),
(13, 'Ana Martínez López', '55667788G', 'ES2233445566778899001122', 'Ana Martínez López', '2024-03-18', '666223344', 'ana.martinez@email.com', 1),
(14, 'Pedro Sánchez Ruiz', '66778899H', 'ES3344556677889900112233', 'Pedro Sánchez Ruiz', '2024-03-18', '666334455', 'pedro.sanchez@email.com', 1),
(15, 'Isabel Torres Vega', '77889900I', 'ES4455667788990011223344', 'Isabel Torres Vega', '2024-03-18', '666445566', 'isabel.torres@email.com', 1),
(16, 'Roberto López Gil', '88990011J', 'ES5566778899001122334455', 'Roberto López Gil', '2024-03-18', '666556677', 'roberto.lopez@email.com', 1);

INSERT INTO alumno (idAlumno, nombreAlumno, idClase, idInscripcion)
VALUES 
(12, 'Carmen García Ruiz', 1, 12),
(13, 'David Martínez García', 2, 13),
(14, 'Paula Sánchez López', 3, 14),
(15, 'Miguel Torres Martín', 1, 15),
(16, 'Lucía López Torres', 2, 16);

-- Inserciones incompletas
INSERT INTO inscripciones (idInscripcion, telefono, fechaMandato, correo, completada) 
VALUES 
(17, '666667777', '2024-03-19', 'padre17@email.com', 0),
(18, '666778888', '2024-03-19', 'padre18@email.com', 0),
(19, '666889999', '2024-03-19', 'padre19@email.com', 0),
(20, '666990000', '2024-03-19', 'padre20@email.com', 0),
(21, '666001111', '2024-03-19', 'padre21@email.com', 0);

INSERT INTO alumno (idAlumno, nombreAlumno, idClase, idInscripcion)
VALUES 
(17, 'Andrea Ruiz Martín', 3, 17),
(18, 'Juan Torres Silva', 1, 18),
(19, 'María Gil Pérez', 2, 19),
(20, 'Carlos Vega López', 3, 20),
(21, 'Sofia Martín Ruiz', 1, 21);


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
    nombrePadre VARCHAR(100) NOT NULL,
    DNI CHAR(20) NULL,
    IBAN CHAR(34) NULL,
    titularCuenta VARCHAR(100) NULL,
    fechaMandato DATE NOT NULL,
    telefono CHAR(20) NOT NULL,
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
