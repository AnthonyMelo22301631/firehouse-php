<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\ServicoRepository;
use App\Repositories\UserRepository;

class ColaboradorController {
    private ServicoRepository $repo;
    private UserRepository $userRepo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->repo = new ServicoRepository();
        $this->userRepo = new UserRepository();
    }

    /** 🔒 Exige login */
    private function requireLogin() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    /** 🔹 Lista todos os colaboradores e serviços */
    public function all() {
        $servicos = $this->repo->allWithUsers();
        return View::render('colaboradores/all', [
            'servicos' => $servicos
        ]);
    }

    /** 🔹 Exibe formulário para o colaborador cadastrar um serviço */
    public function create() {
        $this->requireLogin();
        return View::render('colaboradores/create');
    }

    /** 🔹 Salva um novo serviço */
    public function store() {
        $this->requireLogin();

        $nome = $_POST['nome'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        if (empty($nome) || empty($descricao)) {
            echo "Preencha todos os campos obrigatórios!";
            return;
        }

        $this->repo->create([
            'nome' => $nome,
            'descricao' => $descricao,
            'user_id' => $_SESSION['user_id']
        ]);

        // ✅ Redireciona para /colaboradores/all
        header('Location: /firehouse-php/public/colaboradores');
        exit;
    }
    public function sair()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 🔹 Garante que o usuário volte a ser "não colaborador" apenas na sessão
    $_SESSION['is_colaborador'] = 0;

    // 🔹 (Opcional) se quiser desfazer também no banco:
    if (!empty($_SESSION['user_id'])) {
        $sql = "UPDATE users SET is_colaborador = 0 WHERE id = :id";
        $stmt = \DB::pdo()->prepare($sql);
        $stmt->execute([':id' => $_SESSION['user_id']]);
    }

    // 🔹 Redireciona de volta para a página inicial ou login
    header("Location: /firehouse-php/public");
    exit;
}


    /** 🔹 Exibe o portfólio do colaborador logado */
    public function portfolio() {
        $this->requireLogin();
        $servicos = $this->repo->allByUser($_SESSION['user_id']);
        return View::render('colaboradores/portfolio', ['servicos' => $servicos]);
    }

    /** 🔹 Exibe a página de visualização de um serviço específico */
    public function view($id = null) {
        if (empty($id) && !empty($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (empty($id)) {
            echo "Serviço não especificado.";
            return;
        }

        // Buscar o serviço pelo ID
        $servico = $this->repo->find($id);

        if (!$servico) {
            echo "Serviço não encontrado.";
            return;
        }

        // ✅ Buscar o colaborador usando o método correto do UserRepository
        $colaborador = $this->userRepo->findById($servico['user_id']);

        // Renderizar a view
        return View::render('colaboradores/view', [
            'servico' => $servico,
            'colaborador' => $colaborador
        ]);
    }
public function ativar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header("Location: /firehouse-php/public/auth/login");
        exit;
    }

    try {
        // ✅ Atualiza o usuário para colaborador
        $sql = "UPDATE users SET is_colaborador = 1 WHERE id = :id";
        $stmt = \DB::pdo()->prepare($sql);
        $stmt->execute([':id' => $userId]);

        // ✅ Mantém o usuário logado como colaborador
        $_SESSION['is_colaborador'] = 1;

        // ✅ Redireciona para onde desejar
        // (pode ser a página inicial, dashboard, etc.)
        header("Location: /firehouse-php/public");
        exit;
    } catch (\PDOException $e) {
        error_log("Erro ao ativar colaborador: " . $e->getMessage());
        echo "<h3>Erro ao ativar colaborador. Contate o administrador.</h3>";
    }
}



}
