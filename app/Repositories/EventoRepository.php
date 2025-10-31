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
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':titulo' => $data['titulo'],
            ':tipo' => $data['tipo'],
            ':local' => $data['local'],
            ':cidade' => $data['cidade'],
            ':estado' => $data['estado'],
            ':servicos' => $data['servicos'] ?? '',
            ':data_evento' => !empty($data['data_evento']) ? $data['data_evento'] : null,
            ':descricao' => $data['descricao'] ?? '',
            ':status_evento' => $data['status_evento'] ?? 'aberto'
        ]);
    }

    /** 🔹 Atualizar evento existente */
    public function update(int $id, array $data): void {
        $sql = "UPDATE eventos SET
                    titulo = :titulo,
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
            ':servicos' => $data['servicos'] ?? '',
            ':data_evento' => !empty($data['data_evento']) ? $data['data_evento'] : null,
            ':descricao' => $data['descricao'] ?? '',
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

        if ($evento) {
            $evento['servicos_array'] = array_filter(array_map('trim', explode(',', $evento['servicos'] ?? '')));
            $evento['servicos_vinculados'] = $this->getServicosVinculados($id);
        }

        return $evento ?: null;
    }

    /** 🔹 Atualizar status do evento */
    public function atualizarStatusEvento(int $eventoId, string $status): bool {
        $stmt = $this->db->prepare("UPDATE eventos SET status_evento = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $eventoId]);
    }

    /** 🔹 Vincular serviço ao evento e marcar como vinculado */
    public function vincularServico(int $eventoId, int $servicoId): bool {
        try {
            // Evita duplicidade no mesmo evento
            $check = $this->db->prepare("
                SELECT 1 FROM eventos_servicos
                WHERE evento_id = :evento AND servico_id = :servico
            ");
            $check->execute([':evento' => $eventoId, ':servico' => $servicoId]);
            if ($check->fetchColumn()) return false;

            // Evita vincular serviço já vinculado
            $checkEvento = $this->db->prepare("
                SELECT vinculado FROM servicos WHERE id = :servico
            ");
            $checkEvento->execute([':servico' => $servicoId]);
            if ($checkEvento->fetchColumn() == 1) return false;

            // Cria vínculo na tabela relacional
            $insert = $this->db->prepare("
                INSERT INTO eventos_servicos (evento_id, servico_id, data_vinculo)
                VALUES (:evento, :servico, NOW())
            ");
            $ok = $insert->execute([':evento' => $eventoId, ':servico' => $servicoId]);

            if ($ok) {
                // Atualiza status e vínculo na tabela servicos
                $update = $this->db->prepare("
                    UPDATE servicos
                    SET vinculado = 1, evento_id = :evento, status = 'em_evento'
                    WHERE id = :servico
                ");
                $update->execute([':evento' => $eventoId, ':servico' => $servicoId]);
            }

            // Confirma a transação e força leitura atualizada
            $this->db->query("COMMIT");
            $this->db->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

            return $ok;
        } catch (\PDOException $e) {
            error_log('Erro ao vincular serviço: ' . $e->getMessage());
            return false;
        }
    }
    public function salvar(array $data): bool {
    $sql = "INSERT INTO avaliacoes (evento_id, colaborador_id, nota, comentario)
            VALUES (:evento, :colab, :nota, :comentario)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':evento' => $data['evento_id'],
        ':colab' => $data['colaborador_id'],
        ':nota' => $data['nota'],
        ':comentario' => $data['comentario']
    ]);
}

    /** 🔹 Retorna todos os serviços vinculados ao evento */
    public function getServicosVinculados(int $eventoId): array {
        $sql = "SELECT 
                    s.id, 
                    s.nome, 
                    s.descricao, 
                    s.status, 
                    s.codigo_servico,
                    s.vinculado,
                    s.evento_id
                FROM servicos s
                INNER JOIN eventos_servicos es ON es.servico_id = s.id
                WHERE es.evento_id = :evento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':evento' => $eventoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Buscar colaboradores vinculados */
    public function getColaboradoresDoEvento(int $eventoId): array {
        $sql = "SELECT 
                    u.id AS colaborador_id, 
                    u.nome AS colaborador_nome, 
                    s.nome AS servico_nome
                FROM eventos_servicos es
                JOIN servicos s ON es.servico_id = s.id
                JOIN users u ON s.user_id = u.id
                WHERE es.evento_id = :evento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':evento' => $eventoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
