CREATE DATABASE cleanmanager;

USE cleanmanager;

CREATE TABLE usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100),
 email VARCHAR(120),
 senha VARCHAR(255),
 tipo ENUM('admin','colaborador')
);

CREATE TABLE clientes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100),
 telefone VARCHAR(30),
 endereco TEXT
);

CREATE TABLE servicos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 cliente_id INT,
 colaborador_id INT,
 tipo_servico VARCHAR(100),
 valor DECIMAL(10,2),
 data_servico DATE,
 status VARCHAR(50)
);
INSERT INTO usuarios
(nome,email,senha,tipo)

VALUES
(
'Robson',
'admin@giordani.com',
'$2y$10$Q9WwQkD7M8QK8h7M9fN9wOK8zP5TzJ1Q6Qw7m2hX2z9tL8N4sYxQW',
'admin'
);
CREATE TABLE tipos_servicos (

 id INT AUTO_INCREMENT PRIMARY KEY,

 nome VARCHAR(100),

 valor_padrao DECIMAL(10,2)

);
INSERT INTO tipos_servicos
(nome, valor_padrao)

VALUES

('Faxina',320),
('Meia-faxina',180),
('Pós-obra',300),
('Pós-reforma',350),
('Airbnb',180),
('Manutenção',120),
('Lavanderia',80);