<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\ServicoRepository;
use App\Repositories\UserRepository;
use App\Repositories\AvaliacaoRepository;

class ColaboradorController {
    private ServicoRepository $repo;
    private UserRepository $userRepo;
    private AvaliacaoRepository $avaliacaoRepo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->repo = new ServicoRepository();
        $this->userRepo = new UserRepository();
        $this->avaliacaoRepo = new AvaliacaoRepository();
    }

    /** 🔹 Lista todos os colaboradores (serviços) */
    public function all() {
        $servicos = $this->repo->allWithUsers();
        return View::render('colaboradores/all', ['servicos' => $servicos]);
    }

    /** 🔹 Exibe formulário para criar novo serviço */
    public function create() {
        $this->requireLogin();
        return View::render('colaboradores/create');
    }

    /** 🔹 Salva novo serviço no banco */
    public function store() {
        $this->requireLogin();

        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'preco' => $_POST['preco'] ?? null,
            'user_id' => $_SESSION['user_id']
        ];

        $this->repo->create($data);
        header('Location: /firehouse-php/public/colaboradores');
        exit;
    }

    /** 🔒 Exige login */
    private function requireLogin() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    /** 🔹 Exibe portfólio do colaborador logado */
    public function portfolio() {
        $this->requireLogin();

        $colaboradorId = $_SESSION['user_id'];
        $colaborador = $this->userRepo->findById($colaboradorId);
        $eventosFinalizados = $this->avaliacaoRepo->buscarPorColaborador($colaboradorId);

        return View::render('colaboradores/portfolio', [
            'colaborador' => $colaborador,
            'eventosFinalizados' => $eventosFinalizados
        ]);
    }

    /** 🆕 Exibe detalhes de um colaborador específico */
    public function view() {
    $this->requireLogin();

    // Pega o ID via query string
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: /firehouse-php/public/colaboradores');
        exit;
    }

    // Busca o serviço correspondente
    $servico = $this->repo->findById($id);
    if (!$servico) {
        echo "Serviço não encontrado.";
        return;
    }

    // Busca o colaborador que criou o serviço
    $colaborador = $this->userRepo->findById($servico['user_id'] ?? 0);

    // Renderiza a view
    return View::render('colaboradores/view', [
        'servico' => $servico,
        'colaborador' => $colaborador
    ]);
}

}
