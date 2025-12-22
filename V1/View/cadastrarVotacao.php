<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Votação - Lambe Lambe Awards</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Botão de volta para a página inicial -->
    <a href="../View/dashboard.php" class="back-button">Voltar</a>
    <div class="container">
        <div class="votacao-container">
            <h2>Cadastro de Votação</h2>
            
            <!-- Exibe a mensagem de sucesso ou erro -->
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color: green;"><?php echo $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
                <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="../Control/CadastrarVotacaoController.php" method="POST">
                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" required>

                <label for="indicado1">Indicado 1:</label>
                <input type="text" id="indicado1" name="indicado1" required>

                <label for="indicado2">Indicado 2:</label>
                <input type="text" id="indicado2" name="indicado2" required>

                <label for="indicado3">Indicado 3:</label>
                <input type="text" id="indicado3" name="indicado3" required>

                <label for="indicado4">Indicado 4:</label>
                <input type="text" id="indicado4" name="indicado4" required>

                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html>