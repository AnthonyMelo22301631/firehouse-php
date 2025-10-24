<?php
namespace App\Repositories;

use PDO;
use DB;

class ServicoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /** 🔹 Lista todos os serviços com nome do colaborador */
    public function allWithUsers(): array {
        $sql = "SELECT s.*, u.nome AS colaborador
                FROM servicos s
                JOIN users u ON s.user_id = u.id
                ORDER BY s.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Cria um novo serviço */
    public function create(array $data): void {
        $sql = "INSERT INTO servicos (nome, descricao, preco, user_id)
                VALUES (:nome, :descricao, :preco, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'] ?? null,
            ':descricao' => $data['descricao'] ?? null,
            ':preco' => $data['preco'] ?? null,
            ':user_id' => $data['user_id'] ?? null
        ]);
    }

    /** 🔹 Busca um serviço pelo ID */
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM servicos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /** 🔹 Lista serviços de um usuário específico */
    public function allByUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM servicos WHERE user_id = :id ORDER BY id DESC");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Cria um serviço com código e status */
    public function createWithCodigo(array $data): void {
        $sql = "INSERT INTO servicos (nome, descricao, preco, user_id, codigo_servico, status)
                VALUES (:nome, :descricao, :preco, :user_id, :codigo_servico, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'] ?? null,
            ':descricao' => $data['descricao'] ?? null,
            ':preco' => $data['preco'] ?? null,
            ':user_id' => $data['user_id'] ?? null,
            ':codigo_servico' => $data['codigo_servico'] ?? null,
            ':status' => $data['status'] ?? null
        ]);
    }

    /** 🔹 Busca um serviço pelo código */
    public function findByCodigo(string $codigo): ?array {
        $stmt = $this->db->prepare("SELECT * FROM servicos WHERE codigo_servico = :codigo");
        $stmt->execute([':codigo' => $codigo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
