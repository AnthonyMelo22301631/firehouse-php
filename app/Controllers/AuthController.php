<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\UserRepository;

class AuthController {
    private UserRepository $users;

    public function __construct() {
        $this->users = new UserRepository();
    }

    // Mostrar formulários
    public function showLogin() {
        return View::render('auth/login');
    }

    public function showRegister() {
        return View::render('auth/register');
    }

    // Login
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        $u = $this->users->findByEmail($email);
        if (!$u || !password_verify($pass, $u->password_hash)) {
            return View::render('auth/login', ['error' => 'Credenciais inválidas.']);
        }

        // salva ID do usuário logado na sessão
        $_SESSION['user_id'] = $u->id;

        header('Location: /firehouse-php/public/');
        exit;
    }

    // Registro
    public function register() {
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
            return View::render('auth/register', ['error' => 'Dados inválidos.']);
        }

        if ($this->users->findByEmail($email)) {
            return View::render('auth/register', ['error' => 'E-mail já cadastrado.']);
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $user = $this->users->create($name, $email, $hash);

        $_SESSION['user_id'] = $user->id;

        header('Location: /firehouse-php/public/');
        exit;
    }

    // Logout
    public function logout() {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
        header('Location: /firehouse-php/public/auth/login');
        exit;
    }

    // Perfil
    public function perfil() {
        if (!($_SESSION['user_id'] ?? null)) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }

        $user = $this->users->findById($_SESSION['user_id']);
        return View::render('auth/perfil', ['user' => $user]);
    }
}
