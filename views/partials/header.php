<?php
// Garante que a sessão esteja ativa
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!-- Importa o CSS do header -->
<link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">

<header class="navbar">
  <div class="navbar-container">

    <!-- LOGO -->
    <div class="logo">
      <img src="/firehouse-php/public/assets/imagens/LOGO_FIREHOUSE_3.png" alt="FireHouse Logo">
      <span class="logo-text">FireHouse</span>
    </div>

    <!-- LINKS PRINCIPAIS -->
    <nav class="nav-links">
      <a href="/firehouse-php/public/">Home</a>
      <a href="/firehouse-php/public/eventos">Eventos</a>
      <a href="/firehouse-php/public/colaboradores">Colaboradores</a>
      <a href="/firehouse-php/public/sobrenos">Sobre Nós</a>
      <a href="/firehouse-php/public/faq">FAQ</a>
      <a href="/firehouse-php/public/contato">Contato</a>
    </nav>

    <!-- AÇÕES DO USUÁRIO -->
    <div class="nav-actions">
      <?php if (!empty($_SESSION['user_id'])): ?>
        <?php if (!empty($_SESSION['is_colaborador'])): ?>
          <!-- MODO COLABORADOR -->
          <a href="/firehouse-php/public/colaboradores/meus-servicos">Meus Serviços</a>
          <a href="/firehouse-php/public/colaboradores/create">Cadastrar Serviço</a>
          <a href="/firehouse-php/public/colaboradores/portfolio">Portfólio</a>
          <a href="/firehouse-php/public/auth/perfil">Perfil</a>
          <a href="/firehouse-php/public/auth/logout" class="logout">Sair</a>
        <?php else: ?>
          <!-- MODO CLIENTE -->
          <a href="/firehouse-php/public/meus-eventos">Meus Eventos</a>
          <a href="/firehouse-php/public/eventos/create">Criar Evento</a>
          <a href="/firehouse-php/public/auth/perfil">Perfil</a>
          <a href="/firehouse-php/public/auth/logout" class="logout">Sair</a>
        <?php endif; ?>
      <?php else: ?>
        <!-- NÃO LOGADO -->
        <a href="/firehouse-php/public/auth/login" class="login">Entrar</a>
        <a href="/firehouse-php/public/auth/register" class="register">Cadastrar</a>
      <?php endif; ?>
    </div>

  </div>
</header>
