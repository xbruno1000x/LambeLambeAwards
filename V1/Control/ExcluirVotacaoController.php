<?php
require_once '../DAO/ConnectionFactory.php';
require_once '../DAO/VotacaoDAO.php';

class ExcluirVotacaoController {
    private $votacaoDAO;

    public function __construct() {
        $pdo = ConnectionFactory::getConnection();
        $this->votacaoDAO = new VotacaoDAO($pdo);
    }

    public function excluirVotacao($categoria_id) {
        try {
            $result = $this->votacaoDAO->excluirVotacaoPorCategoria($categoria_id);
            return $result ? "Votação excluída com sucesso." : "Erro ao excluir a votação.";
        } catch (Exception $e) {
            return "Erro: " . $e->getMessage();
        }
    }
}

// Verifica se o ID da categoria foi passado
if (isset($_POST['categoria_id'])) {
    $controller = new ExcluirVotacaoController();
    $mensagem = $controller->excluirVotacao($_POST['categoria_id']);
    
    // Definindo a mensagem na sessão
    session_start();
    $_SESSION['mensagem'] = $mensagem;

    // Redireciona para a dashboard.php
    header("Location: ../View/dashboard.php");
    exit; // Certifique-se de sair após o redirecionamento
}
?>