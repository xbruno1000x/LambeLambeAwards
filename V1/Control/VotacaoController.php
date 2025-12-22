<?php
require_once '../Model/Votacao.php';
require_once '../DAO/VotacaoDAO.php';
require_once '../DAO/ConnectionFactory.php';

class VotacaoController {
    private $votacaoDAO;

    public function __construct() {
        // Conecta ao banco de dados
        $pdo = ConnectionFactory::getConnection();
        $this->votacaoDAO = new VotacaoDAO($pdo);
    }

    public function votar() {
        session_start();

        // Verifica se o método é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Array para armazenar os nomes das categorias votadas
            $categoriasVotadas = [];

            // Itera sobre todos os campos indicados no $_POST
            foreach ($_POST as $campo => $indicado_id) {
                // Verifica se a chave é referente a uma categoria (começa com 'indicado_')
                if (strpos($campo, 'indicado_') === 0) {
                    // Extrai o ID da categoria
                    $categoria_id = str_replace('indicado_', '', $campo);

                    // Depuração: Verifica o voto recebido
                    echo "Categoria ID: " . $categoria_id . " - Indicado ID: " . $indicado_id . "<br>";

                    // Verifica se o indicado foi selecionado
                    if (empty($indicado_id)) {
                        $_SESSION['error'] = "Por favor, selecione um indicado para todas as categorias!";
                        header('Location: ../View/votacao.php');
                        exit();
                    }

                    // Obtém o nome da categoria
                    $categoria = $this->votacaoDAO->getCategoriaById($categoria_id);
                    $categoria_nome = $categoria['nome'];

                    // Adiciona o nome da categoria ao array
                    $categoriasVotadas[] = $categoria_nome;

                    // Tenta registrar o voto no banco de dados
                    try {
                        $this->votacaoDAO->registrarVoto($categoria_id, $indicado_id);
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Erro ao registrar o voto: " . $e->getMessage();
                        header('Location: ../View/votacao.php');
                        exit();
                    }
                }
            }

            // Cria uma mensagem de sucesso com as categorias votadas
            $categoriasVotadasString = implode(', ', $categoriasVotadas);
            $_SESSION['success'] = "Voto registrado com sucesso na categoria<br> " . $categoriasVotadasString;

            // Redireciona para a página de votação com a mensagem de sucesso
            header('Location: ../View/votacao.php');
            exit();
        } else {
            // Caso não seja uma requisição POST, redireciona para a página de votação
            header('Location: ../View/votacao.php');
            exit();
        }
    }
}

// Verifica se o parâmetro de query "votar" existe e chama o método apropriado
if (isset($_GET['votar'])) {
    $controller = new VotacaoController();
    $controller->votar();
}