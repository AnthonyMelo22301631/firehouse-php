<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Entrar | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS único da página (já contém estilos do header, footer e formulário) -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/login.css">
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
    <h2 class="titulo">🔑 Entrar</h2>

    <!-- mensagem de erro (pode ser exibida via PHP) -->
    <p class="erro" style="display:none;">Email ou senha inválidos</p>

    <form method="post" action="/firehouse-php/public/auth/login" class="form-card">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" required>

      <label for="password">Senha</label>
      <input id="password" type="password" name="password" required>

      <button type="submit" class="btn">Entrar</button>
    </form>

    <p class="link-criar">
      <a href="/firehouse-php/public/auth/register">➕ Criar conta</a>
    </p>
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
