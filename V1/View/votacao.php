<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

session_start();

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
    <title>Votação - Lambe Lambe Awards</title>
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
        <section class="votacao">
            <h2>Vote nos Indicados</h2>

            <!-- Exibe mensagens de erro ou sucesso -->
            <?php if (isset($_SESSION['success'])): ?>
                <p class="success"><?= $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="error"><?= $_SESSION['error']; ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Formulários de votação individuais para cada categoria -->
            <?php foreach ($categorias as $categoria): ?>
                <form action="../Control/VotacaoController.php?votar" method="POST">
                    <div class="votacao-item">
                        <h3><?= htmlspecialchars($categoria['nome']); ?></h3>

                        <!-- Busca os indicados para esta categoria -->
                        <?php
                        $indicados = $votacaoDAO->getIndicadosPorCategoria($categoria['id']);
                        ?>
                        
                        <label for="indicado_<?= $categoria['id']; ?>">Escolha um indicado:</label>
                        <select id="indicado_<?= $categoria['id']; ?>" name="indicado_<?= $categoria['id']; ?>">
                            <option value="" selected disabled>Selecione...</option>
                            <?php foreach ($indicados as $indicado): ?>
                                <option value="<?= $indicado['id']; ?>"><?= htmlspecialchars($indicado['nome']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit">Votar</button>
                </form>
                <br>
            <?php endforeach; ?>

        </section>
    </div>

    <footer>
        <p>&copy; 2024 Lambe Lambe Awards. Todos os direitos reservados.</p>
    </footer>
</body>
</html>