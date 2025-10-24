<?php
namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use DB;
use PDO;

class UserRepository implements UserRepositoryInterface {

    public function findByEmail(string $email): ?User {
        $st = DB::pdo()->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $st->execute([$email]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function findById(int $id): ?User {
        $st = DB::pdo()->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function create(array $data): ?User {
        $sql = "INSERT INTO users (nome, email, password_hash, estado, cidade, contato, is_colaborador)
                VALUES (:nome, :email, :password_hash, :estado, :cidade, :contato, 0)";
        $st = DB::pdo()->prepare($sql);

        $ok = $st->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':password_hash' => $data['password_hash'],
            ':estado' => $data['estado'],
            ':cidade' => $data['cidade'],
            ':contato' => $data['contato']
        ]);

        if (!$ok) return null;

        $id = (int) DB::pdo()->lastInsertId();
        return $this->findById($id);
    }

    public function setColaboradorStatus(int $userId, bool $status): void {
        $st = DB::pdo()->prepare("UPDATE users SET is_colaborador = ? WHERE id = ?");
        $st->execute([$status ? 1 : 0, $userId]);
    }

    public function findAllColaboradores(): array {
        $st = DB::pdo()->query("SELECT * FROM users WHERE is_colaborador = 1");
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => new User($r), $rows);
    }
}
