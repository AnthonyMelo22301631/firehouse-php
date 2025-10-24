<?php
namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function create(array $data): ?User;
    public function setColaboradorStatus(int $userId, bool $status): void;
    public function findAllColaboradores(): array;
}
