<?php


require __DIR__ . '/../bootstrap.php';

use App\Core\Router;

$router = new Router();

/**
 * Home
 */
$router->get('/', 'HomeController@index');

/**
 * Autenticação
 */
$router->get('/auth/login', 'AuthController@showLogin');
$router->post('/auth/login', 'AuthController@login');

$router->get('/auth/register', 'AuthController@showRegister');
$router->post('/auth/register', 'AuthController@register');

$router->get('/auth/logout', 'AuthController@logout');

/**
 * Perfil
 */
$router->get('/auth/perfil', 'AuthController@perfil');

/**
 * Eventos
 * - /eventos           => lista geral (todos os eventos)
 * - /meus-eventos      => apenas eventos do usuário logado
 * - /eventos/create    => formulário de criação
 * - /eventos/store     => salvar evento (POST)
 * - /eventos/edit      => formulário de edição
 * - /eventos/update    => atualizar evento (POST)
 * - /eventos/delete    => deletar evento
 */
$router->get('/eventos', 'EventoController@all');             // lista geral
$router->get('/meus-eventos', 'EventoController@myEvents');   // meus eventos
$router->get('/eventos/create', 'EventoController@create');   // formulário de criação
$router->post('/eventos/store', 'EventoController@store');    // salvar evento
$router->get('/eventos/edit', 'EventoController@edit');       // editar evento ?id=123
$router->post('/eventos/update', 'EventoController@update');  // atualizar evento
$router->get('/eventos/delete', 'EventoController@delete');   // deletar evento ?id=123
$router->get('/eventos/view', 'EventoController@view');   // detalhes do evento
$router->post('/comentarios/store', 'ComentarioController@store'); // (se for comentar)
$router->post('/eventos/comentar', 'EventoController@comentar');

/**
 * Despacho
 */
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
