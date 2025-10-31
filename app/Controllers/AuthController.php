<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\UserRepository; // ✅ importação correta
use Exception;

class AuthController {
    private UserRepository $users;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            // ✅ garante o carregamento correto da classe UserRepository
            $this->users = new UserRepository();
        } catch (Exception $e) {
            die('Erro ao carregar UserRepository: ' . $e->getMessage());
        }
    }

    /** 🔹 Exibe tela de login */
    public function showLogin() {
        return View::render('auth/login');
    }

    /** 🔹 Exibe tela de cadastro */
    public function showRegister() {
        return View::render('auth/register');
    }

    /** 🔹 Login */
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['password'] ?? '';

        $user = $this->users->findByEmail($email);

        if (!$user || !password_verify($senha, $user->password_hash)) {
            return View::render('auth/login', ['error' => 'Credenciais inválidas.']);
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['is_colaborador'] = (bool)$user->is_colaborador;

        header('Location: /firehouse-php/public/');
        exit;
    }

    /** 🔹 Registro */
    public function register() {
        $nome    = trim($_POST['nome'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $senha   = $_POST['password'] ?? '';
        $estado  = trim($_POST['estado'] ?? '');
        $cidade  = trim($_POST['cidade'] ?? '');
        $contato = trim($_POST['contato'] ?? '');

        // ✅ Validação
        if (
            $nome === '' ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($senha) < 6 ||
            $estado === '' ||
            $cidade === '' ||
            $contato === ''
        ) {
            return View::render('auth/register', [
                'error' => 'Dados inválidos. Preencha todos os campos corretamente.'
            ]);
        }

        if ($this->users->findByEmail($email)) {
            return View::render('auth/register', [
                'error' => 'E-mail já cadastrado.'
            ]);
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $user = $this->users->create([
            'nome' => $nome,
            'email' => $email,
            'password_hash' => $hash,
            'estado' => $estado,
            'cidade' => $cidade,
            'contato' => $contato
        ]);

        if (!$user) {
            return View::render('auth/register', [
                'error' => 'Erro ao cadastrar. Tente novamente.'
            ]);
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['is_colaborador'] = (bool)$user->is_colaborador;

        header('Location: /firehouse-php/public/');
        exit;
    }

    /** 🔹 Logout */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        session_regenerate_id(true);

        header('Location: /firehouse-php/public/auth/login');
        exit;
    }

    /** 🔹 Exibe perfil do usuário logado ou outro via ID */
    public function perfil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ✅ prioriza o usuário logado, mas permite visualizar outro via ?id=#
        $id = $_GET['id'] ?? $_SESSION['user_id'] ?? null;

        if (!$id) {
            echo "Usuário não encontrado.";
            return;
        }

        $user = $this->users->findById((int)$id);

        if (!$user) {
            echo "Perfil não encontrado.";
            return;
        }

        $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;

        return View::render('auth/perfil', [
            'user' => $user,
            'isOwner' => $isOwner
        ]);
    }
}
