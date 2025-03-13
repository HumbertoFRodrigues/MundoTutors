CREATE DATABASE IF NOT EXISTS pastebin;
USE pastebin;

-- Tabela para armazenar os pastes
CREATE TABLE IF NOT EXISTS pastes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paste_id VARCHAR(10) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    language VARCHAR(50) NOT NULL,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela para estatísticas de acesso
CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paste_id VARCHAR(10) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NOT NULL,
    visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices para melhor desempenho nas consultas
CREATE INDEX idx_paste_id ON pastes (paste_id);
CREATE INDEX idx_stats_paste_id ON stats (paste_id);
