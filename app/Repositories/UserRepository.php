<?php
namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use DB;
use PDO;

class UserRepository implements UserRepositoryInterface {
  public function findByEmail(string $email): ?User {
    $st = DB::pdo()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    $row = $st->fetch();
    return $row ? new User($row) : null;
  }

  public function findById(int $id): ?User {
    $st = DB::pdo()->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ? new User($row) : null;
  }

  public function create(string $name, string $email, string $passwordHash): User {
    $st = DB::pdo()->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)");
    $st->execute([$name, $email, $passwordHash]);
    $id = (int)DB::pdo()->lastInsertId();
    return $this->findById($id);
  }
}
