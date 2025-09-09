<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Meu Perfil | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS único -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/perfil.css">
</head>
<body>
<header class="navbar">
  <div class="navbar-container">
    <!-- LOGO -->
    <div class="logo">
      <a href="/firehouse-php/public/">🔥 FireHouse</a>
    </div>

    <!-- LINKS PRINCIPAIS -->
    <nav class="nav-links">
      <a href="/firehouse-php/public/colaboradores">Colaboradores</a>
      <a href="/firehouse-php/public/eventos/create">Criar Evento</a>
      <a href="/firehouse-php/public/eventos">Eventos</a>
    </nav>

      <!-- AÇÕES -->
  <div class="nav-actions">
  <?php if (!empty($_SESSION['user_id'])): ?>
    <a href="/firehouse-php/public/meus-eventos">Meus Eventos</a>
    <a href="/firehouse-php/public/auth/perfil">Perfil</a>
    <a href="/firehouse-php/public/auth/logout">Sair</a>
  <?php else: ?>
    <a href="/firehouse-php/public/auth/login">Entrar</a>
    <a href="/firehouse-php/public/auth/register">Cadastrar</a>
  <?php endif; ?>
</div>
  </div>
</header>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">🙍 Meu Perfil</h2>

    <section class="card perfil">
      <div class="avatar" aria-hidden="true">
        <?php
          $nome = $user->name ?? '';
          $ini  = function_exists('mb_substr') ? mb_substr($nome, 0, 1, 'UTF-8') : substr($nome, 0, 1);
          echo htmlspecialchars(mb_strtoupper($ini, 'UTF-8'));
        ?>
      </div>

      <div class="info">
        <div class="linha">
          <span class="label">Nome:</span>
          <span class="valor"><?= htmlspecialchars($user->name) ?></span>
        </div>
        <div class="linha">
          <span class="label">Email:</span>
          <span class="valor"><?= htmlspecialchars($user->email) ?></span>
        </div>
      </div>

      <div class="acoes">
        <a class="btn secundario" href="/firehouse-php/public/eventos/my">🎟️ Meus eventos</a>
        <a class="btn primario" href="/firehouse-php/public/eventos/create">➕ Criar evento</a>
        <a class="btn danger" href="/firehouse-php/public/auth/logout">🚪 Sair</a>
      </div>
    </section>
  </div>
</main>

<footer class="footer">
  <div class="footer-container">
    <p>© 2025 <span class="marca">🔥 FireHouse</span> — Todos os direitos reservados</p>
    <p class="creditos">Desenvolvido com ❤ para o projeto escolar</p>
  </div>
</footer>
</body>
</html>
