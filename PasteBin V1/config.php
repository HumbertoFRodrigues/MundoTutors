<?php
// Habilitar exibição de erros (apenas para desenvolvimento, remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurações do Banco de Dados
define('DB_HOST', 'localhost'); // Servidor do banco de dados (geralmente localhost no cPanel)
define('DB_NAME', 'pastbin'); // Nome do banco de dados
define('DB_USER', 'root'); // Usuário do banco de dados
define('DB_PASS', ''); // Senha do banco de dados

// Configuração do site
define('SITE_URL', 'https://localhost/past'); // URL base do site
define('SITE_NAME', 'PasteSite.Net'); // Nome do site
define('DEFAULT_LANGUAGE', 'en'); // Idioma padrão

// Definição de tempo limite para pastas
define('PASTE_EXPIRATION_DAYS', 30); // Tempo padrão antes de expirar (exemplo: 30 dias)

// Configuração para permitir personalização de links
define('ALLOW_CUSTOM_LINKS', true);

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
