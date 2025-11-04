<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\ColaboradorRepository;
use App\Repositories\ServicoRepository;
use App\Repositories\UserRepository;

class ColaboradorController {
    private ColaboradorRepository $colabRepo;
    private ServicoRepository $servicoRepo;
    private UserRepository $userRepo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->colabRepo = new ColaboradorRepository();
        $this->servicoRepo = new ServicoRepository();
        $this->userRepo = new UserRepository();
    }
    public function view($id = null) {
    if (empty($id) && !empty($_GET['id'])) {
        $id = $_GET['id'];
    }

    if (empty($id)) {
        echo "Serviço não especificado.";
        return;
    }

    $servico = $this->servicoRepo->find($id);

    if (!$servico) {
        echo "Serviço não encontrado.";
        return;
    }

    $colaborador = $this->userRepo->findById($servico['user_id']);

    return View::render('colaboradores/view', [
        'servico' => $servico,
        'colaborador' => $colaborador
    ]);
}

public function meusServicos() {
    if (empty($_SESSION['user_id'])) {
        header('Location: /firehouse-php/public/auth/login');
        exit;
    }

    $userId = $_SESSION['user_id'];
    $servicos = $this->servicoRepo->getByUserId($userId);

    return View::render('colaboradores/meus-servicos', [
        'servicos' => $servicos
    ]);
}

public function cancelarServico() {
    if (empty($_SESSION['user_id']) || empty($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
        return;
    }

    $id = (int)$_POST['id'];
    $userId = $_SESSION['user_id'];

    $ok = $this->servicoRepo->cancelarServico($id, $userId);

    echo json_encode(['success' => $ok]);
}

    public function portfolioPublic(): string {
    $colaboradorId = $_GET['id'] ?? null;

    if (!$colaboradorId) {
        http_response_code(400);
        return "ID do colaborador não informado.";
    }

    // 🔹 Busca o portfólio desse colaborador
    $portfolio = $this->colabRepo->getPortfolioByColaborador((int)$colaboradorId);

    // 🔹 Busca informações básicas do colaborador
    $stmt = \DB::pdo()->prepare("SELECT nome, email FROM users WHERE id = :id");
    $stmt->execute([':id' => $colaboradorId]);
    $colaborador = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$colaborador) {
        http_response_code(404);
        return "Colaborador não encontrado.";
    }

    // 🔹 DEPURAÇÃO
    error_log("🟢 [DEBUG] Portfólio público do colaborador {$colaboradorId}: " . print_r($portfolio, true));

    return View::render('colaboradores/portfolio', [
        'colaborador' => $colaborador,
        'portfolio' => $portfolio
    ]);
}


    /** 🔒 Exige login */
    private function requireLogin() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }
    public function sair()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // ✅ Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header("Location: /firehouse-php/public/auth/login");
        exit;
    }

    try {
        // 🔹 Atualiza o banco para remover o modo colaborador
        $sql = "UPDATE users SET is_colaborador = 0 WHERE id = :id";
        $stmt = \DB::pdo()->prepare($sql);
        $stmt->execute([':id' => $_SESSION['user_id']]);

        // 🔹 Atualiza a sessão
        $_SESSION['is_colaborador'] = 0;

        // 🔹 Mensagem de debug opcional
        error_log("🟢 [DEBUG] Usuário {$_SESSION['user_id']} saiu do modo colaborador.");

        // 🔹 Redireciona para a home ou perfil
        header("Location: /firehouse-php/public/");
        exit;
    } catch (\Throwable $e) {
        error_log("❌ Erro ao sair do modo colaborador: " . $e->getMessage());
        echo "<h3>Erro ao sair do modo colaborador. Tente novamente mais tarde.</h3>";
    }
}
public function cancelar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $servico_id = $_POST['servico_id'] ?? null;
        $user_id = $_SESSION['user']['id'] ?? null;

        if (!$servico_id || !$user_id) {
            echo json_encode(['success' => false, 'error' => 'Requisição inválida.']);
            return;
        }

        // Verifica se o serviço pertence ao colaborador logado
        $servico = $this->servicoRepo->findById($servico_id);
        if (!$servico || $servico['user_id'] != $user_id) {
            echo json_encode(['success' => false, 'error' => 'Permissão negada.']);
            return;
        }

        // Atualiza status para inativo
        $this->servicoRepo->atualizarStatus($servico_id, 'inativo');

        echo json_encode(['success' => true]);
        return;
    }

    echo json_encode(['success' => false, 'error' => 'Método inválido.']);
}

public function all() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // 🔹 Filtros básicos
    $filtros = [
        'nome_servico' => $_GET['nome_servico'] ?? null,
        'colaborador' => $_GET['colaborador'] ?? null,
        'status' => $_GET['status'] ?? null,
        'ordenar' => $_GET['ordenar'] ?? null,
    ];

    // 🔹 Se o usuário logado for colaborador → mostra só os dele
    $userId = $_SESSION['user_id'] ?? null;
    $tipo = $_SESSION['tipo'] ?? null;

    if ($tipo === 'colaborador' || $tipo === 'ambos') {
        // Mostra apenas os serviços do próprio colaborador
        $servicos = $this->servicoRepo->buscarPorUsuario($userId);
        $modo = 'colaborador';
    } else {
        // Mostra todos os serviços públicos
        $servicos = $this->servicoRepo->allWithUsers($filtros);
        $modo = 'publico';
    }

    return View::render('colaboradores/all', [
        'servicos' => $servicos,
        'filtros' => $filtros,
        'modo' => $modo
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

        $this->servicoRepo->create([
            'nome' => $nome,
            'descricao' => $descricao,
            'user_id' => $_SESSION['user_id']
        ]);

        header('Location: /firehouse-php/public/colaboradores');
        exit;
    }

    /** 🔹 Exibe o portfólio do colaborador logado */
  public function portfolio(): string {
    $this->requireLogin();

    // 🔹 Se houver ID na URL, usa ele; senão, mostra o portfólio do logado
    $colaboradorId = $_GET['colaborador_id'] ?? $_SESSION['user_id'];

    // 🔹 Busca o portfólio desse colaborador
    $portfolio = $this->colabRepo->getPortfolioByColaborador((int)$colaboradorId);

    // 🔹 Busca dados básicos do colaborador (nome e email)
    $stmt = \DB::pdo()->prepare("SELECT nome, email FROM users WHERE id = :id");
    $stmt->execute([':id' => $colaboradorId]);
    $colaborador = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$colaborador) {
        http_response_code(404);
        return "Colaborador não encontrado.";
    }

    // 🔹 Renderiza a mesma view
    return View::render('colaboradores/portfolio', [
        'colaborador' => $colaborador,
        'portfolio' => $portfolio
    ]);
}


    /** 🔹 Ativa modo colaborador */
    public function ativar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header("Location: /firehouse-php/public/auth/login");
            exit;
        }

        try {
            $sql = "UPDATE users SET is_colaborador = 1 WHERE id = :id";
            $stmt = \DB::pdo()->prepare($sql);
            $stmt->execute([':id' => $userId]);

            $_SESSION['is_colaborador'] = 1;

            header("Location: /firehouse-php/public");
            exit;
        } catch (\PDOException $e) {
            error_log("Erro ao ativar colaborador: " . $e->getMessage());
            echo "<h3>Erro ao ativar colaborador. Contate o administrador.</h3>";
        }
    }
}
