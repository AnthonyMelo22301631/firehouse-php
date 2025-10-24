<?php
namespace App\Repositories;

use PDO;
use DB;

class MensagemRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    public function getByChat(int $chatId): array {
        $sql = "SELECT m.*, u.name AS autor 
                FROM mensagens m
                JOIN users u ON u.id = m.remetente_id
                WHERE chat_id = :id
                ORDER BY enviado_em ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $chatId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $chatId, int $userId, string $conteudo): bool {
        $sql = "INSERT INTO mensagens (chat_id, remetente_id, conteudo) 
                VALUES (:chat, :user, :conteudo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':chat' => $chatId,
            ':user' => $userId,
            ':conteudo' => $conteudo
        ]);
    }
}
