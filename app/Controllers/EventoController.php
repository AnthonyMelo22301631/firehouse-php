<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\EventoRepository;
use App\Repositories\AvaliacaoRepository;
use App\Repositories\ColaboradorRepository;
use App\Repositories\ServicoRepository;

class EventoController
{
    private EventoRepository $repo;
    private AvaliacaoRepository $avaliacaoRepo;
    private ColaboradorRepository $colabRepo;
    private ServicoRepository $servicoRepo;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->repo = new EventoRepository();
        $this->avaliacaoRepo = new AvaliacaoRepository();
        $this->colabRepo = new ColaboradorRepository();
        $this->servicoRepo = new ServicoRepository();
    }

    /** 🔒 Garante que o usuário esteja logado */
    private function require_login(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    /** 🔹 Lista todos os eventos */
    public function all(): string
    {
        $eventos = $this->repo->all();
        return View::render('eventos/all', ['eventos' => $eventos]);
    }

    /** 🔹 Lista apenas os eventos do usuário logado */
    public function myEvents(): string
    {
        $this->require_login();
        $eventos = $this->repo->allByUser((int)$_SESSION['user_id']);
        return View::render('eventos/my', ['eventos' => $eventos]);
    }

    /** 🔹 Página de criação de evento */
    public function create(): string
    {
        $this->require_login();
        return View::render('eventos/create');
    }

    /** 🔹 Armazena novo evento */
    public function store(): void
    {
        $this->require_login();

        $data = [
            'user_id' => $_SESSION['user_id'],
            'titulo' => trim($_POST['titulo'] ?? ''),
            'tipo' => trim($_POST['tipo'] ?? ''),
            'local' => trim($_POST['local'] ?? ''),
            'cidade' => trim($_POST['cidade'] ?? ''),
            'estado' => trim($_POST['estado'] ?? ''),
            'servicos' => is_array($_POST['servicos'] ?? null)
                ? implode(',', $_POST['servicos'])
                : trim($_POST['servicos'] ?? ''),
            'data_evento' => trim($_POST['data_evento'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'status_evento' => 'aberto'
        ];

        $this->repo->create($data);
        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    /** 🔹 Página de edição */
    public function edit(): string
    {
        $this->require_login();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        $evento = $this->repo->findById((int)$id);
        if (!$evento) {
            http_response_code(404);
            return "Evento não encontrado.";
        }

        return View::render('eventos/edit', ['evento' => $evento]);
    }

    /** 🔹 Atualiza os dados de um evento */
    public function update(): void
    {
        $this->require_login();

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        $data = [
            'titulo' => trim($_POST['titulo'] ?? ''),
            'tipo' => trim($_POST['tipo'] ?? ''),
            'local' => trim($_POST['local'] ?? ''),
            'cidade' => trim($_POST['cidade'] ?? ''),
            'estado' => trim($_POST['estado'] ?? ''),
            'servicos' => is_array($_POST['servicos'] ?? null)
                ? implode(',', $_POST['servicos'])
                : trim($_POST['servicos'] ?? ''),
            'data_evento' => trim($_POST['data_evento'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? '')
        ];

        $this->repo->update((int)$id, $data);
        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    /** 🔹 Exibe um evento específico */
    public function view(): string
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/eventos');
            exit;
        }

        $evento = $this->repo->findById((int)$id);
        return View::render('eventos/view', ['evento' => $evento]);
    }

    /** ✅ Atualiza status e redireciona para feedback ao finalizar */
    public function atualizarStatus(): void
    {
        $this->require_login();

        $eventoId = $_POST['evento_id'] ?? null;
        $novoStatus = $_POST['status_evento'] ?? null;

        if (!$eventoId || !$novoStatus) {
            echo json_encode(['success' => false, 'error' => 'Dados ausentes']);
            return;
        }

        $ok = $this->repo->atualizarStatusEvento((int)$eventoId, $novoStatus);

        if ($ok && $novoStatus === 'finalizado') {
            echo json_encode([
                'success' => true,
                'redirect' => "/firehouse-php/public/eventos/feedback?id={$eventoId}"
            ]);
        } else {
            echo json_encode(['success' => $ok]);
        }
    }

    /** ✅ Vincular um serviço ao evento via código */
    public function vincularPorCodigo(): void
    {
        $this->require_login();

        $eventoId = $_POST['evento_id'] ?? null;
        $codigoServico = trim($_POST['codigo_servico'] ?? '');

        if (!$eventoId || !$codigoServico) {
            echo json_encode(['success' => false, 'error' => 'Dados ausentes.']);
            exit;
        }

        $servico = $this->servicoRepo->findByCodigo($codigoServico);

        if (!$servico) {
            echo json_encode(['success' => false, 'error' => 'Serviço não encontrado.']);
            exit;
        }

        $ok = $this->repo->vincularServico((int)$eventoId, (int)$servico['id']);

        echo json_encode(['success' => $ok]);
        exit;
    }

    /** ✅ Página de feedback (cliente avalia colaboradores) */
    public function feedback(): string
    {
        $this->require_login();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        $evento = $this->repo->findById((int)$id);
        if (!$evento) {
            http_response_code(404);
            return "Evento não encontrado.";
        }

        $colaboradores = $this->repo->getColaboradoresDoEvento((int)$id);

        return View::render('eventos/feedback', [
            'evento' => $evento,
            'colaboradores' => $colaboradores
        ]);
    }

    /** ✅ Salva o feedback dado pelo cliente */
    public function salvarFeedback(): void
    {
        $this->require_login();

        $eventoId = $_POST['evento_id'] ?? null;
        $avaliacoes = $_POST['avaliacoes'] ?? [];

        if (!$eventoId || empty($avaliacoes)) {
            header("Location: /firehouse-php/public/eventos/feedback?id=$eventoId");
            exit;
        }

        foreach ($avaliacoes as $colabId => $dados) {
            $nota = (int)($dados['nota'] ?? 0);
            $comentario = trim($dados['comentario'] ?? '');

            if ($nota > 0) {
                $this->avaliacaoRepo->criar([
                    'evento_id' => $eventoId,
                    'colaborador_id' => $colabId,
                    'cliente_id' => $_SESSION['user_id'],
                    'nota' => $nota,
                    'comentario' => $comentario
                ]);
            }
        }

        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }
}
