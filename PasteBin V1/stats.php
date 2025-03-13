<?php
require __DIR__ . '/config.php'; // Conectar ao banco de dados

// Obter número total de notas criadas
$stmt = $pdo->query("SELECT COUNT(*) as total_notes FROM notes");
$total_notes = $stmt->fetch(PDO::FETCH_ASSOC)['total_notes'];

// Obter total de visualizações de todas as notas
$stmt = $pdo->query("SELECT SUM(views) as total_views FROM notes");
$total_views = $stmt->fetch(PDO::FETCH_ASSOC)['total_views'] ?? 0;

// Obter as 5 notas mais visualizadas
$stmt = $pdo->query("SELECT title, link, views FROM notes ORDER BY views DESC LIMIT 5");
$top_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - Pastebin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-dark text-gray-200">
    <div class="container mx-auto p-4">
        <header class="text-2xl mb-5">📊 Estatísticas do Pastebin</header>
        
        <p><strong>Total de Notas Criadas:</strong> <?php echo $total_notes; ?></p>
        <p><strong>Total de Visualizações:</strong> <?php echo $total_views; ?></p>

        <h2 class="mt-4 text-xl">Top 5 Notas Mais Visualizadas</h2>
        <ul class="list-disc pl-5">
            <?php foreach ($top_notes as $note): ?>
                <li>
                    <a href="/past/<?php echo htmlspecialchars($note['link']); ?>" class="text-blue-400">
                        <?php echo htmlspecialchars($note['title']); ?>
                    </a> (<?php echo $note['views']; ?> visualizações)
                </li>
            <?php endforeach; ?>
        </ul>

        <footer class="mt-10 text-center text-sm text-gray-400">
            Feito com ❤️ por <a href="https://humberto.mundotutors.com" class="text-blue-400">Humberto</a>
        </footer>
    </div>
</body>
</html>
