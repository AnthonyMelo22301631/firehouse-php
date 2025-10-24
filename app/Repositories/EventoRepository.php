<?php
namespace App\Repositories;

use PDO;
use DB;

class EventoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    // 🔹 Buscar todos os eventos
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

    // 🔹 Buscar eventos do usuário logado
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

    // 🔹 Criar novo evento
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

    // 🔹 Atualizar evento existente
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

    // 🔹 Verifica se o evento pertence ao usuário logado
    public function belongsToUser(int $id, int $userId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM eventos WHERE id = :id AND user_id = :uid");
        $stmt->execute([':id' => $id, ':uid' => $userId]);
        return (bool)$stmt->fetchColumn();
    }

    // 🔹 Excluir evento
    public function deleteById(int $id, int $userId): bool {
        $sql = "DELETE FROM eventos WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }

    // 🔹 Buscar evento específico
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
    public function getColaboradoresDoEvento(int $eventoId): array {
    $sql = "SELECT c.id AS colaborador_id, u.nome AS colaborador_nome, s.nome AS servico_nome
            FROM eventos_servicos es
            JOIN servicos s ON es.servico_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN colaboradores c ON c.user_id = u.id
            WHERE es.evento_id = :evento";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':evento' => $eventoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // 🔹 Marcar serviço encontrado
    public function marcarServicoComoEncontrado(int $eventoId, string $servico): bool {
        $stmt = $this->db->prepare("SELECT servicos_encontrados FROM eventos WHERE id = :id");
        $stmt->execute([':id' => $eventoId]);
        $atual = $stmt->fetchColumn();

        $lista = array_filter(array_map('trim', explode(',', $atual ?? '')));
        if (!in_array($servico, $lista)) {
            $lista[] = $servico;
        }

        $novoValor = implode(',', $lista);
        $stmt2 = $this->db->prepare("UPDATE eventos SET servicos_encontrados = :s WHERE id = :id");
        return $stmt2->execute([':s' => $novoValor, ':id' => $eventoId]);
    }

    // 🔹 Atualizar status do evento
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

    // ✅ Vincular colaborador ao evento usando código do serviço
    public function vincularServicoPorCodigo(int $eventoId, string $codigoServico): bool {
        // Busca serviço e colaborador pelo código
        $sql = "SELECT id, user_id FROM servicos WHERE codigo_servico = :codigo AND status = 'ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':codigo' => $codigoServico]);
        $servico = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$servico) {
            throw new \Exception("Código de serviço inválido ou inativo.");
        }

        $servicoId = $servico['id'];
        $colaboradorId = $servico['user_id'];

        // Verifica se já existe vínculo
        $check = $this->db->prepare("
            SELECT 1 FROM eventos_servicos 
            WHERE evento_id = :evento AND servico_id = :servico
        ");
        $check->execute([':evento' => $eventoId, ':servico' => $servicoId]);
        if ($check->fetchColumn()) {
            throw new \Exception("Esse serviço já está vinculado a este evento.");
        }

        // Cria o vínculo corretamente
        $insert = $this->db->prepare("
            INSERT INTO eventos_servicos (evento_id, servico_id, colaborador_id, servico_codigo, data_vinculo)
            VALUES (:evento, :servico, :colab, :codigo, NOW())
        ");
        $insert->execute([
            ':evento' => $eventoId,
            ':servico' => $servicoId,
            ':colab' => $colaboradorId,
            ':codigo' => $codigoServico
        ]);

        // Atualiza status do serviço
        $up = $this->db->prepare("UPDATE servicos SET status = 'em_evento' WHERE id = :id");
        $up->execute([':id' => $servicoId]);

        return true;
    }
}
