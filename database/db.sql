CREATE DATABASE IF NOT EXISTS oficina CHARACTER SET utf8mb4;
USE oficina;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE mecanicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) NOT NULL UNIQUE,
    especialidade VARCHAR(100) NOT NULL
);

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    mecanico_id INT NOT NULL,
    placa VARCHAR(8) NOT NULL,
    data_hora DATETIME NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (mecanico_id) REFERENCES mecanicos(id),
    UNIQUE (mecanico_id, data_hora)
);

INSERT INTO usuarios (nome, usuario, senha) VALUES
('Administrador', 'admin', '$2y$10$m/O62YCWGUTEaaCuFyWjx.x9nmaHxa5elWCqKAEtFt.oQ6vUZGtt.');

INSERT INTO clientes (nome, telefone, email) VALUES
('João Silva', '(47) 99999-1111', 'joao@email.com'),
('Maria Souza', '(47) 99999-2222', 'maria@email.com'),
('Carlos Pereira', '(47) 99999-3333', 'carlos@email.com');

INSERT INTO mecanicos (nome, matricula, especialidade) VALUES
('Pedro Lima', 'M001', 'Motor'),
('Ana Costa', 'M002', 'Freios'),
('Lucas Rocha', 'M003', 'Elétrica');

INSERT INTO agendamentos (cliente_id, mecanico_id, placa, data_hora) VALUES
(1, 1, 'ABC-1234', '2026-12-01 09:00:00'),
(2, 2, 'DEF-5678', '2026-12-01 10:30:00'),
(3, 3, 'GHI-9012', '2026-12-02 14:00:00');
