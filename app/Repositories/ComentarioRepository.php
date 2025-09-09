<?php
namespace App\Repositories;

use PDO;

class ComentarioRepository {
    private PDO $db;

    public function __construct() {
        $this->db = \DB::pdo();
    }

    public function create(array $data): void {
        $sql = "INSERT INTO comentarios (evento_id, user_id, conteudo) 
                VALUES (:evento_id, :user_id, :conteudo)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

  public function allByEvento(int $eventoId): array {
    $sql = "SELECT c.*, u.name AS autor 
            FROM comentarios c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.evento_id = :evento_id 
            ORDER BY c.criado_em DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['evento_id' => $eventoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
