<?php
require_once '../Control/ExibirVotosController.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Votação</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="../View/dashboard.php" class="back-button">Voltar</a>
    <div class="container">
        <h1>Resultados das Votações</h1>
        
        <?php if (!empty($votacoes)): ?>
            <?php foreach ($votacoes as $votacao): ?>
                <div class="votacao">
                    <h2><?php echo htmlspecialchars($votacao['categoria']['nome']); ?></h2>

                    <?php if (!empty($votacao['votos'])): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Indicado</th>
                                    <th>Total de Votos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($votacao['votos'] as $voto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($voto['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($voto['total_votos']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Nenhum voto registrado nesta categoria.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma categoria cadastrada.</p>
        <?php endif; ?>
    </div>
</body>
</html>
