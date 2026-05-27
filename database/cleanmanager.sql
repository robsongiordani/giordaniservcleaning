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