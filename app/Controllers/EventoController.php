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
public function avaliarView(): string {
    $this->require_login();

    $eventoId = $_GET['evento_id'] ?? null;
    $servicoId = $_GET['servico_id'] ?? null;

    if (!$eventoId || !$servicoId) {
        return "Parâmetros inválidos.";
    }

    $evento = $this->repo->findById((int)$eventoId);
    $servico = $this->servicoRepo->find((int)$servicoId);

    if (!$evento || !$servico) {
        return "Evento ou serviço não encontrado.";
    }

    // 🔹 Garante que temos o ID do colaborador dono do serviço
    $colaboradorId = $servico['user_id'] ?? null;

    return View::render('eventos/avaliar', [
        'evento' => $evento,
        'servico' => $servico,
        'colaborador_id' => $colaboradorId
    ]);
}



    private function require_login(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /firehouse-php/public/auth/login');
            exit;
        }
    }

   public function all(): string {
    // 🔹 Captura filtros via GET
    $filtros = [
        'tipo' => $_GET['tipo'] ?? null,
        'cidade' => $_GET['cidade'] ?? null,
        'estado' => $_GET['estado'] ?? null,
        'status_evento' => $_GET['status_evento'] ?? null,
        'data_min' => $_GET['data_min'] ?? null,
    ];

    // 🔹 Passa filtros para o repositório
    $eventos = $this->repo->all($filtros);

    // 🔹 Renderiza view com dados e filtros atuais (pra preencher os campos)
    return View::render('eventos/all', [
        'eventos' => $eventos,
        'filtros' => $filtros
    ]);
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

    // 🔹 Busca o evento no banco
    $evento = $this->repo->findById((int)$id);
    if (!$evento) {
        http_response_code(404);
        return "Evento não encontrado.";
    }

    // 🔹 Busca todos os serviços disponíveis (ainda não vinculados)
    $servicosDisponiveis = $this->servicoRepo->getServicosDisponiveis();

    // 🔹 Envia dados para a view
    return View::render('eventos/edit', [
        'evento' => $evento,
        'servicosDisponiveis' => $servicosDisponiveis
    ]);
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

    public function delete(): void {
    $this->require_login(); // Garante que o usuário está logado

    // 🔹 Captura o ID via GET (ex: /eventos/delete?id=5)
    $id = $_GET['id'] ?? null;

    if (!$id) {
        // Redireciona se o ID não foi informado
        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    try {
        // 🔹 Tenta excluir o evento pelo repositório
        $ok = $this->repo->delete((int)$id);

        if ($ok) {
            // ✅ Exclusão bem-sucedida → redireciona para a listagem do usuário
            $_SESSION['flash_success'] = "Evento excluído com sucesso!";
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        } else {
            // ❌ Falha na exclusão
            $_SESSION['flash_error'] = "Erro ao excluir o evento.";
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

    } catch (\Throwable $e) {
        // ⚠️ Loga erro para depuração
        error_log("Erro ao excluir evento: " . $e->getMessage());
        $_SESSION['flash_error'] = "Erro interno ao tentar excluir o evento.";
        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }
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

public function salvarAvaliacao()
{
    try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔹 Captura os dados enviados via formulário
        $colaboradorId = $_POST['colaborador_id'] ?? null;
        $eventoId = $_POST['evento_id'] ?? null;
        $servicoId = $_POST['servico_id'] ?? null;
        $nota = $_POST['nota'] ?? null;
        $comentario = $_POST['comentario'] ?? null;

        // 🔍 Log de depuração
        error_log("📩 [DEBUG] Dados recebidos em salvarAvaliacao(): " . print_r($_POST, true));

        // 🔹 Validação básica
        if (empty($colaboradorId) || empty($eventoId) || empty($servicoId)) {
            echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
            exit;
        }

        if (empty($nota)) {
            echo json_encode(['success' => false, 'error' => 'Informe uma nota para a avaliação.']);
            exit;
        }

        // 🔹 Busca o criador do evento e o nome do cliente
        $evento = $this->repo->findById((int)$eventoId);
        $criadorId = $evento['user_id'] ?? null;

        $clienteNome = 'Cliente Anônimo';
        if ($criadorId) {
            $stmt = \DB::pdo()->prepare("SELECT nome FROM users WHERE id = :id");
            $stmt->execute([':id' => $criadorId]);
            $clienteNome = $stmt->fetchColumn() ?: 'Cliente Anônimo';
        }

        // 🔹 Insere no portfólio com data atual
        $this->colabRepo->adicionarAoPortfolio([
            'colaborador_id' => $colaboradorId,
            'evento_id' => $eventoId,
            'servico_id' => $servicoId,
            'comentario' => $comentario,
            'nota' => $nota,
            'cliente_nome' => $clienteNome
        ]);

        // 🔹 Resposta JSON para o fetch()
        echo json_encode(['success' => true, 'message' => 'Avaliação registrada com sucesso!']);
        exit;

    } catch (\Throwable $e) {
        // ⚠️ Log detalhado do erro
        error_log("🔥 ERRO AO SALVAR AVALIAÇÃO: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Erro interno no servidor. Detalhe: ' . $e->getMessage()
        ]);
        exit;
    }
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

    public function vincularServico() {
    $this->require_login();
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json; charset=utf-8');

    try {
        $eventoId = $_POST['evento_id'] ?? null;
        $servicoId = $_POST['servico_id'] ?? null;

        if (!$eventoId || !$servicoId) {
            echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
            exit;
        }

        $ok = $this->repo->vincularServico($eventoId, $servicoId);

        if ($ok) {
            echo json_encode(['success' => true, 'message' => 'Serviço vinculado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao vincular serviço ou já vinculado.']);
        }
    } catch (\Throwable $e) {
        error_log("Erro ao vincular serviço: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Erro interno no servidor.']);
    }
    exit;
}



    /** 🔹 Finalizar evento (muda status e envia ao portfólio) */
    public function finalizar(): void {
    $this->require_login();
    header('Content-Type: application/json; charset=utf-8');

    try {
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

        echo json_encode(['success' => true, 'message' => 'Evento finalizado com sucesso!']);
        exit;
    } catch (\Throwable $e) {
        error_log("Erro ao finalizar evento: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Erro interno no servidor.']);
        exit;
    }
}

}
