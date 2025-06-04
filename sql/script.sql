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
    correo VARCHAR(100) NULL,
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


-- INSERTS UTILIZADOS

INSERT INTO clases (clase) VALUES
('1º EI A'),
('1º EI B'),
('2º EI A'),
('2º EI B'),
('3º EI A'),
('3º EI B'),
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

INSERT INTO inscripciones (nombrePadre, apellidosPadre, DNI, IBAN, titularCuenta, fechaMandato, telefono, correo, completada) VALUES
('Adrián', 'Reyes Torres', '121131412', 'ES21007050010001234567808', 'Adrián Reyes Torres', '2024-05-16', '+34611222349', 'adrian.reyes@example.com', 1),
('Alberto', 'Marín Fuentes', '151678390', 'ES9110010418542000510031', 'Alberto Marín Fuentes', '2024-05-15', '+34611222351', 'alberto.marin@example.com', 1),
('Andrés', 'Delgado Ferrer', '22222222F', 'ES3000491500211234567814', 'Andrés Delgado Ferrer', '2024-05-12', '+34611222359', 'andres.delgado@example.com', 1),
('Beatriz', 'Garrido Castro', '23242542W', 'ES3000491500211234567801', 'Beatriz Garrido Castro', '2024-05-10', '+34611222357', 'beatriz.garrido@example.com', 1),
('Clara', 'Martín Salazar', '21223223I', 'ES21007150010001234567803', 'Clara Martín Salazar', '2024-05-11', '+34611222358', 'clara.martin@example.com', 1),
('Cristina', 'Navarro León', '21223444L', 'ES21007150010001234567806', 'Cristina Navarro', '2024-05-14', '+34611222354', 'cristina.navarro@example.com', 1),
('Cano', 'López', '444555667T', 'ES9110010418542000510047', 'David Cano López', '2024-05-13', '+34611222353', 'david.cano@example.com', 1),
('Diego', 'Santos Delgado', '333444556X', 'ES3000491500211234567802', 'Diego Santos Delgado', '2024-05-13', '+34611222352', 'diego.santos@example.com', 1),
('Elena', 'Torres Ramos', '33445566C', 'ES21007050010001234567802', 'Elena Torres Ramos', '2024-05-02', '+34611222340', 'elena.torres@example.com', 1),
('Eva', 'Correa Padilla', '29303132C', 'ES21007050010001234567819', 'Eva Correa Padilla', '2024-05-06', '+34611222366', 'eva.correa@example.com', 1),
('Hugo', 'Nieto Bravo', '220112223T', 'ES300015000112345678013', 'Hugo Nieto Bravo', '2024-05-24', '+34611222357', 'hugo.nieto@example.com', 1),
('Isabel', 'Guerrero Navas', '19202122S', 'ES3000491500211234567810', 'Isabel Guerrero Navas', '2024-05-23', '+34611222355', 'isabel.guerrero@example.com', 1),
('Iván', 'Gallardo Carrillo', '26272829Z', 'ES21007050010001234567804', 'Iván Gallardo Carrillo', '2024-05-10', '+34611222363', 'ivan.gallardo@example.com', 1),
('Javier', 'Moreno Sánchez', '22334455P', 'ES21007150010001234567805', 'Javier Moreno Sánchez', '2024-05-06', '+34611222361', 'javier.moreno@example.com', 1),
('Juan', 'Pérez García', '80107928D', 'ES 2222222222222222222222', 'Juan Pérez García', '2024-05-24', '+34666777777', 'juan.perez@example.com', 1),
('Francisco', 'Moreno Díaz', '80107928J', 'ES3000491500211234567811', 'Francisco Moreno Díaz', '2024-05-14', '+34666777777', 'francisco.moreno@example.com', 1),
('Laura', 'Fernández Gómez', '11223344C', 'ES9110010418542000510434', 'Laura Fernández Gómez', '2024-05-23', '+34611222338', 'laura.fernandez@example.com', 1),
('Lucía', 'Cruz Muñoz', '15161179M', 'ES9110010418542000511030', 'Lucía Cruz Muñoz', '2024-05-17', '+34611222330', 'lucia.cruz@example.com', 1),
('Luis', 'Jiménez Gil', '66778900C', 'ES2100705001000123457804', 'Luis Jiménez Gil', '2024-05-15', '+34611222350', 'luis.jimenez@example.com', 1),
('Marta', 'Ortega Ruiz', '55667788E', 'ES3000491500211234567804', 'Marta Ortega Ruiz', '2024-05-07', '+34611222331', 'marta.ortega@example.com', 1),
('Natalia', 'Díaz Romero', '11121314K', 'ES2100705001000123457809', 'Natalia Díaz Romero', '2024-05-20', '+34611222360', 'natalia.diaz@example.com', 1),
('Oscar', 'Sáez Montoya', '24252627X', 'ES2100715001000123457806', 'Oscar Sáez Montoya', '2024-05-19', '+34611222361', 'oscar.saez@example.com', 1),
('Pablo', 'Rojas Cano', '14151617X', 'ES2100705001000123457803', 'Pablo Rojas Cano', '2024-05-17', '+34611222341', 'pablo.rojas@example.com', 1),
('Patricia', 'Romero Vargas', '77889900G', 'ES2100715001000123457802', 'Patricia Romero Vargas', '2024-05-08', '+34611222344', 'patricia.romero@example.com', 1),
('Paula', 'Campos Herrera', '88990011X', 'ES2100705001000123457801', 'Paula Campos Herrera', '2024-05-06', '+34611222354', 'paula.campos@example.com', 1),
('Raúl', 'Iglesias Peña', '88990011T', 'ES3000491500211234567807', 'Raúl Iglesias Peña', '2024-05-29', '+34611222345', 'raul.iglesias@example.com', 1),
('Rocío', 'Arias Benítez', '25262728C', 'ES2100705001000123457812', 'Rocío Arias Benítez', '2024-05-10', '+34611222346', 'rocio.arias@example.com', 1),
('Rubén', 'Mora Sevilla', '56390102C', 'ES21007050010001234567810', 'Rubén Mora Sevilla', '2024-05-13', '+34611222347', 'ruben.mora@example.com', 1),
('Sergio', 'Vega Molina', '15161730B', 'ES21007050010001234567811', 'Sergio Vega Molina', '2024-05-09', '+34611222348', 'sergio.vega@example.com', 1),
('Silvia', 'Serrano Díaz', '15161730R', 'ES21007050010001234567814', 'Silvia Serrano Díaz', '2024-05-07', '+34611222352', 'silvia.serrano@example.com', 1),
('Diego', 'Santos Delgado', '18192021R', 'ES2100750001001234567812', 'Diego Santos Delgado', '2024-05-22', '+34611222355', 'diego.santos@example.com', 1);

