SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Banco de dados: farmacia
CREATE DATABASE IF NOT EXISTS farmacia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE farmacia;

-- Estrutura das tabelas
CREATE TABLE produto (
	id INT NOT NULL AUTO_INCREMENT,	
	nome VARCHAR(100) NOT NULL,
	descricao VARCHAR(255),
	categoria VARCHAR(50) NOT NULL,
	quantidade INT NOT NULL,
	preco DECIMAL(10,2) NOT NULL,
	validade DATE,
	id_fornecedor INT,
	PRIMARY KEY (id)
);

CREATE TABLE fornecedor (
	id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(100) NOT NULL,
	telefone VARCHAR(20),
	email VARCHAR(100),
	endereco VARCHAR(150),
	PRIMARY KEY (id)
);

CREATE TABLE usuario (
	id INT NOT NULL AUTO_INCREMENT,
	usuario VARCHAR(50) NOT NULL,
	senha VARCHAR(32) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE movimentacao (
	id INT NOT NULL AUTO_INCREMENT,
	id_produto INT NOT NULL,
	tipo ENUM('entrada', 'saida') NOT NULL,
	quantidade INT NOT NULL,
	data DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_produto) REFERENCES produto (id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE funcionario (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(150),
    cargo VARCHAR(50) NOT NULL,
    data_admissao DATE NOT NULL,
    salario DECIMAL(10,2),
    id_usuario INT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);
