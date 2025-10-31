<?php
namespace App\Repositories;

use PDO;
use DB;

class ServicoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /** 🔹 Lista todos os serviços com o nome do colaborador (usado na página /colaboradores) */
    public function allWithUsers(): array {
        $sql = "SELECT s.*, u.nome AS colaborador
                FROM servicos s
                INNER JOIN users u ON u.id = s.user_id
                ORDER BY s.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Cria um novo serviço */
    public function create(array $data): void {
        $sql = "INSERT INTO servicos (nome, descricao, user_id, codigo_servico)
                VALUES (:nome, :descricao, :user_id, :codigo_servico)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'],
            ':descricao' => $data['descricao'],
            ':user_id' => $data['user_id'],
            ':codigo_servico' => $data['codigo_servico'] ?? strtoupper(uniqid('SRV-'))
        ]);
    }

    /** 🔹 Lista serviços de um usuário específico */
    public function allByUser(int $userId): array {
        $sql = "SELECT s.*, u.nome AS colaborador
                FROM servicos s
                INNER JOIN users u ON u.id = s.user_id
                WHERE s.user_id = :id
                ORDER BY s.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Busca um serviço específico pelo ID (com dados do colaborador) */
    public function find(int $id): ?array {
        $sql = "SELECT s.*, 
                       u.nome AS nome_colaborador, 
                       u.cidade, 
                       u.estado, 
                       u.contato
                FROM servicos s
                INNER JOIN users u ON u.id = s.user_id
                WHERE s.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $servico = $stmt->fetch(PDO::FETCH_ASSOC);
        return $servico ?: null;
    }

    /** 🔹 Busca um serviço pelo código (usado para vincular evento) */
    public function findByCodigo(string $codigo): ?array {
        $sql = "SELECT s.*, u.nome AS colaborador
                FROM servicos s
                INNER JOIN users u ON u.id = s.user_id
                WHERE s.codigo_servico = :codigo
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':codigo' => $codigo]);
        $servico = $stmt->fetch(PDO::FETCH_ASSOC);
        return $servico ?: null;
    }
}
