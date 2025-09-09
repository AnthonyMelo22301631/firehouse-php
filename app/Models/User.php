<?php
namespace App\Models;

class User {
  public ?int $id = null;
  public string $name;
  public string $email;
  public string $password_hash;
  public string $created_at;

  public function __construct(array $data=[]) {
    foreach ($data as $k=>$v) if (property_exists($this,$k)) $this->$k = $v;
  }
}
