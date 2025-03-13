<?php
// Conexão com o banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pastbin', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['url'])) {
        $link = $_GET['url'];

        // Consulta para obter a nota com base no link
        $stmt = $pdo->prepare("SELECT title, content FROM notes WHERE link = :link");
        $stmt->bindParam(':link', $link);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $nota = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $erro = "Nota não encontrada.";
        }
    } else {
        $erro = "Link inválido.";
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
    exit();
}

/**
 * Transforma URLs presentes em um texto em links clicáveis,
 * escapando o conteúdo para segurança e convertendo quebras de linha.
 */
function make_links_clickable($text) {
    // Primeiro, escapamos o conteúdo para evitar injeção de HTML
    $text = htmlspecialchars($text);
    
    // Padrão para URLs que já começam com http:// ou https://
    $pattern = '/(https?:\/\/[^\s]+)/';
    // Callback para transformar a URL em link clicável
    $text = preg_replace_callback($pattern, function ($matches) {
        $url = $matches[0];
        return '<a href="' . $url . '" target="_blank" class="text-blue-500 hover:underline">' . $url . '</a>';
    }, $text);
    
    // Padrão para URLs sem protocolo (ex.: mundotutors.com ou mundotutors.com/contato)
    $pattern_no_proto = '/(?<=^|\s)([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\/[^\s]*)?)/';
    $text = preg_replace_callback($pattern_no_proto, function ($matches) {
        $url = $matches[0];
        return '<a href="https://' . $url . '" target="_blank" class="text-blue-500 hover:underline">' . $url . '</a>';
    }, $text);
    
    // Converte quebras de linha para <br> e retorna o texto processado
    return nl2br($text);
}

/**
 * Função para verificar e destacar conteúdo de código
 */
function highlight_code($text) {
    // Detecção de código (linguagens comuns, você pode adicionar mais se necessário)
    $languages = ['php', 'html', 'css', 'javascript', 'bash', 'sql'];
    
    foreach ($languages as $lang) {
        $pattern = '/```' . $lang . '.*?```/s';  // Detecta código envolto com 3 crases
        $text = preg_replace_callback($pattern, function ($matches) use ($lang) {
            $code = htmlspecialchars($matches[0]);
            return '<pre><code class="language-' . $lang . '">' . $code . '</code></pre>';
        }, $text);
    }
    
    return $text;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Nota - <?= isset($nota['title']) ? htmlspecialchars($nota['title']) : 'Erro' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/highlight.js/lib/core.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highlight.js/lib/languages/php.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highlight.js/lib/languages/html.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highlight.js/lib/languages/css.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highlight.js/lib/languages/javascript.js"></script>
    <script>hljs.highlightAll();</script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-lg">
        <?php if (isset($erro)): ?>
            <div class="text-red-500 font-semibold text-xl"><?= htmlspecialchars($erro) ?></div>
        <?php else: ?>
            <h2 class="text-3xl font-bold text-green-400 mb-6"><?= htmlspecialchars($nota['title']) ?></h2>

            <!-- Espaço para anúncios -->
            <div class="my-4 text-center text-yellow-300">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9666351884551817"
            crossorigin="anonymous"></script>
            </div>

            <div class="mt-4 text-lg">
                <?php
                    $content = make_links_clickable($nota['content']);
                    $content = highlight_code($content); // Destaque de sintaxe
                    echo $content;
                ?>
            </div>

            <br>

            <!-- Botão de copiar página -->
            <div class="mt-6 text-center">
                <button onclick="copyPage()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">Copiar Página</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Função para copiar o conteúdo da página
        function copyPage() {
            const range = document.createRange();
            range.selectNode(document.querySelector('.mt-4')); // Seleciona o conteúdo da página
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            alert('Página copiada para a área de transferência!');
        }
    </script>
</body>
</html>
