<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

// Conecta ao banco de dados
$pdo = ConnectionFactory::getConnection();
$votacaoDAO = new VotacaoDAO($pdo);

// Busca todas as categorias
$categorias = $votacaoDAO->getAllCategorias();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicados - Lambe Lambe Awards</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Lambe Lambe Awards</h1>
        <nav>
            <a href="../View/index.php">Início</a>
            <a href="../View/votacao.php">Votação</a>
            <a href="../View/indicados.php">Indicados</a>
            <a href="../View/sobre.php">Sobre</a>
        </nav>
    </header>

    <div class="container">
        <section class="indicados">
            <h2>Indicados por Categoria</h2>

            <?php foreach ($categorias as $categoria): ?>
                <h3><?= htmlspecialchars($categoria['nome']); ?></h3>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Indicados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $indicados = $votacaoDAO->getIndicadosPorCategoria($categoria['id']);
                        foreach ($indicados as $indicado): ?>
                            <tr>
                                <td><?= htmlspecialchars($indicado['nome']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
            <?php endforeach; ?>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Lambe Lambe Awards. Todos os direitos reservados.</p>
    </footer>
</body>
</html>