<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\EventoRepository;
use App\Repositories\ComentarioRepository;

class EventoController {
    private EventoRepository $repo;

    public function __construct() {
        $this->repo = new EventoRepository();
    }

    /**
     * Lista todos os eventos (geral)
     */
    public function all() {
        $eventos = $this->repo->all();
        return View::render('eventos/all', ['eventos' => $eventos]);
    }

    /**
     * Lista apenas os eventos do usuário logado
     */
    public function myEvents() {
        require_login();
        $eventos = $this->repo->allByUser($_SESSION['uid']);
        return View::render('eventos/my', ['eventos' => $eventos]);
    }

    /**
     * Formulário de criação
     */
    public function create() {
        require_login();
        return View::render('eventos/create');
    }

    /**
     * Salva novo evento
     */
    public function store() {
        require_login();

        $data = [
            'user_id'     => $_SESSION['uid'],
            'titulo'      => $_POST['titulo'] ?? '',
            'local'       => $_POST['local'] ?? '',
            'servicos'    => is_array($_POST['servicos'] ?? null) 
                                ? implode(',', $_POST['servicos']) 
                                : ($_POST['servicos'] ?? ''), 
            'tipo'        => $_POST['tipo'] ?? '',
            'data_evento' => $_POST['data_evento'] ?? '',
            'descricao'   => $_POST['descricao'] ?? '',
        ];

        if (trim($data['titulo']) === '' || trim($data['local']) === '' || trim($data['tipo']) === '' || trim($data['data_evento']) === '') {
            return View::render('eventos/create', ['error' => 'Preencha todos os campos obrigatórios.']);
        }

        $this->repo->create($data);

        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    /**
     * Formulário de edição
     */
    public function edit() {
        require_login();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        $evento = $this->repo->findById((int)$id);

        if (!$evento || $evento['user_id'] != $_SESSION['uid']) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        return View::render('eventos/edit', ['evento' => $evento]);
    }

    /**
     * Atualiza evento
     */
    public function update() {
        require_login();
        $id = $_POST['id'] ?? null;

        if (!$id || !$this->repo->belongsToUser($id, $_SESSION['uid'])) {
            header('Location: /firehouse-php/public/meus-eventos');
            exit;
        }

        $data = [
            'titulo'      => $_POST['titulo'] ?? '',
            'local'       => $_POST['local'] ?? '',
            'servicos'    => is_array($_POST['servicos'] ?? null) 
                                ? implode(',', $_POST['servicos']) 
                                : ($_POST['servicos'] ?? ''), 
            'tipo'        => $_POST['tipo'] ?? '',
            'data_evento' => $_POST['data_evento'] ?? '',
            'descricao'   => $_POST['descricao'] ?? '',
        ];

        $this->repo->update((int)$id, $data);

        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    /**
     * Exclui evento
     */
    public function delete() {
        require_login();
        $id = $_GET['id'] ?? null;

        if ($id && $this->repo->belongsToUser($id, $_SESSION['uid'])) {
            $this->repo->deleteById((int)$id, $_SESSION['uid']);
        }

        header('Location: /firehouse-php/public/meus-eventos');
        exit;
    }

    /**
     * Página de detalhes de evento (com comentários)
     */
    public function view() {
        require_login();
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) { 
            header('Location: /firehouse-php/public/eventos'); 
            exit; 
        }

        $evento = $this->repo->findById($id);
        if (!$evento) { 
            header('Location: /firehouse-php/public/eventos'); 
            exit; 
        }

        $comentarioRepo = new ComentarioRepository();
        $comentarios = $comentarioRepo->allByEvento($id);

        return View::render('eventos/view', [
            'evento' => $evento,
            'comentarios' => $comentarios
        ]);
    }

    /**
     * Salvar comentário
     */
    public function comentar() {
        require_login();

        $eventoId = $_POST['evento_id'] ?? null;
        $conteudo = trim($_POST['conteudo'] ?? '');

        if (!$eventoId || $conteudo === '') {
            header('Location: /firehouse-php/public/eventos/view?id=' . urlencode($eventoId));
            exit;
        }

        $comentarioRepo = new ComentarioRepository();
        $comentarioRepo->create([
            'evento_id' => (int)$eventoId,
            'user_id'   => $_SESSION['uid'],
            'conteudo'  => $conteudo,
        ]);

        header('Location: /firehouse-php/public/eventos/view?id=' . urlencode($eventoId));
        exit;
    }
}
