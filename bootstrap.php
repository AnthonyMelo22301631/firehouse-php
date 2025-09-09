<?php
// Autoload básico<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Conexão PDO única
class DB {
  private static ?PDO $pdo = null;
  public static function pdo(): PDO {
    if (!self::$pdo) {
      $c = require __DIR__ . '/config/database.php';
      $dsn = "mysql:host={$c['host']}".(isset($c['port']) && $c['port'] ? ";port={$c['port']}" : "").";dbname={$c['dbname']};charset={$c['charset']}";
      self::$pdo = new PDO($dsn, $c['user'], $c['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
    return self::$pdo;
  }
}

// helpers de auth
function auth_user_id(): ?int { return $_SESSION['uid'] ?? null; }
function require_login() {
  if (!auth_user_id()) { header('Location: /firehouse-php/public/auth/login'); exit; }
}

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
