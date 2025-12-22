<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

try {
    $pdo = ConnectionFactory::getConnection();
    $votacaoDAO = new VotacaoDAO($pdo);
    $categorias = $votacaoDAO->getAllCategorias();
} catch (Exception $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Excluir Votação</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Excluir Votação</h1>
        </header>

        <form action="../Control/ExcluirVotacaoController.php" method="POST">
            <label for="categoria_id">Selecione a Categoria:</label>
            <select name="categoria_id" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Excluir Votação</button>
        </form>

        <a href="../View/dashboard.php" class="back-button">Voltar</a>
    </div>
</body>
</html>
