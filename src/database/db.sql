CREATE DATABASE fluent_ia_db

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(80)NOT NULL,
    senha VARCHAR(50) NOT NUL,
    bot BOOLEAN DEFAULT FALSE, -- TRUE se for uma IA
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE conversas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- quem iniciou a conversa
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE mensagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conversas_id INT NOT NULL,
    remetente_id INT NOT NULL, -- quem enviou (usuário ou IA)
    message TEXT NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversas_id) REFERENCES conversas(id) ON DELETE CASCADE,
    FOREIGN KEY (remetente_id) REFERENCES users(id) ON DELETE CASCADE
);
