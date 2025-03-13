<?php
require __DIR__ . '/../config.php'; // Conexão com o banco de dados

// Captura o parâmetro 'url' da query string
if (isset($_GET['url']) && !empty($_GET['url'])) {
    $link = $_GET['url'];
} else {
    http_response_code(404);
    die("<h2>Erro 404: Nenhuma nota encontrada.</h2>");
}

// Busca a nota no banco de dados
$stmt = $pdo->prepare("SELECT * FROM notes WHERE link = :link");
$stmt->bindValue(':link', $link, PDO::PARAM_STR);
$stmt->execute();
$note = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$note) {
    http_response_code(404);
    die("<h2>Erro 404: Nota não encontrada.</h2>");
}

// Atualiza visualizações
$stmt = $pdo->prepare("UPDATE notes SET views = views + 1 WHERE link = :link");
$stmt->bindValue(':link', $link, PDO::PARAM_STR);
$stmt->execute();

$is_code = in_array($note['language'], ["php", "javascript", "python", "html", "css", "java", "c", "cpp", "sql", "ruby", "bash"]);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Nota - <?php echo htmlspecialchars($note['title']); ?></title>
    <link rel="stylesheet" href="/past/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
</head>
<body class="bg-dark text-gray-200">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center border-b border-gray-600 pb-4">
            <h1 class="text-2xl">Visualizar Nota</h1>
            <span class="text-sm">Visualizações: <?php echo $note['views']; ?></span>
        </header>

        <section class="mt-5">
            <h2 class="text-xl mb-3">Título: <?php echo htmlspecialchars($note['title']); ?></h2>
            
            <?php if ($is_code): ?>
                <pre><code class="language-<?php echo htmlspecialchars($note['language']); ?>"><?php echo htmlspecialchars($note['content']); ?></code></pre>
            <?php else: ?>
                <p class="whitespace-pre-line"><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
            <?php endif; ?>
        </section>

        <footer class="mt-10 text-center text-sm text-gray-400">
            Feito com ❤️ por <a href="https://humberto.mundotutors.com" class="text-blue-400">Humberto</a>
        </footer>
    </div>
</body>
</html>
