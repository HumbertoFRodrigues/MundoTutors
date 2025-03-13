<?php

// Configurações do banco de dados
$host = 'localhost'; // Altere se necessário
$dbname = 'pastbin'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados

try {
    // Criando conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Definindo o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se houver erro na conexão, exibe a mensagem e interrompe a execução
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
