<?php
namespace App\Repositories;

use PDO;
use DB;

class AvaliacaoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /**
     * ✅ Cria uma nova avaliação (cliente → colaborador)
     */
    public function criar(array $data): bool {
        $sql = "INSERT INTO avaliacoes 
                   (evento_id, colaborador_id, cliente_id, nota, comentario, criado_em)
                VALUES 
                   (:evento_id, :colaborador_id, :cliente_id, :nota, :comentario, NOW())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':evento_id' => $data['evento_id'],
            ':colaborador_id' => $data['colaborador_id'],
            ':cliente_id' => $data['cliente_id'],
            ':nota' => $data['nota'],
            ':comentario' => $data['comentario']
        ]);
    }

    /**
     * 🔹 Lista avaliações de um colaborador (para exibir no portfólio)
     */
    public function listarPorColaborador(int $colabId): array {
        $sql = "SELECT a.*, u.nome AS cliente_nome, e.titulo AS evento_titulo
                FROM avaliacoes a
                JOIN users u ON a.cliente_id = u.id
                JOIN eventos e ON a.evento_id = e.id
                WHERE a.colaborador_id = :cid
                ORDER BY a.criado_em DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cid' => $colabId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 🔹 Calcula a média das notas de um colaborador
     */
    public function mediaPorColaborador(int $colabId): float {
        $sql = "SELECT AVG(nota) FROM avaliacoes WHERE colaborador_id = :cid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cid' => $colabId]);
        return (float)($stmt->fetchColumn() ?? 0);
    }

    /**
     * 🔹 Verifica se um cliente já avaliou um colaborador em determinado evento
     */
    public function jaAvaliou(int $eventoId, int $clienteId, int $colabId): bool {
        $sql = "SELECT 1 FROM avaliacoes 
                WHERE evento_id = :evento 
                AND cliente_id = :cliente 
                AND colaborador_id = :colab";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':evento' => $eventoId,
            ':cliente' => $clienteId,
            ':colab' => $colabId
        ]);
        return (bool)$stmt->fetchColumn();
    }
}
