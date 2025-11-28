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
    public function allWithUsers(array $filtros = []): array {
        $sql = "SELECT 
                    s.*, 
                    u.nome AS colaborador,
                    u.contato AS contato_colaborador
                FROM servicos s
                JOIN users u ON u.id = s.user_id
                WHERE (s.vinculado = 0 OR s.vinculado IS NULL)
                  AND (s.status = 'ativo' OR s.status IS NULL)";
        
        $params = [];

        // 🔸 Filtros opcionais
        if (!empty($filtros['nome_servico'])) {
            $sql .= " AND s.nome LIKE :nome_servico";
            $params[':nome_servico'] = "%" . $filtros['nome_servico'] . "%";
        }

        if (!empty($filtros['colaborador'])) {
            $sql .= " AND u.nome LIKE :colaborador";
            $params[':colaborador'] = "%" . $filtros['colaborador'] . "%";
        }

        if (!empty($filtros['status'])) {
            $sql .= " AND s.status = :status";
            $params[':status'] = $filtros['status'];
        }

        // 🔸 Ordenação personalizada
        switch ($filtros['ordenar'] ?? '') {
            case 'nome_asc':
                $sql .= " ORDER BY s.nome ASC";
                break;
            case 'nome_desc':
                $sql .= " ORDER BY s.nome DESC";
                break;
            case 'data_asc':
                $sql .= " ORDER BY s.created_at ASC";
                break;
            case 'data_desc':
                $sql .= " ORDER BY s.created_at DESC";
                break;
            default:
                $sql .= " ORDER BY s.id DESC";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Atualiza o status de um serviço */
    public function atualizarStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare("UPDATE servicos SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    /** 🔹 Busca todos os serviços de um colaborador (para a tela Meus Serviços) */
    public function getByUserId(int $userId): array {
        $sql = "SELECT s.*, u.nome AS colaborador 
                FROM servicos s
                JOIN users u ON u.id = s.user_id
                WHERE s.user_id = :user_id
                ORDER BY s.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 🔹 Cancela (desativa) um serviço do colaborador */
    public function cancelarServico(int $id, int $userId): bool {
        $sql = "UPDATE servicos 
                SET status = 'inativo' 
                WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** 🔹 Cria um novo serviço com código automático */
  public function create(array $data): void {
    $sql = "INSERT INTO servicos (nome, descricao, user_id, vinculado, status)
            VALUES (:nome, :descricao, :user_id, 0, 'ativo')";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':nome' => $data['nome'],
        ':descricao' => $data['descricao'],
        ':user_id' => $data['user_id']
    ]);
}

    /** 🔹 Busca um serviço específico pelo ID (com dados do colaborador) */
    public function find(int $id): ?array {
        $sql = "SELECT s.*, 
                       s.user_id,             
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

    /** 🔹 Retorna serviços disponíveis (ainda não vinculados) */public function getServicosDisponiveis(): array {
    $sql = "SELECT 
                s.id, 
                s.nome, 
                s.descricao, 
                s.preco,
                u.nome AS colaborador
            FROM servicos s
            INNER JOIN users u ON u.id = s.user_id
            WHERE (s.vinculado = 0 OR s.vinculado IS NULL)
              AND s.status = 'ativo'
            ORDER BY s.nome ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
