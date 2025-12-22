<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lambe Lambe Awards</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Botão de volta para a página inicial -->
    <a href="../View/index.php" class="back-button">Voltar</a>

    <div class="login-container">
        <h2>Login Administrador</h2>
        <form action="../Control/LoginController.php" method="POST">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>

        <!-- Exibindo mensagem de erro, se houver -->
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);  // Remove a mensagem após exibi-la
        }
        ?>
    </div>
</body>
</html>