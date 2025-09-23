CREATE DATABASE trem_facil;

USE trem_facil;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(120) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(11) UNIQUE NOT NULL,
    CEP VARCHAR(8) UNIQUE NOT NULL,
    CPF VARCHAR(11) UNIQUE NOT NULL,
    senha VARCHAR(255) UNIQUE NOT NULL,
    tipo_usuarios INT NOT NULL CHECK (tipo_usuarios IN (1, 2)), 
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sensores (
    id_sensores INT AUTO_INCREMENT PRIMARY KEY,
    nome_sensor VARCHAR(120) UNIQUE NOT NULL,
    data_sensor TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rotas (
    id_rotas INT AUTO_INCREMENT PRIMARY KEY,
    nome_rotas VARCHAR(120) UNIQUE NOT NULL,
    data_rotas TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FKid_sensores INT NOT NULL, 
    FOREIGN KEY (FKid_sensores) REFERENCES sensores(id_sensores)
);

CREATE TABLE trens (
    id_trens INT AUTO_INCREMENT PRIMARY KEY,
    nome_tren VARCHAR(120) UNIQUE NOT NULL,
    horario TIME UNIQUE NOT NULL,
    parada_tren VARCHAR(120) UNIQUE NOT NULL
);

CREATE TABLE estacoes (
    id_estacoes INT AUTO_INCREMENT PRIMARY KEY,
    nome_estacao VARCHAR(120) UNIQUE NOT NULL,
    FKid_trens INT NOT NULL, 
    FOREIGN KEY (FKid_trens) REFERENCES trens(id_trens)
);
