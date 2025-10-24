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
        $sql = "SELECT s.*, u.name AS colaborador
                FROM servicos s
                JOIN users u ON u.id = s.user_id
                ORDER BY s.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void {
        $sql = "INSERT INTO servicos (user_id, nome, descricao, preco)
                VALUES (:user_id, :nome, :descricao, :preco)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }
}
