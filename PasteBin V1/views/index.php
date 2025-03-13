<?php
// Conexão com o banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pastbin', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para buscar as últimas 3 notas
    $query = 'SELECT title, content, link FROM notes ORDER BY created_at DESC LIMIT 8';
    $stmt = $pdo->query($query);
    $ultimas_notas = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ultimas_notas[] = $row;
    }

    // Consulta para obter as estatísticas de links criados
    $query_stats = 'SELECT COUNT(*) AS total_links FROM notes';
    $stmt_stats = $pdo->query($query_stats);
    $stats = $stmt_stats->fetch(PDO::FETCH_ASSOC);

    // Criação de uma nova nota
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $link = uniqid('link_'); // Gera um link único automaticamente

        // Inserir a nova nota no banco de dados
        $stmt_insert = $pdo->prepare("INSERT INTO notes (title, content, link) VALUES (:title, :content, :link)");
        $stmt_insert->bindParam(':title', $title);
        $stmt_insert->bindParam(':content', $content);
        $stmt_insert->bindParam(':link', $link);
        $stmt_insert->execute();

        // Redirecionar para a página de visualização da nota
        header("Location: views/view_note.php?url=" . urlencode($link)); // Use urlencode para garantir que o link esteja corretamente formatado
        exit(); // Garanta que o script pare após o redirecionamento
    }

} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paster.so - Novo Pastebin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9666351884551817"
     crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto mt-10 flex flex-col md:flex-row">
        <!-- Formulário para criar um novo Paste -->
        <div class="w-full md:w-2/3 p-6 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Criar um novo Paste</h2>

            <form method="POST">
                <input type="text" name="title" required placeholder="Título" class="w-full p-3 mb-3 rounded bg-gray-700 border border-gray-600 text-white">
                <textarea name="content" required placeholder="Conteúdo" class="w-full p-3 mb-3 h-40 rounded bg-gray-700 border border-gray-600 text-white"></textarea>
                <button type="submit" name="submit" class="w-full p-3 bg-blue-600 hover:bg-blue-500 rounded">Criar Paste</button>
            </form>
        </div>

        <!-- Estatísticas e Últimos Links Criados -->
        <div class="w-full md:w-1/3 p-6 ml-0 md:ml-6 mt-6 md:mt-0 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Últimos Links Criados</h2>

            <ul class="mb-4">
                <?php foreach ($ultimas_notas as $nota) : ?>
                    <li class="mb-2">
                        <a href="view_note.php?url=<?= htmlspecialchars($nota['link']) ?>" class="text-blue-400 hover:underline">
                            <?= htmlspecialchars($nota['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="text-sm text-gray-400">
                <p>Links Criados: <?= isset($stats['total_links']) ? $stats['total_links'] : 0 ?></p>
            </div>
        </div>
    </div>
</body>
</html>
