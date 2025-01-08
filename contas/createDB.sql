CREATE DATABASE IF NOT EXISTS contas_a_pagar;

use contas_a_pagar;

CREATE TABLE IF NOT EXISTS tbl_empresa(
id_empresa INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(64) NOT NULL
);

CREATE TABLE IF NOT EXISTS tbl_conta_pagar (
id_conta_pagar INT AUTO_INCREMENT PRIMARY KEY,
valor DECIMAL(10,2) NOT NULL,
data_pagar DATE NOT NULL,
pago TINYINT DEFAULT 0,
id_empresa INT NOT NULL,
FOREIGN KEY (id_empresa) REFERENCES tbl_empresa(id_empresa)
);

# Populando o banco para o projeto iniciar com empresas e algumas contas

INSERT INTO tbl_empresa (nome) VALUES 
('Empresa A'), ('Empresa B'),
('Empresa C'), ('Empresa D'),
('Empresa E');

INSERT INTO tbl_conta_pagar (valor, data_pagar, pago, id_empresa)
VALUES 
(500.00, '2024-07-01', 0, 1), (750.00, '2024-07-05', 0, 2),
(1000.00, '2024-07-10', 0, 3), (300.00, '2024-07-15', 0, 4), 
(1200.00, '2024-07-20', 0, 5), (500.75, '2024-06-29', 0, 3);
