<?php
// 🔒 Inicia sessão e ativa debug
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../bootstrap.php';
use App\Core\Router;

$router = new Router();

// =======================
// 🏠 Home
// =======================
$router->get('/', 'HomeController@index');

// =======================
// 🔑 Autenticação
// =======================
$router->get('/auth/login', 'AuthController@showLogin');
$router->post('/auth/login', 'AuthController@login');
$router->get('/auth/register', 'AuthController@showRegister');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/logout', 'AuthController@logout');

// =======================
// 👤 Perfil
// =======================
$router->get('/auth/perfil', 'AuthController@perfil');

// =======================
// ℹ️ Sobre Nós
// =======================
$router->get('/sobrenos', 'SobreController@index');

// =======================
// FAQ e Contato
// =======================
$router->get('/faq', 'FaqController@index');
$router->get('/contato', 'ContatoController@index');

// =======================
// 🎉 Eventos
// =======================
$router->get('/eventos', 'EventoController@all');
$router->get('/meus-eventos', 'EventoController@myEvents');
$router->get('/eventos/create', 'EventoController@create');
$router->post('/eventos/store', 'EventoController@store');
$router->get('/eventos/edit', 'EventoController@edit');
$router->post('/eventos/update', 'EventoController@update');
$router->get('/eventos/delete', 'EventoController@delete');
$router->get('/eventos/view', 'EventoController@view');

// ✅ Novas rotas do sistema de status/serviços
$router->post('/eventos/atualizar-status', 'EventoController@atualizarStatus');
$router->post('/eventos/marcar-servico', 'EventoController@marcarServico');
$router->post('/eventos/vincularPorCodigo', 'EventoController@vincularPorCodigo');

// =======================
// 💬 Comentários
// =======================
$router->post('/comentarios/store', 'ComentarioController@store');
$router->get('/contato', 'ContatoController@index');
$router->post('/contato/enviar', 'ContatoController@enviar');
// =======================
// 🤝 Colaboradores
// =======================
$router->get('/colaboradores', 'ColaboradorController@all');
$router->get('/colaboradores/create', 'ColaboradorController@create');
$router->post('/colaboradores/store', 'ColaboradorController@store');
$router->get('/colaboradores/view', 'ColaboradorController@view');
$router->post('/colaboradores/ativar', 'ColaboradorController@ativar');
$router->post('/colaboradores/sair', 'ColaboradorController@sair');
$router->get('/colaboradores/servicos', 'ColaboradorController@servicos');
$router->get('/colaboradores/meus-servicos', 'ColaboradorController@meusServicos');
$router->post('/colaboradores/cancelar-servico', 'ColaboradorController@cancelarServico');

$router->get('/colaboradores/portfolio', 'ColaboradorController@portfolio');
$router->post('/colaboradores/cancelar', 'ColaboradoresController@cancelar');
$router->get('/auth/termos', 'AuthController@termos');
$router->post('/auth/aceitar-termos', 'AuthController@aceitarTermos');

$router->get('/colaboradores/portfolio-public', 'ColaboradorController@portfolioPublic');
$router->post('/eventos/finalizar', 'EventoController@finalizar');
$router->post('/eventos/vincularServico', 'EventoController@vincularServico');
$router->post('/eventos/salvarAvaliacao', 'EventoController@salvarAvaliacao');

$router->get('/eventos/avaliar', 'EventoController@avaliarView');


// =======================
// 💬 Chat
// =======================
$router->post('/chat/iniciar', 'ChatController@iniciar');
$router->get('/chat/view', 'ChatController@view');

// =======================
// 🚀 Despacho final
// =======================
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
