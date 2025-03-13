<?php
require __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? 'Sem título';
    $language = $_POST['language'] ?? 'text';
    $content = $_POST['content'] ?? '';

    if (!empty($content)) {
        // Gerar um paste_id único (10 caracteres)
        $paste_id = substr(md5(uniqid(mt_rand(), true)), 0, 10);

        // Inserir os dados na tabela 'notes'
        $sql = "INSERT INTO notes (link, title, language, content, views, created_at) VALUES (?, ?, ?, ?, 0, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$paste_id, $title, $language, $content]);

        // Redirecionar para a URL amigável
        header("Location: /past/" . $paste_id);
        exit();
    }
}

// Se algo der errado, redirecione para a página inicial
header("Location: views/index.php");
exit();
?>
