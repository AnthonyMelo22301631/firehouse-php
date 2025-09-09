<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS (com cache-buster) -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/register.css?v=3">
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
      <?php if (!empty($_SESSION['uid'])): ?>
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
    <h2 class="titulo">📝 Cadastrar</h2>

    <?php if (!empty($error)): ?>
      <p class="erro"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="/firehouse-php/public/auth/register" class="form-card">
      <label for="name">Nome</label>
      <input id="name" type="text" name="name" required>

      <label for="email">Email</label>
      <input id="email" type="email" name="email" required>

      <label for="password">Senha (mín. 6)</label>
      <input id="password" type="password" name="password" minlength="6" required>

      <button type="submit" class="btn">Cadastrar</button>
    </form>

    <p class="link-login">
      <a href="/firehouse-php/public/auth/login">Já tenho conta</a>
    </p>
  </div>
</main>

<footer class="footer">
  <div class="footer-container">
    <p>© <?= date('Y') ?> <span class="marca">🔥 FireHouse</span> — Todos os direitos reservados</p>
    <p class="creditos">Desenvolvido com ❤ para o projeto escolar</p>
  </div>
</footer>
</body>
</html>
