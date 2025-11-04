<?php
namespace App\Repositories;
use PDO;
use DB;
class ColaboradorRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }
   public function all(): array {
    $sql = "SELECT s.*, u.nome AS colaborador
            FROM servicos s
            JOIN users u ON u.id = s.user_id
            WHERE (s.vinculado = 0 OR s.vinculado IS NULL)
              AND (s.status = 'ativo' OR s.status IS NULL)
            ORDER BY s.id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function create(array $data): void {
        $sql = "INSERT INTO servicos (user_id, nome, descricao, preco, vinculado, status)
                VALUES (:user_id, :nome, :descricao, :preco, 0, 'ativo')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }
    public function getPortfolioByColaborador($colaboradorId) {
    $sql = "SELECT p.*, s.nome AS servico_nome, e.titulo AS evento_nome
            FROM portfolio p
            LEFT JOIN servicos s ON s.id = p.servico_id
            LEFT JOIN eventos e ON e.id = p.evento_id
            WHERE p.colaborador_id = :colaborador_id
            ORDER BY p.data_insercao DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':colaborador_id' => $colaboradorId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function desvincularServico(int $servicoId): bool {
        $sql = "UPDATE servicos 
                SET vinculado = 0, evento_id = NULL, status = 'ativo'
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $servicoId]);
    }
public function adicionarAoPortfolio(array $data): bool {

$sql = "INSERT INTO portfolio 
        (colaborador_id, evento_id, servico_id, comentario, nota, cliente_nome, data_insercao)
        VALUES 
        (:colaborador_id, :evento_id, :servico_id, :comentario, :nota, :cliente_nome, NOW())";

    
    $stmt = $this->db->prepare($sql);
    
    error_log("🟢 [DEBUG] Inserindo no portfólio: " . print_r($data, true));

    return $stmt->execute([
        ':colaborador_id' => $data['colaborador_id'],
        ':evento_id' => $data['evento_id'],
        ':servico_id' => $data['servico_id'],
        ':comentario' => $data['comentario'] ?? null, 
        ':nota' => $data['nota'] ?? null, 
        ':cliente_nome' => $data['cliente_nome'] ?? null 
    ]);
}


}
