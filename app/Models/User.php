<?php
namespace App\Models;

class User {
    public ?int $id = null;
    public string $nome = '';
    public string $email = '';
    public string $password_hash = '';
    public string $estado = '';
    public string $cidade = '';
    public string $contato = '';
    public ?string $created_at = null;
    public bool $is_colaborador = false;

    public function __construct(array $data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                // Converte automaticamente para booleano, se for o campo is_colaborador
                if ($k === 'is_colaborador') {
                    $this->$k = (bool)$v;
                } else {
                    $this->$k = $v ?? '';
                }
            }
        }
    }
}
