CREATE DATABASE trem_facil;

USE trem_facil;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(120) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(11) UNIQUE NOT NULL,
    cep VARCHAR(8) UNIQUE NOT NULL,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo_usuario INT NOT NULL CHECK (tipo_usuario IN (1, 2)),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sensor (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) UNIQUE NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rota (
    id_rota INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) UNIQUE NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_sensor INT NOT NULL,
    FOREIGN KEY (id_sensor) REFERENCES sensor(id_sensor)
);

CREATE TABLE trem (
    id_trem INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) UNIQUE NOT NULL,
    horario TIME UNIQUE NOT NULL,
    parada VARCHAR(120) UNIQUE NOT NULL
);

CREATE TABLE estacao (
    id_estacao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) UNIQUE NOT NULL,
    id_trem INT NOT NULL,
    FOREIGN KEY (id_trem) REFERENCES trem(id_trem)
);

USE trem_facil;

ALTER TABLE sensor ADD COLUMN status VARCHAR(20) DEFAULT 'ATIVO';
ALTER TABLE sensor ADD COLUMN localizacao VARCHAR(120) DEFAULT 'DESCONHECIDA';
ALTER TABLE sensor ADD COLUMN ultima_atualizacao_texto VARCHAR(50) DEFAULT 'AGORA';
ALTER TABLE sensor ADD COLUMN ultima_atualizacao_valor VARCHAR(20) DEFAULT '0';
ALTER TABLE sensor ADD COLUMN ultima_atualizacao_unidade VARCHAR(10) DEFAULT 'KM/H';

CREATE TABLE linha (
    id_linha INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) UNIQUE NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE estacao_linha (
    id_estacao_linha INT AUTO_INCREMENT PRIMARY KEY,
    id_estacao INT NOT NULL,
    id_linha INT NOT NULL,
    FOREIGN KEY (id_estacao) REFERENCES estacao(id_estacao),
    FOREIGN KEY (id_linha) REFERENCES linha(id_linha),
    UNIQUE(id_estacao, id_linha)
);
