<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lambe Lambe Awards</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
session_start();
if (isset($_SESSION['mensagem'])) {
    echo '<div class="alert">' . htmlspecialchars($_SESSION['mensagem']) . '</div>';
    unset($_SESSION['mensagem']); // Limpa a mensagem após exibi-la
}
?>


    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="../View/index.php" class="admin-button">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <aside class="admin-menu">
            <ul>
                <li><a href="../View/cadastrarVotacao.php">Cadastrar Votação</a></li>
                <li><a href="../View/exibirVotos.php">Ver Votos</a></li>
                <li><a href="../View/excluirVotacao.php">Excluir Votação</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <h2>Bem-vindo, Admin</h2>
            <p>Escolha uma opção no menu à esquerda para gerenciar as votações.</p>
        </main>
    </div>

    <footer>
        <p>&copy; 2024 Lambe Lambe Awards. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
