<?php
namespace App\Repositories;

use PDO;
use DB;

class EventoRepository {
    private PDO $db;

    public function __construct() {
        // Garante que sempre temos a conexão PDO disponível
        $this->db = DB::pdo();
    }

  public function all(): array {
    // troque u.name por u.nome se sua coluna for "nome"
    $sql = "SELECT e.*, u.name AS criador
            FROM eventos e
            JOIN users u ON u.id = e.user_id
            ORDER BY e.data_evento DESC";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
    public function allByUser(int $userId): array {
    $sql = "SELECT e.*, u.name AS criador
            FROM eventos e
            JOIN users u ON u.id = e.user_id
            WHERE e.user_id = :uid
            ORDER BY e.data_evento DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function create(array $data): void {
        $sql = "INSERT INTO eventos (user_id, titulo, local, servicos, tipo, data_evento, descricao)
                VALUES (:user_id, :titulo, :local, :servicos, :tipo, :data_evento, :descricao)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void {
        $sql = "UPDATE eventos 
                   SET titulo = :titulo,
                       local = :local,
                       servicos = :servicos,
                       tipo = :tipo,
                       data_evento = :data_evento,
                       descricao = :descricao
                 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':local' => $data['local'],
            ':servicos' => $data['servicos'],
            ':tipo' => $data['tipo'],
            ':data_evento' => $data['data_evento'],
            ':descricao' => $data['descricao'],
            ':id' => $id,
        ]);
    }

    public function belongsToUser(int $id, int $userId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM eventos WHERE id = :id AND user_id = :uid");
        $stmt->execute([
            ':id' => $id,
            ':uid' => $userId
        ]);
        return (bool)$stmt->fetchColumn();
    }

    public function deleteById(int $id, int $userId): bool {
        $sql = "DELETE FROM eventos WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }
    public function findById(int $id): ?array {
    $stmt = $this->db->prepare("SELECT * FROM eventos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);
    return $evento ?: null;
}
}
