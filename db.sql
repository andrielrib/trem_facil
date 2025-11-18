CREATE DATABASE trem_facil;

USE trem_facil;

-- Tabela cargo para registrar os tipos de usuário
CREATE TABLE IF NOT EXISTS cargo (
    id_cargo INT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);


-- Inserindo os tipos básicos de cargo
INSERT IGNORE INTO cargo (id_cargo, nome) VALUES
(2, 'ADMINISTRADOR'),
(1, 'USUÁRIO');


-- Alterar tabela usuario: adicionar nome_usuario, ajustar tipo_usuario para FK e garantir integridade
ALTER TABLE usuario 
    ADD COLUMN nome_usuario VARCHAR(50) UNIQUE NOT NULL AFTER senha;

-- Dependendo do SGBD, para transformar tipo_usuario em FK, primeiro deve remover a restrição CHECK:
-- No MySQL 8: precisa identificar nome da constraint e remover, por exemplo:
-- ALTER TABLE usuario DROP CHECK <nome_da_constraint>;
-- Aqui assumimos que a constraint CHECK será removida (ou ignore se não existir)

-- Alterar tipo_usuario para ser FK para cargo.id_cargo
ALTER TABLE usuario
    MODIFY tipo_usuario INT NOT NULL;

ALTER TABLE usuario
    ADD CONSTRAINT fk_usuario_tipo_usuario FOREIGN KEY (tipo_usuario) REFERENCES cargo(id_cargo);

-- Agora as demais tabelas (sensor, rota, trem, estacao, linha, estacao_linha, parada, estacao_horario e horario)
-- manteremos conforme você já tem, adaptando pequenas melhorias caso queira:

ALTER TABLE sensor 
    ADD COLUMN IF NOT EXISTS status VARCHAR(20) DEFAULT 'ATIVO',
    ADD COLUMN IF NOT EXISTS localizacao VARCHAR(120) DEFAULT 'DESCONHECIDA',
    ADD COLUMN IF NOT EXISTS ultima_atualizacao_texto VARCHAR(50) DEFAULT 'AGORA',
    ADD COLUMN IF NOT EXISTS ultima_atualizacao_valor VARCHAR(20) DEFAULT '0',
    ADD COLUMN IF NOT EXISTS ultima_atualizacao_unidade VARCHAR(10) DEFAULT 'KM/H';

CREATE TABLE IF NOT EXISTS linha (
    id_linha INT AUTO_INCREMENT PRIMARY KEY,
    id_exibicao INT UNIQUE NOT NULL,
    nome VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    status_color VARCHAR(10) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS parada (
    id_parada INT AUTO_INCREMENT PRIMARY KEY,
    id_linha INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    tempo VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_linha) REFERENCES linha(id_linha) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS estacao_horario (
    id_estacao_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_linha INT NOT NULL,
    nome_estacao VARCHAR(255) NOT NULL,
    UNIQUE KEY (id_linha, nome_estacao),
    FOREIGN KEY (id_linha) REFERENCES linha(id_linha) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS horario (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_estacao_horario INT NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (id_estacao_horario) REFERENCES estacao_horario(id_estacao_horario) ON DELETE CASCADE
);

-- Inserções originais de exemplo para linhas, paradas, estações e horários
-- (Sem alterações, mantém conforme seu script original)

-- Atualização dados na tabela 'usuario' para exemplo, incluindo nome_usuario e cargo
INSERT INTO usuario (nome_completo, email, telefone, cep, cpf, senha, nome_usuario, tipo_usuario) VALUES
('Rafael Almeida', 'rafael_almeida@gmail.com', '11987654321', '01234567', '12345678901',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rafael', 1),
('Andriel', 'andriel@gmail.com', '11987654322', '01234568', '12345678902',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'andriel', 2),
('Arthur', 'arthur@gmail.com', '11987654323', '01234569', '12345678903',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'arthur', 2),
('Caio', 'caio@gmail.com', '11987654324', '01234570', '12345678904',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'caio', 2);

INSERT INTO linha (id_exibicao, nome, status, status_color) VALUES
(101, 'Costa e Silva Centro', 'Ativo', '#00c853'),
(102, 'Pirabeiraba Centro', 'Inativo', '#d50000'),
(103, 'Tupy / Norte via Centro', 'Ativo', '#00c853'),
(104, 'Norte / Vila Nova via Walmor Harger', 'Ativo', '#00c853'),
(105, 'Circulares Rui Barbosa', 'Ativo', '#00c853');

INSERT INTO parada (id_linha, nome, tempo) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 101), 'Estação do Príncipe - Centro', 'Agora'),
((SELECT id_linha FROM linha WHERE id_exibicao = 101), 'Estação Ruy Barbosa - Costa e Silva', '15 min');

INSERT INTO parada (id_linha, nome, tempo) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 103), 'Dona Francisca via Morro Cortado', 'Agora'),
((SELECT id_linha FROM linha WHERE id_exibicao = 103), 'Arno W. Dohler / Norte', '10 min');

INSERT INTO parada (id_linha, nome, tempo) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 104), 'Vila Nova via João Miers', 'Agora'),
((SELECT id_linha FROM linha WHERE id_exibicao = 104), 'Pirabeiraba', '20 min');

INSERT INTO parada (id_linha, nome, tempo) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 105), 'Circular Parque Douat', 'Agora'),
((SELECT id_linha FROM linha WHERE id_exibicao = 105), 'Circular Rui Barbosa', '5 min');

INSERT INTO estacao_horario (id_linha, nome_estacao) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 101), 'Estação Príncipe'),
((SELECT id_linha FROM linha WHERE id_exibicao = 101), 'Estação Ruy Barbosa');

INSERT INTO estacao_horario (id_linha, nome_estacao) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 103), 'Dona Francisca'),
((SELECT id_linha FROM linha WHERE id_exibicao = 103), 'Arno W. Dohler');

INSERT INTO estacao_horario (id_linha, nome_estacao) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 104), 'Vila Nova'),
((SELECT id_linha FROM linha WHERE id_exibicao = 104), 'Pirabeiraba');

INSERT INTO estacao_horario (id_linha, nome_estacao) VALUES
((SELECT id_linha FROM linha WHERE id_exibicao = 105), 'Parque Douat'),
((SELECT id_linha FROM linha WHERE id_exibicao = 105), 'Rui Barbosa');

INSERT INTO horario (id_estacao_horario, hora) VALUES
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '05:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '06:15:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '07:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '07:45:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '08:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '11:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '13:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '15:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '17:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Príncipe' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '19:30:00');

INSERT INTO horario (id_estacao_horario, hora) VALUES
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '06:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '06:45:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '07:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '08:15:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '09:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '11:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '13:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '16:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '18:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Estação Ruy Barbosa' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 101)), '20:00:00');

INSERT INTO horario (id_estacao_horario, hora) VALUES
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '06:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '07:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '09:00:00');