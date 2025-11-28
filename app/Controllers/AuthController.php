<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\UserRepository;
use Exception;

class AuthController {
    private UserRepository $users;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $this->users = new UserRepository();
        } catch (Exception $e) {
            die('Erro ao carregar UserRepository: ' . $e->getMessage());
        }
    }

    /** 🔹 Tela dos Termos */
    public function termos() {
        return View::render('auth/termos');
    }

    /** 🔹 Aceitar termos */
    public function aceitarTermos() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /firehouse-php/public/auth/login");
            exit;
        }

        // Atualiza no banco
        $this->users->updateTerms($_SESSION['user_id']);

        // Agora pode acessar tudo normalmente
        header("Location: /firehouse-php/public/");
        exit;
    }

    /** 🔹 Tela de login */
    public function showLogin() {
        return View::render('auth/login');
    }

    /** 🔹 Tela de registro */
    public function showRegister() {
        return View::render('auth/register');
    }

    /** 🔹 Login — SEM verificação de termos */
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['password'] ?? '';

        $user = $this->users->findByEmail($email);

        if (!$user || !password_verify($senha, $user->password_hash)) {
            return View::render('auth/login', ['error' => 'Credenciais inválidas.']);
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['is_colaborador'] = (bool)$user->is_colaborador;

        // 🔥 Agora vai direto para o sistema SEM pedir termos nunca mais
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

        // Validação
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

        // Já existe email
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

        // Loga automaticamente após cadastro
        $_SESSION['user_id'] = $user->id;

        // 🔥 Agora SIM: mostra os termos (somente no registro)
        header("Location: /firehouse-php/public/auth/termos");
        exit;
    }

    /** 🔹 Logout */
    public function logout() {
        session_destroy();
        session_regenerate_id(true);

        header('Location: /firehouse-php/public/auth/login');
        exit;
    }

    /** 🔹 Perfil */
    public function perfil() {
        if (!isset($_SESSION['user_id'])) {
            echo "Usuário não encontrado.";
            return;
        }

        $id = $_GET['id'] ?? $_SESSION['user_id'];
        $user = $this->users->findById((int)$id);

        if (!$user) {
            echo "Perfil não encontrado.";
            return;
        }

        $isOwner = ($_SESSION['user_id'] == $id);

        return View::render('auth/perfil', [
            'user' => $user,
            'isOwner' => $isOwner
        ]);
    }
}
