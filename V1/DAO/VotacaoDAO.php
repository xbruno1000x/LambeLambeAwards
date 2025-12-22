<?php
require_once 'ConnectionFactory.php';
require_once '../Model/Votacao.php';

class VotacaoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para cadastrar uma nova categoria de votação
    public function cadastrarCategoria($categoria) {
        $sql = "INSERT INTO categorias (nome) VALUES (:nome)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $categoria);
        
        if ($stmt->execute()) {
            return $this->pdo->lastInsertId(); // Retorna o ID da categoria recém inserida
        } else {
            throw new Exception("Erro ao cadastrar a categoria.");
        }
    }

    // Método para cadastrar os indicados para uma categoria
    public function cadastrarIndicados($categoria_id, $indicados) {
        $sql = "INSERT INTO indicados (categoria_id, nome) VALUES (:categoria_id, :nome)";
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($indicados as $indicado) {
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':nome', $indicado);
            $stmt->execute();
        }
    }

    // Método para registrar votos na tabela 'votos'
    public function registrarVoto($categoria_id, $indicado_id) {
        $sql = "INSERT INTO votos (categoria_id, indicado_id) 
                VALUES (:categoria_id, :indicado_id) 
                ON DUPLICATE KEY UPDATE voto = voto + 1"; // Incrementa o voto caso já exista

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':indicado_id', $indicado_id);

        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            throw new Exception("Erro ao registrar o voto.");
        }
    }

    // Método para buscar todas as categorias
    public function getAllCategorias() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->pdo->query($sql);
        $categorias = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorias[] = $row;
        }

        return $categorias;
    }

    // Método para buscar os indicados de uma categoria
    public function getIndicadosPorCategoria($categoria_id) {
        $sql = "SELECT * FROM indicados WHERE categoria_id = :categoria_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();

        $indicados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $indicados[] = $row;
        }

        return $indicados;
    }

    public function getVotosPorCategoria($categoria_id) {
        $sql = "SELECT i.nome, COALESCE(v.voto, 0) AS total_votos
                FROM indicados i
                LEFT JOIN votos v ON v.indicado_id = i.id AND v.categoria_id = i.categoria_id
                WHERE i.categoria_id = :categoria_id
                ORDER BY total_votos DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Método para buscar uma categoria pelo ID
    public function getCategoriaById($categoria_id) {
        $sql = "SELECT nome FROM categorias WHERE id = :categoria_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excluirVotacaoPorCategoria($categoria_id) {
        try {
            // Iniciar uma transação
            $this->pdo->beginTransaction();
    
            // Excluir todos os votos relacionados à categoria
            $sqlVotos = "DELETE FROM votos WHERE categoria_id = :categoria_id";
            $stmtVotos = $this->pdo->prepare($sqlVotos);
            $stmtVotos->bindParam(':categoria_id', $categoria_id);
            $stmtVotos->execute();
    
            // Excluir todos os indicados relacionados à categoria
            $sqlIndicados = "DELETE FROM indicados WHERE categoria_id = :categoria_id";
            $stmtIndicados = $this->pdo->prepare($sqlIndicados);
            $stmtIndicados->bindParam(':categoria_id', $categoria_id);
            $stmtIndicados->execute();
    
            // Excluir a categoria
            $sqlCategoria = "DELETE FROM categorias WHERE id = :categoria_id";
            $stmtCategoria = $this->pdo->prepare($sqlCategoria);
            $stmtCategoria->bindParam(':categoria_id', $categoria_id);
            $stmtCategoria->execute();
    
            // Se tudo correr bem, confirmar a transação
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Em caso de erro, desfazer a transação
            $this->pdo->rollBack();
            throw new Exception("Erro ao excluir a categoria e seus dados relacionados: " . $e->getMessage());
        }
    }    
}