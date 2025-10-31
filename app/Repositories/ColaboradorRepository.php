<?php
namespace App\Repositories;

use PDO;
use DB;

class ColaboradorRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /**
     * 🔹 Lista todos os serviços disponíveis (não vinculados e ativos)
     */
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

    /**
     * 🔹 Cadastra um novo serviço
     */
    public function create(array $data): void {
        $sql = "INSERT INTO servicos (user_id, nome, descricao, preco, vinculado, status)
                VALUES (:user_id, :nome, :descricao, :preco, 0, 'ativo')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    /**
     * 🔹 (Opcional) Desvincula um serviço para torná-lo disponível novamente
     */
    public function desvincularServico(int $servicoId): bool {
        $sql = "UPDATE servicos 
                SET vinculado = 0, evento_id = NULL, status = 'ativo'
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $servicoId]);
    }
    /** 🔹 Adiciona evento finalizado ao portfólio do colaborador */
public function adicionarAoPortfolio(array $data): bool {
    $sql = "INSERT INTO portfolio (colaborador_id, evento_id, data_insercao)
            VALUES (:colaborador_id, :evento_id, NOW())";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':colaborador_id' => $data['colaborador_id'],
        ':evento_id' => $data['evento_id']
    ]);
}
}
