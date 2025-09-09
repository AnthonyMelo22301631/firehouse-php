<?php
namespace App\Controllers;

use App\Core\View;
use App\Repositories\ComentarioRepository;

class ComentarioController {
    private ComentarioRepository $repo;

    public function __construct() {
        $this->repo = new ComentarioRepository();
    }

    public function store() {
        require_login();

        $eventoId = $_POST['evento_id'] ?? null;
        $conteudo = trim($_POST['conteudo'] ?? '');

        if (!$eventoId || $conteudo === '') {
            header('Location: /firehouse-php/public/eventos');
            exit;
        }

        $this->repo->create([
            'evento_id' => (int)$eventoId,
            'user_id'   => $_SESSION['uid'],
            'conteudo'  => $conteudo
        ]);

        header("Location: /firehouse-php/public/eventos/view?id=$eventoId");
        exit;
    }
}
