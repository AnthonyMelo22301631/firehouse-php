<?php
namespace App\Repositories;

use PDO;
use DB;

class EventoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /** 🔹 Buscar todos os eventos */
    public function all(): array {
        $sql = "SELECT e.*, u.nome AS criador, u.contato AS contato_criador
                FROM eventos e
                INNER JOIN users u ON u.id = e.user_id
                WHERE e.status_evento IN ('aberto', 'em_andamento', 'finalizado')
                ORDER BY e.data_evento DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Buscar eventos do usuário logado */
    public function allByUser(int $userId): array {
        $sql = "SELECT e.*, u.nome AS nome_criador, u.contato AS telefone_criador
                FROM eventos e
                INNER JOIN users u ON u.id = e.user_id
                WHERE e.user_id = :uid
                ORDER BY e.data_evento DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Criar novo evento */
    public function create(array $data): void {
        $sql = "INSERT INTO eventos (
                    user_id, titulo, tipo, local, cidade, estado,
                    servicos, data_evento, descricao, status_evento
                ) VALUES (
                    :user_id, :titulo, :tipo, :local, :cidade, :estado,
                    :servicos, :data_evento, :descricao, :status_evento
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    /** 🔹 Atualizar evento existente */
    public function update(int $id, array $data): void {
        $sql = "UPDATE eventos
                   SET titulo = :titulo,
                       tipo = :tipo,
                       local = :local,
                       cidade = :cidade,
                       estado = :estado,
                       servicos = :servicos,
                       data_evento = :data_evento,
                       descricao = :descricao
                 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':tipo' => $data['tipo'],
            ':local' => $data['local'],
            ':cidade' => $data['cidade'],
            ':estado' => $data['estado'],
            ':servicos' => $data['servicos'],
            ':data_evento' => $data['data_evento'],
            ':descricao' => $data['descricao'],
            ':id' => $id
        ]);
    }

    /** 🔹 Buscar evento específico */
    public function findById(int $id): ?array {
        $sql = "SELECT e.*, u.nome AS nome_criador, u.contato AS telefone_criador
                FROM eventos e
                INNER JOIN users u ON u.id = e.user_id
                WHERE e.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        return $evento ?: null;
    }

    /** 🔹 Atualizar status do evento */
    public function atualizarStatusEvento(int $eventoId, string $status): bool {
        $stmt = $this->db->prepare("
            UPDATE eventos 
            SET status_evento = :status 
            WHERE id = :id
        ");
        return $stmt->execute([
            ':status' => $status,
            ':id' => $eventoId
        ]);
    }

    /** 🔹 Vincular serviço a um evento */
    public function vincularServico(int $eventoId, int $servicoId): bool {
        $check = $this->db->prepare("
            SELECT 1 FROM eventos_servicos 
            WHERE evento_id = :evento AND servico_id = :servico
        ");
        $check->execute([':evento' => $eventoId, ':servico' => $servicoId]);
        if ($check->fetchColumn()) return false;

        $insert = $this->db->prepare("
            INSERT INTO eventos_servicos (evento_id, servico_id, data_vinculo)
            VALUES (:evento, :servico, NOW())
        ");
        return $insert->execute([
            ':evento' => $eventoId,
            ':servico' => $servicoId
        ]);
    }

    /** 🔹 Retorna serviços já vinculados ao evento */
    public function getServicosVinculados(int $eventoId): array {
        $sql = "SELECT s.nome 
                FROM eventos_servicos es
                JOIN servicos s ON es.servico_id = s.id
                WHERE es.evento_id = :evento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':evento' => $eventoId]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'nome');
    }

    /** 🔹 Buscar colaboradores vinculados */
    public function getColaboradoresDoEvento(int $eventoId): array {
        $sql = "SELECT u.id AS colaborador_id, u.nome AS colaborador_nome, s.nome AS servico_nome
                FROM eventos_servicos es
                JOIN servicos s ON es.servico_id = s.id
                JOIN users u ON s.user_id = u.id
                WHERE es.evento_id = :evento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':evento' => $eventoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
