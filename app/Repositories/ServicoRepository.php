<?php
namespace App\Repositories;

use PDO;
use DB;

class ServicoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    public function allWithUsers(): array {
        $sql = "SELECT s.*, u.nome AS colaborador
                FROM servicos s
                JOIN users u ON s.user_id = u.id
                ORDER BY s.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void {
        $sql = "INSERT INTO servicos (nome, descricao, preco, user_id)
                VALUES (:nome, :descricao, :preco, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM servicos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
    public function allByUser(int $userId): array {
    $stmt = $this->db->prepare("SELECT * FROM servicos WHERE user_id = :id ORDER BY id DESC");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function createWithCodigo(array $data): void {
    $sql = "INSERT INTO servicos (nome, descricao, preco, user_id, codigo_servico, status)
            VALUES (:nome, :descricao, :preco, :user_id, :codigo_servico, :status)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($data);
}
}
