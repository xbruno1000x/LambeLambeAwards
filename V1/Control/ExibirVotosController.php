<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

try {
    $pdo = ConnectionFactory::getConnection();
    $votacaoDAO = new VotacaoDAO($pdo);

    $categorias = $votacaoDAO->getAllCategorias();
    
    $votacoes = [];
    foreach ($categorias as $categoria) {
        $votos = $votacaoDAO->getVotosPorCategoria($categoria['id']);
        $votacoes[] = [
            'categoria' => $categoria,
            'votos' => $votos
        ];
    }
} catch (Exception $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>