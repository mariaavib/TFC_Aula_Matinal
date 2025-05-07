CREATE DATABASE IF NOT EXISTS aula_matinal;
USE aula_matinal;

CREATE TABLE dias_no_lectivos(
    idDia smallint unsigned not null auto_increment,
    fecha date not null,
    motivo varchar(100) not null,
    CONSTRAINT pk_dias_no_lectivos PRIMARY KEY(idDia)
);
