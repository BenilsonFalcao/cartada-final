-- db/schema.sql
CREATE TABLE IF NOT EXISTS paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    imc DECIMAL(4, 2) NOT NULL,
    pressao_sistolica INT NOT NULL
);
