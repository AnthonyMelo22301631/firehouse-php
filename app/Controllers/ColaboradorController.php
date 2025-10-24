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
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->repo = new ServicoRepository();
        $this->userRepo = new UserRepository();
        $this->avaliacaoRepo = new AvaliacaoRepository();
    }

    public function all() {
        $servicos = $this->repo->allWithUsers();
        return View::render('colaboradores/all', ['servicos' => $servicos]);
    }

    public function create() {
        $this->requireLogin();
        return View::render('colaboradores/create');
    }

    public function store() {
        $this->requireLogin();

        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'user_id' => $_SESSION['user_id']
        ];

        $this->repo->create($data);
        header('Location: /firehouse-php/public/colaboradores');
        exit;
    }

    private function requireLogin() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    // ✅ Novo portfólio completo
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
}
