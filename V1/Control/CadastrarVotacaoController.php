<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $categoria = trim($_POST['categoria']);
    $indicados = [
        trim($_POST['indicado1']),
        trim($_POST['indicado2']),
        trim($_POST['indicado3']),
        trim($_POST['indicado4'])
    ];

    // Valida se os campos não estão vazios
    if (empty($categoria) || in_array('', $indicados)) {
        $_SESSION['error'] = "Todos os campos devem ser preenchidos!";
        header('Location: ../View/cadastrarVotacao.php');
        exit();
    }

    // Conecta ao banco de dados
    $pdo = ConnectionFactory::getConnection();
    $votacaoDAO = new VotacaoDAO($pdo);

    // Inicia uma transação para garantir que todas as inserções sejam feitas com sucesso
    try {
        $pdo->beginTransaction();

        // Cadastrar a categoria
        $categoria_id = $votacaoDAO->cadastrarCategoria($categoria);

        // Cadastrar os indicados
        $votacaoDAO->cadastrarIndicados($categoria_id, $indicados);

        // Commit da transação
        $pdo->commit();
        
        $_SESSION['success'] = "Votação cadastrada com sucesso!";
    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        $_SESSION['error'] = "Erro ao cadastrar votação: " . $e->getMessage();
    }

    // Redireciona para o formulário de cadastro
    header('Location: ../View/cadastrarVotacao.php');
    exit();
}?>