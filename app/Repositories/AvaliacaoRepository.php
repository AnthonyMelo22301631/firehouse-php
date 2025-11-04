<?php
namespace App\Repositories;

use PDO;
use DB;

class AvaliacaoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DB::pdo();
    }

    /**
     * ✅ Cria uma nova avaliação (cliente → colaborador)
     */
  public function criar(array $data): bool {
    $sql = "INSERT INTO avaliacoes 
            (evento_id, colaborador_id, servico_id, nota, comentario, cliente_nome, data_avaliacao)
            VALUES 
            (:evento_id, :colaborador_id, :servico_id, :nota, :comentario, :cliente_nome, :data_avaliacao)";
    
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':evento_id'      => $data['evento_id'],
        ':colaborador_id' => $data['colaborador_id'],
        ':servico_id'     => $data['servico_id'],
        ':nota'           => $data['nota'],
        ':comentario'     => $data['comentario'],
        ':cliente_nome'   => $data['cliente_nome'] ?? 'Cliente Anônimo',
        ':data_avaliacao' => $data['data_avaliacao'] ?? date('Y-m-d H:i:s')
    ]);
}

}
