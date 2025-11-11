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

INSERT INTO sensor (nome, status, localizacao, ultima_atualizacao_texto, ultima_atualizacao_valor, ultima_atualizacao_unidade) VALUES
('SENSOR 1', 'ATIVO', 'X', '5 MIN', '120', 'KM/H'),
('SENSOR 2', 'INATIVO', 'Y', '1 H', '80', 'KM/H'),
('SENSOR 3', 'ATIVO', 'Z', '1 MIN', '150', 'KM/H');


//NÂO APAGA A PORRA DA SENHA CARALHO


INSERT INTO usuario (nome_completo, email, telefone, cep, cpf, senha, tipo_usuario) VALUES
('Rafael Almeida', 'rafael_almeida@gmail.com', '11987654321', '01234567', '12345678901', '24098000', 1);

INSERT INTO usuario (nome_completo, email, telefone, cep, cpf, senha, tipo_usuario) VALUES
('Andriel', 'andriel@gmail.com', '11987654322', '01234568', '12345678902', 'senha123', 2),
('Arthur', 'arthur@gmail.com', '11987654323', '01234569', '12345678903', 'senha123', 2),
('Caio', 'caio@gmail.com', '11987654324', '01234570', '12345678904', 'senha123', 2);