CREATE TABLE IF NOT EXISTS socio (
    idsocio INT AUTO_INCREMENT PRIMARY KEY,
    cpf CHAR(11) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipoPlano ENUM('basico', 'premium', 'executive') DEFAULT 'basico'
);
/*
CREATE DATABASE IF NOT EXISTS time_bt;
USE time_bt;

CREATE TABLE IF NOT EXISTS socio (
    idsocio INT AUTO_INCREMENT PRIMARY KEY,
    cpf CHAR(11) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipoPlano ENUM('basico', 'premium', 'executive') DEFAULT 'basico'
);
*/ 