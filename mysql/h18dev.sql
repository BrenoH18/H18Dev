CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(45) NOT NULL,
        sobrenome VARCHAR(45) NOT NULL,
        email VARCHAR(45) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        empresa VARCHAR(45) NOT NULL,
        permissao VARCHAR(45) NOT NULL DEFAULT 'user'
    )