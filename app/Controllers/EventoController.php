<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\EventoRepository;
use App\Repositories\AvaliacaoRepository;
use App\Repositories\ColaboradorRepository;
use App\Repositories\ServicoRepository;

class EventoController {
    private EventoRepository $repo;
    private AvaliacaoRepository $avaliacaoRepo;
    private ColaboradorRepository $colabRepo;
    private ServicoRepository $servicoRepo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->repo = new EventoRepository();
        $this->avaliacaoRepo = new AvaliacaoRepository();
        $this->colabRepo = new ColaboradorRepository();
        $this->servicoRepo = new ServicoRepository();
    }

    private function require_login(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

    public function all(): string {
        $eventos = $this->repo->all();
        return View::render('eventos/all', ['eventos' => $eventos]);
    }

    public function myEvents(): string {
        $this->require_login();
        $eventos = $this->repo->allByUser((int)$_SESSION['user_id']);
        return View::render('eventos/my', ['eventos' => $eventos]);
    }

    public function create(): string {
        $this->require_login();
        return View::render('eventos/create');
    }

    public function store(): void {
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

    public function edit(): string {
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

    public function update(): void {
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

    public function view(): string {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/eventos');
            exit;
        }
        $evento = $this->repo->findById((int)$id);
        return View::render('eventos/view', ['evento' => $evento]);
    }
    public function feedback(): string {
    $this->require_login();
    $id = $_GET['id'] ?? null;
    $colaboradores = $this->repo->getColaboradoresDoEvento((int)$id);
    return View::render('eventos/feedback', [
        'evento_id' => $id,
        'colaboradores' => $colaboradores
    ]);
}

public function salvarFeedback(): void {
    $this->require_login();
    $eventoId = $_POST['evento_id'];
    foreach ($_POST['avaliacoes'] as $colabId => $dados) {
        $this->avaliacaoRepo->salvar([
            'evento_id' => $eventoId,
            'colaborador_id' => $colabId,
            'nota' => $dados['nota'],
            'comentario' => $dados['comentario']
        ]);
    }
    header('Location: /firehouse-php/public/meus-eventos');
    exit;
}


    /** ✅ Atualiza status e redireciona para feedback ao finalizar */
    public function atualizarStatus(): void {
        $this->require_login();
        $eventoId = $_POST['evento_id'] ?? null;
        $novoStatus = $_POST['status_evento'] ?? null;
        if (!$eventoId || !$novoStatus) {
            echo json_encode(['success' => false, 'error' => 'Dados ausentes']);
            exit;
        }
        $ok = $this->repo->atualizarStatusEvento((int)$eventoId, $novoStatus);
        if ($ok && $novoStatus === 'finalizado') {
            echo json_encode([
                'success' => true,
                'redirect' => "/firehouse-php/public/eventos/feedback?id={$eventoId}"
            ]);
            exit;
        } else {
            echo json_encode(['success' => $ok]);
            exit;
        }
    }

    /** ✅ Vincular um serviço ao evento via código */
    public function vincularPorCodigo() {
    // 🔧 LIMPA qualquer saída anterior (evita HTML no JSON)
      $this->require_login(); // ✅ garante sessão ativa
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json; charset=utf-8');

    try {
        $eventoId = $_POST['evento_id'] ?? null;
        $codigo = trim($_POST['codigo_servico'] ?? '');

        if (!$eventoId || !$codigo) {
            echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
            exit;
        }

        $servicoRepo = new \App\Repositories\ServicoRepository();
        $servico = $servicoRepo->findByCodigo($codigo);

        if (!$servico) {
            echo json_encode(['success' => false, 'error' => 'Código de serviço inválido.']);
            exit;
        }

        $ok = $this->repo->vincularServico($eventoId, $servico['id']);

        if ($ok) {
            echo json_encode(['success' => true, 'message' => 'Serviço vinculado com sucesso!']);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Serviço já vinculado ou erro ao vincular.']);
            exit;
        }

    } catch (\Throwable $e) {
        error_log("Erro ao vincular serviço: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Erro interno no servidor.']);
        exit;
    }
}


    /** 🔹 Finalizar evento (muda status e envia ao portfólio) */
    public function finalizar(): void {
        $this->require_login();
        header('Content-Type: application/json');

        $eventoId = $_POST['evento_id'] ?? null;
        if (!$eventoId) {
            echo json_encode(['success' => false, 'error' => 'ID do evento não informado']);
            exit;
        }

        $ok = $this->repo->atualizarStatusEvento((int)$eventoId, 'finalizado');
        if (!$ok) {
            echo json_encode(['success' => false, 'error' => 'Falha ao atualizar status do evento']);
            exit;
        }

        $colaboradores = $this->repo->getColaboradoresDoEvento((int)$eventoId);

        foreach ($colaboradores as $colab) {
            $this->colabRepo->adicionarAoPortfolio([
                'colaborador_id' => $colab['colaborador_id'],
                'evento_id' => $eventoId
            ]);
        }

        echo json_encode([
            'success' => true,
            'redirect' => '/firehouse-php/public/colaboradores/portfolio'
        ]);
        exit;
    }
}
