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

USE trem_facil;

-- Adicionar colunas à tabela sensores (não Apaguem Galera)
ALTER TABLE sensores ADD COLUMN status VARCHAR(20) DEFAULT 'ATIVO';
ALTER TABLE sensores ADD COLUMN localizacao VARCHAR(120) DEFAULT 'DESCONHECIDA';
ALTER TABLE sensores ADD COLUMN ultima_atualizacao_texto VARCHAR(50) DEFAULT 'AGORA';
ALTER TABLE sensores ADD COLUMN ultima_atualizacao_valor VARCHAR(20) DEFAULT '0';
ALTER TABLE sensores ADD COLUMN ultima_atualizacao_unidade VARCHAR(10) DEFAULT 'KM/H';

INSERT INTO sensores (nome_sensor, status, localizacao, ultima_atualizacao_texto, ultima_atualizacao_valor, ultima_atualizacao_unidade) VALUES
('SENSOR 1', 'ATIVO', 'X', '5 MIN', '120', 'KM/H'),
('SENSOR 2', 'INATIVO', 'Y', '1 H', '80', 'KM/H'),
('SENSOR 3', 'ATIVO', 'Z', '1 MIN', '150', 'KM/H');


INSERT INTO usuarios (nome_completo, email, telefone, CEP, CPF, senha, tipo_usuarios) VALUES
('Rafael Almeida', 'rafael_almeida@gmail.com', '11987654321', '01234567', '12345678901', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);  -- Hash para '24098000'


INSERT INTO usuarios (nome_completo, email, telefone, CEP, CPF, senha, tipo_usuarios) VALUES
('Andriel', 'andriel@gmail.com', '11987654322', '01234568', '12345678902', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),  -- Hash para 'senha123'
('Arthur', 'arthur@gmail.com', '11987654323', '01234569', '12345678903', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),   -- Hash para 'senha123'
('Caio', 'caio@gmail.com', '11987654324', '01234570', '12345678904', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2);     -- Hash para 'senha123'