<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\ServicoRepository;

class ServicoController {
    private ServicoRepository $repo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->repo = new ServicoRepository();
    }

    private function require_login() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    // 🟢 Listar todos os serviços disponíveis
    public function all() {
        $servicos = $this->repo->allWithUsers();
        return View::render('servicos/all', ['servicos' => $servicos]);
    }

    // 🟢 Serviços do colaborador logado
    public function my() {
        $this->require_login();
        $servicos = $this->repo->allByUser((int)$_SESSION['user_id']);
        return View::render('servicos/my', ['servicos' => $servicos]);
    }

    // 🟢 Formulário de criação
    public function create() {
        $this->require_login();
        return View::render('servicos/create');
    }

    // 🟢 Salvar novo serviço (gera código automático)
    public function store() {
        $this->require_login();

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $preco = trim($_POST['preco'] ?? '');

        if ($nome === '' || $descricao === '') {
            return View::render('servicos/create', ['error' => 'Preencha todos os campos obrigatórios.']);
        }

        // 🔹 Gera código único (ex: SRV-3F5A9C)
        $codigo = 'SRV-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        $data = [
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco,
            'user_id' => $_SESSION['user_id'],
            'codigo_servico' => $codigo,
            'status' => 'ativo'
        ];

        $this->repo->createWithCodigo($data);

        // Mensagem de confirmação com o código
        return View::render('servicos/success', [
            'message' => "Serviço cadastrado com sucesso! Código: <b>{$codigo}</b>"
        ]);
    }

    // 🔍 Ver detalhes de um serviço específico
    public function view() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/servicos');
            exit;
        }

        $servico = $this->repo->findById((int)$id);
        if (!$servico) {
            return View::render('servicos/all', ['error' => 'Serviço não encontrado.']);
        }

        return View::render('servicos/view', ['servico' => $servico]);
    }
}