INSERT INTO alumno (nombreAlumno, apellidosAlumno, idClase, idInscripcion) VALUES
('Lucía', 'Reyes Martínez', 1, 1),
('Daniel', 'Martín López', 2, 2),
('Sofía', 'Delgado Ruiz', 3, 3),
('Hugo', 'Garrido Torres', 4, 4),
('Valeria', 'Castro Romero', 5, 5),
('Mateo', 'Salazar Díaz', 6, 6),
('Martina', 'Navarro Pérez', 7, 7),
('Leo', 'López Sánchez', 8, 8),
('Paula', 'Delgado Cano', 9, 9),
('Álvaro', 'Torres Bravo', 10, 10),
('Emma', 'Padilla Vega', 11, 11),
('Javier', 'Nieto Fernández', 12, 12),
('Carla', 'Guerrero Ramos', 13, 13),
('Diego', 'Gallardo Molina', 14, 14),
('Noa', 'Moreno Hernández', 15, 15),
('David', 'Moreno Díaz', 16, 16),
('Sara', 'Fernández Gil', 17, 17),
('Marcos', 'Cruz Marín', 18, 18),
('Aitana', 'Jiménez Gil', 1, 19),
('Eric', 'Ortega Lozano', 2, 20),
('Natalia', 'Díaz Correa', 3, 21),
('Mario', 'Sáez Montoya', 4, 22),
('Julia', 'Cano Rojas', 5, 23),
('Alejandro', 'Romero Vargas', 6, 24),
('Adriana', 'Campos Herrera', 7, 25),
('Pablo', 'Apellido Torres', 8, 26),
('Chloe', 'Iglesias Peña', 9, 27),
('Iván', 'Arias Benítez', 10, 28),
('Lola', 'Mora Sevilla', 11, 29),
('Nicolás', 'Vega Molina', 12, 30);


