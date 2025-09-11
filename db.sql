/*Trem fácil*/

CREATE DATABASE trem_facil

USE trem_facil 

CREATE TABLE usuarios (

id_usuario  INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(120) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone varchar(11) UNIQUE NOT NULL,
    CEP varchar (8) UNIQUE NOT NUll,
    CPF Varchar (11) UNIQUE NOT null ,
    senha VARCHAR(255) UNIQUE NOT NULL,
    tipo_usuarios VARCHAR(20) NOT NULL CHECK (tipo_usuarios IN ('1', '2')),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE  sensores    (
id_sensores INT AUTO_INCREMENT PRIMARY KEY,
nome_sensor VARCHAR(120) UNIQUE NOT NULL,
data_sensor TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FKid_trens  INT,
FOREIGN KEY (FKid_trens) REFERENCES trens (id_trens)
);




CREATE TABLE trens (
id_trens INT AUTO_INCREMENT PRIMARY KEY,





)









CREATE TABLE rotas (
id_rotas


)